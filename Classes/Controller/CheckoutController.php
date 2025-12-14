<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Model\Order;
use Hamstahstudio\TuningToolShop\Domain\Repository\CartItemRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\OrderRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\PaymentMethodRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\ShippingMethodRepository;
use Hamstahstudio\TuningToolShop\Service\AuthenticationService;
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
        protected readonly AuthenticationService $authenticationService,
    ) {}

    public function indexAction(): ResponseInterface
    {
        $isUserLoggedIn = $this->authenticationService->isUserLoggedIn($this->request);
        $frontendUser = $this->authenticationService->getFrontendUser($this->request);
        $sessionId = $this->getSessionId();
        $cartItems = $this->cartItemRepository->findBySessionId($sessionId);
        $paymentMethods = $this->paymentMethodRepository->findAll();
        $shippingMethods = $this->shippingMethodRepository->findActive();

        $cartPid = (int)($this->settings['cartPid'] ?? 0);
        $shopPid = (int)($this->settings['shopPid'] ?? 0);
        $loginPid = (int)($this->settings['femanagerLoginPid'] ?? 0);
        $registrationPid = (int)($this->settings['femanagerRegistrationPid'] ?? 0);

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
        
        // Pre-select payment method if only one is available
        $selectedPaymentMethod = null;
        if ($paymentMethods->count() === 1) {
            $selectedPaymentMethod = $paymentMethods->getFirst();
        }
        
        $termsLink = $this->buildPageLink((int)($this->settings['termsAndConditionsPid'] ?? 0));
        $privacyLink = $this->buildPageLink((int)($this->settings['privacyPid'] ?? 0));
        $cancellationLink = $this->buildPageLink((int)($this->settings['cancellationPid'] ?? 0));

        $this->view->assignMultiple([
            'cartItems' => $cartItems,
            'isUserLoggedIn' => $isUserLoggedIn,
            'frontendUser' => $frontendUser,
            'paymentMethods' => $paymentMethods,
            'selectedPaymentMethod' => $selectedPaymentMethod,
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
            'loginPid' => $loginPid,
            'registrationPid' => $registrationPid,
        ]);

        return $this->htmlResponse();
    }

    public function processAction(): ResponseInterface
    {
        // Check if user is logged in
        if (!$this->authenticationService->isUserLoggedIn($this->request)) {
            $this->addFlashMessage('Sie müssen angemeldet sein, um eine Bestellung zu erstellen.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
            $loginUrl = $this->authenticationService->getLoginPageUrl($this->settings);
            return $this->redirectToUri($loginUrl);
        }

        $sessionId = $this->getSessionId();
        $cartItems = $this->cartItemRepository->findBySessionId($sessionId);

        if ($cartItems->count() === 0) {
            $this->addFlashMessage('Ihr Warenkorb ist leer.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
            return $this->redirect('index', 'Cart');
        }

        $orderData = $this->request->hasArgument('order') ? $this->request->getArgument('order') : [];

        // Store checkout data in session for later order creation after payment
        $frontendUser = $this->request->getAttribute('frontend.user');
        if ($frontendUser !== null) {
            $frontendUser->setAndSaveSessionData('tx_tuningtoolshop_checkout', [
                'orderData' => $orderData,
                'cartSessionId' => $sessionId,
                'paymentMethodId' => (int)($orderData['paymentMethod'] ?? 0),
                'shippingMethodId' => (int)($orderData['shippingMethod'] ?? 0),
                'timestamp' => time(),
            ]);
        }

        // Build temporary order object for payment processing
        $tempOrder = new Order();
        $tempOrder->setOrderNumber($this->generateOrderNumber());
        $tempOrder->setCreatedAt(new \DateTime());
        $tempOrder->setStatus(Order::STATUS_NEW);
        $tempOrder->setPid((int)($this->settings['storagePid'] ?? $GLOBALS['TSFE']->id));

        // Customer data
        $tempOrder->setCustomerEmail(trim((string)($orderData['customerEmail'] ?? '')));
        $tempOrder->setCustomerFirstName(trim((string)($orderData['customerFirstName'] ?? '')));
        $tempOrder->setCustomerLastName(trim((string)($orderData['customerLastName'] ?? '')));
        $tempOrder->setCustomerCompany(trim((string)($orderData['customerCompany'] ?? '')));

        // Billing address
        $tempOrder->setBillingStreet(trim((string)($orderData['billingStreet'] ?? '')));
        $tempOrder->setBillingZip(substr(trim((string)($orderData['billingZip'] ?? '')), 0, 50));
        $tempOrder->setBillingCity(trim((string)($orderData['billingCity'] ?? '')));
        $tempOrder->setBillingCountry(substr(trim((string)($orderData['billingCountry'] ?? '')), 0, 2));

        // Shipping address
        $shippingSameAsBilling = isset($orderData['shippingSameAsBilling']) && $orderData['shippingSameAsBilling'];
        $tempOrder->setShippingSameAsBilling($shippingSameAsBilling);
        
        if (!$shippingSameAsBilling) {
            $tempOrder->setShippingFirstName(trim((string)($orderData['shippingFirstName'] ?? '')));
            $tempOrder->setShippingLastName(trim((string)($orderData['shippingLastName'] ?? '')));
            $tempOrder->setShippingCompany(trim((string)($orderData['shippingCompany'] ?? '')));
            $tempOrder->setShippingStreet(trim((string)($orderData['shippingStreet'] ?? '')));
            $tempOrder->setShippingZip(substr(trim((string)($orderData['shippingZip'] ?? '')), 0, 50));
            $tempOrder->setShippingCity(trim((string)($orderData['shippingCity'] ?? '')));
            $tempOrder->setShippingCountry(substr(trim((string)($orderData['shippingCountry'] ?? '')), 0, 2));
        }

        // Comment
        $tempOrder->setComment(trim((string)($orderData['comment'] ?? '')));

        // Payment method
        $paymentMethodId = (int)($orderData['paymentMethod'] ?? 0);
        if ($paymentMethodId > 0) {
            $paymentMethod = $this->paymentMethodRepository->findByUidIgnoreStorage($paymentMethodId);
            if ($paymentMethod !== null) {
                $tempOrder->setPaymentMethod($paymentMethod);
            }
        }

        // Shipping method
        $shippingMethodId = (int)($orderData['shippingMethod'] ?? 0);
        if ($shippingMethodId > 0) {
            $shippingMethod = $this->shippingMethodRepository->findByUidIgnoreStorage($shippingMethodId);
            if ($shippingMethod !== null) {
                $tempOrder->setShippingMethod($shippingMethod);
                $tempOrder->setShippingCost($shippingMethod->getPrice());
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
        $tempOrder->setSubtotal($totals['net']);
        $tempOrder->setItemsJson(json_encode($items));
        $tempOrder->setTotalAmount($totals['gross'] + $tempOrder->getShippingCost() - $tempOrder->getDiscount());

        // Always save order with payment pending status
        $paymentMethod = $tempOrder->getPaymentMethod();
        $handlerClass = $paymentMethod ? $paymentMethod->getHandlerClass() : null;
        
        if ($paymentMethod === null || empty($handlerClass)) {
            // No payment handler: mark as paid and confirmed immediately
            $tempOrder->setPaymentStatus(Order::PAYMENT_STATUS_PAID);
            $tempOrder->setStatus(Order::STATUS_CONFIRMED);
        } else {
            // Payment handler needed: keep as pending until IPN callback
            $tempOrder->setPaymentStatus(Order::PAYMENT_STATUS_PENDING);
            $tempOrder->setStatus(Order::STATUS_PENDING);
        }

        $this->orderRepository->add($tempOrder);
        $this->persistenceManager->persistAll();

        // If no payment handler needed, confirm order and clear cart
        if ($paymentMethod === null || empty($handlerClass)) {
            // Clear cart
            foreach ($cartItems as $cartItem) {
                $this->cartItemRepository->remove($cartItem);
            }
            $this->persistenceManager->persistAll();

            return $this->redirect('confirmation', 'Checkout', null, ['order' => $tempOrder->getUid()]);
        }

        // Redirect to payment with temporary order
        return $this->redirect('redirect', 'Payment', null, ['order' => $tempOrder->getUid()]);
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
            // Check if weight matches the shipping method's range
            $minWeight = $shippingMethod->getMinWeight();
            $maxWeight = $shippingMethod->getMaxWeight();

            // Debug logging
            error_log(sprintf(
                'Shipping method: %s | minWeight: %.2f | maxWeight: %.2f | totalWeight: %.2f',
                $shippingMethod->getTitle(),
                $minWeight,
                $maxWeight,
                $totalWeight
            ));

            // Check minimum weight (0 = no minimum)
            if ($minWeight > 0 && $totalWeight < $minWeight) {
                error_log(sprintf('  → Filtered out: totalWeight (%.2f) < minWeight (%.2f)', $totalWeight, $minWeight));
                continue;
            }

            // Check maximum weight (0 = unlimited)
            if ($maxWeight > 0 && $totalWeight > $maxWeight) {
                error_log(sprintf('  → Filtered out: totalWeight (%.2f) > maxWeight (%.2f)', $totalWeight, $maxWeight));
                continue;
            }

            error_log('  → Available');
            $availableMethods[] = $shippingMethod;
        }

        error_log(sprintf('Total available shipping methods: %d', count($availableMethods)));
        return $availableMethods;
    }

    private function selectBestShippingMethod(array $availableMethods, float $totalWeight): ?object
    {
        if (empty($availableMethods)) {
            return null;
        }

        // Sort by price (lowest first) to select the cheapest option
        usort($availableMethods, function ($a, $b) {
            return $a->getPrice() <=> $b->getPrice();
        });

        // Return the cheapest available shipping method
        return $availableMethods[0];
    }
}
