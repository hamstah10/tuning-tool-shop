<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Model\Order;
use Hamstahstudio\TuningToolShop\Domain\Repository\CartItemRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\OrderRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\PaymentMethodRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\ShippingMethodRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class CheckoutController extends ActionController
{
    public function __construct(
        protected readonly CartItemRepository $cartItemRepository,
        protected readonly OrderRepository $orderRepository,
        protected readonly PaymentMethodRepository $paymentMethodRepository,
        protected readonly ShippingMethodRepository $shippingMethodRepository,
        protected readonly PersistenceManager $persistenceManager,
    ) {}

    public function indexAction(): ResponseInterface
    {
        $sessionId = $this->getSessionId();
        $cartItems = $this->cartItemRepository->findBySessionId($sessionId);
        $paymentMethods = $this->paymentMethodRepository->findAll();
        $shippingMethods = $this->shippingMethodRepository->findActive();

        $cartPid = (int)($this->settings['cartPid'] ?? 0);
        $shopPid = (int)($this->settings['shopPid'] ?? 0);

        if ($cartItems->count() === 0) {
            $this->addFlashMessage('Ihr Warenkorb ist leer.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::WARNING);
            if ($cartPid > 0) {
                return $this->redirectToUri($this->uriBuilder->reset()->setTargetPageUid($cartPid)->build());
            }
            return $this->htmlResponse();
        }

        $totals = $this->calculateTotals($cartItems->toArray());
        $totalWeight = $this->calculateTotalWeight($cartItems->toArray());
        $countries = $this->getCountries();
        
        // Filter shipping methods by weight and select the best match
        $availableShippingMethods = $this->filterShippingMethodsByWeight($shippingMethods, $totalWeight);
        $selectedShippingMethod = $this->selectBestShippingMethod($availableShippingMethods, $totalWeight);
        
        $termsLink = $this->buildPageLink((int)($this->settings['termsAndConditionsPid'] ?? 0));
        $privacyLink = $this->buildPageLink((int)($this->settings['privacyPid'] ?? 0));
        $cancellationLink = $this->buildPageLink((int)($this->settings['cancellationPid'] ?? 0));

        $this->view->assignMultiple([
            'cartItems' => $cartItems,
            'paymentMethods' => $paymentMethods,
            'shippingMethods' => $availableShippingMethods,
            'selectedShippingMethod' => $selectedShippingMethod,
            'total' => $totals['gross'],
            'totalNet' => $totals['net'],
            'totalTax' => $totals['tax'],
            'totalWeight' => $totalWeight,
            'cartPid' => $cartPid,
            'shopPid' => $shopPid,
            'countries' => $countries,
            'termsLink' => $termsLink,
            'privacyLink' => $privacyLink,
            'cancellationLink' => $cancellationLink,
        ]);

        return $this->htmlResponse();
    }

    public function processAction(): ResponseInterface
    {
        $sessionId = $this->getSessionId();
        $cartItems = $this->cartItemRepository->findBySessionId($sessionId);

        if ($cartItems->count() === 0) {
            $this->addFlashMessage('Ihr Warenkorb ist leer.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
            return $this->redirect('index', 'Cart');
        }

        $orderData = $this->request->hasArgument('order') ? $this->request->getArgument('order') : [];

        $order = new Order();
        $order->setOrderNumber($this->generateOrderNumber());
        $order->setCreatedAt(new \DateTime());
        $order->setStatus(Order::STATUS_NEW);
        $order->setPid((int)($this->settings['storagePid'] ?? $GLOBALS['TSFE']->id));

        // Customer data
        $order->setCustomerEmail(trim((string)($orderData['customerEmail'] ?? '')));
        $order->setCustomerFirstName(trim((string)($orderData['customerFirstName'] ?? '')));
        $order->setCustomerLastName(trim((string)($orderData['customerLastName'] ?? '')));
        $order->setCustomerCompany(trim((string)($orderData['customerCompany'] ?? '')));

        // Billing address
        $order->setBillingStreet(trim((string)($orderData['billingStreet'] ?? '')));
        $order->setBillingZip(substr(trim((string)($orderData['billingZip'] ?? '')), 0, 50));
        $order->setBillingCity(trim((string)($orderData['billingCity'] ?? '')));
        $order->setBillingCountry(substr(trim((string)($orderData['billingCountry'] ?? '')), 0, 2));

        // Shipping address
        $shippingSameAsBilling = isset($orderData['shippingSameAsBilling']) && $orderData['shippingSameAsBilling'];
        $order->setShippingSameAsBilling($shippingSameAsBilling);
        
        if (!$shippingSameAsBilling) {
            $order->setShippingFirstName(trim((string)($orderData['shippingFirstName'] ?? '')));
            $order->setShippingLastName(trim((string)($orderData['shippingLastName'] ?? '')));
            $order->setShippingCompany(trim((string)($orderData['shippingCompany'] ?? '')));
            $order->setShippingStreet(trim((string)($orderData['shippingStreet'] ?? '')));
            $order->setShippingZip(substr(trim((string)($orderData['shippingZip'] ?? '')), 0, 50));
            $order->setShippingCity(trim((string)($orderData['shippingCity'] ?? '')));
            $order->setShippingCountry(substr(trim((string)($orderData['shippingCountry'] ?? '')), 0, 2));
        }

        // Comment
        $order->setComment(trim((string)($orderData['comment'] ?? '')));

        // Payment method
        $paymentMethodId = (int)($orderData['paymentMethod'] ?? 0);
        if ($paymentMethodId > 0) {
            $paymentMethod = $this->paymentMethodRepository->findByUidIgnoreStorage($paymentMethodId);
            if ($paymentMethod !== null) {
                $order->setPaymentMethod($paymentMethod);
            }
        }

        // Shipping method
        $shippingMethodId = (int)($orderData['shippingMethod'] ?? 0);
        if ($shippingMethodId > 0) {
            $shippingMethod = $this->shippingMethodRepository->findByUidIgnoreStorage($shippingMethodId);
            if ($shippingMethod !== null) {
                $order->setShippingMethod($shippingMethod);
                $order->setShippingCost($shippingMethod->getPrice());
            }
        }

        $items = [];
        
        foreach ($cartItems as $cartItem) {
            if ($cartItem->getProduct() !== null) {
                $itemSubtotal = $cartItem->getProduct()->getPrice() * $cartItem->getQuantity();
                $items[] = [
                    'sku' => $cartItem->getProduct()->getSku(),
                    'title' => $cartItem->getProduct()->getTitle(),
                    'productName' => $cartItem->getProduct()->getTitle(),
                    'productId' => $cartItem->getProduct()->getUid(),
                    'quantity' => $cartItem->getQuantity(),
                    'price' => $cartItem->getProduct()->getPrice(),
                    'subtotal' => $itemSubtotal,
                    'total' => $itemSubtotal,
                ];
            }
        }

        $totals = $this->calculateTotals($cartItems->toArray());
        $order->setSubtotal($totals['net']);
        $order->setItemsJson(json_encode($items));
        $order->setTotalAmount($totals['gross'] + $order->getShippingCost() - $order->getDiscount());

        $this->orderRepository->add($order);

        foreach ($cartItems as $cartItem) {
            $this->cartItemRepository->remove($cartItem);
        }

        $this->persistenceManager->persistAll();

        return $this->redirect('confirmation', null, null, ['order' => $order->getUid()]);
    }

    public function confirmationAction(Order $order): ResponseInterface
    {
        $shopPid = (int)($this->settings['shopPid'] ?? 0);

        $this->view->assignMultiple([
            'order' => $order,
            'shopPid' => $shopPid,
        ]);

        return $this->htmlResponse();
    }

    private function getSessionId(): string
    {
        $frontendUser = $this->request->getAttribute('frontend.user');

        if ($frontendUser !== null && $frontendUser->user !== null) {
            return 'user_' . $frontendUser->user['uid'];
        }

        return $_COOKIE['tx_tuning_tool_shop_session'] ?? '';
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(4)));
    }

    private function buildPageLink(int $pageUid): string
    {
        if ($pageUid === 0) {
            return '#';
        }
        return $this->uriBuilder->reset()->setTargetPageUid($pageUid)->build();
    }

    private function getCountries(): array
    {
        return [
            'DE' => 'Deutschland',
            'AT' => 'Österreich',
            'CH' => 'Schweiz',
            'BE' => 'Belgien',
            'DK' => 'Dänemark',
            'ES' => 'Spanien',
            'FR' => 'Frankreich',
            'GB' => 'Großbritannien',
            'GR' => 'Griechenland',
            'IE' => 'Irland',
            'IT' => 'Italien',
            'LU' => 'Luxemburg',
            'NL' => 'Niederlande',
            'PL' => 'Polen',
            'PT' => 'Portugal',
            'SE' => 'Schweden',
            'CZ' => 'Tschechien',
            'HU' => 'Ungarn',
            'RO' => 'Rumänien',
            'BG' => 'Bulgarien',
            'HR' => 'Kroatien',
            'CY' => 'Zypern',
            'EE' => 'Estland',
            'FI' => 'Finnland',
            'LV' => 'Lettland',
            'LT' => 'Litauen',
            'MT' => 'Malta',
            'SK' => 'Slowakei',
            'SI' => 'Slowenien',
            'US' => 'Vereinigte Staaten',
            'CA' => 'Kanada',
            'AU' => 'Australien',
            'NZ' => 'Neuseeland',
            'JP' => 'Japan',
            'CN' => 'China',
            'IN' => 'Indien',
            'BR' => 'Brasilien',
            'MX' => 'Mexiko',
        ];
    }

    private function calculateTotals(array $cartItems): array
    {
        $gross = 0.0;
        $net = 0.0;
        $tax = 0.0;

        foreach ($cartItems as $cartItem) {
            if ($cartItem->getProduct() !== null) {
                $gross += $cartItem->getSubtotal();
                $net += $cartItem->getSubtotalNet();
                $tax += $cartItem->getTaxAmount();
            }
        }

        return [
            'gross' => $gross,
            'net' => $net,
            'tax' => $tax,
        ];
    }

    private function calculateTotalWeight(array $cartItems): float
    {
        $totalWeight = 0.0;

        foreach ($cartItems as $cartItem) {
            if ($cartItem->getProduct() !== null) {
                $totalWeight += $cartItem->getProduct()->getWeight() * $cartItem->getQuantity();
            }
        }

        return $totalWeight;
    }

    private function filterShippingMethodsByWeight(object $shippingMethods, float $totalWeight): array
    {
        $availableMethods = [];

        foreach ($shippingMethods as $shippingMethod) {
            // Include method if maxWeight is 0 (unlimited) or >= totalWeight
            if ($shippingMethod->getMaxWeight() === 0.0 || $shippingMethod->getMaxWeight() >= $totalWeight) {
                $availableMethods[] = $shippingMethod;
            }
        }

        return $availableMethods;
    }

    private function selectBestShippingMethod(array $availableMethods, float $totalWeight): ?object
    {
        if (empty($availableMethods)) {
            return null;
        }

        // Select the shipping method with the lowest maxWeight that still fits
        // This ensures the most cost-effective option
        $bestMethod = null;
        $lowestMaxWeight = PHP_FLOAT_MAX;

        foreach ($availableMethods as $method) {
            $maxWeight = $method->getMaxWeight();
            
            // If unlimited (0), only use if no other option exists
            if ($maxWeight === 0.0) {
                if ($bestMethod === null) {
                    $bestMethod = $method;
                }
            } elseif ($maxWeight >= $totalWeight && $maxWeight < $lowestMaxWeight) {
                $bestMethod = $method;
                $lowestMaxWeight = $maxWeight;
            }
        }

        return $bestMethod ?? ($availableMethods[0] ?? null);
    }
}
