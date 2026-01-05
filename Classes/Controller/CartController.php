<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Model\CartItem;
use Hamstahstudio\TuningToolShop\Domain\Repository\ProductRepository;
use Hamstahstudio\TuningToolShop\Service\CartService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;

class CartController extends ActionController
{
    public function __construct(
        protected readonly ProductRepository $productRepository,
        protected readonly CartService $cartService,
    ) {}

    public function indexAction(): ResponseInterface
    {
        // Get cart items from TYPO3 session
        $frontendUser = $this->getFrontendUser();
        $cartItems = $this->cartService->getCartItemsFromSession($frontendUser);
        $totalGross = 0.0;
        $totalNet = 0.0;
        $totalTax = 0.0;
        $itemCount = 0;

        foreach ($cartItems as $cartItem) {
            if ($cartItem->getProduct() !== null) {
                $totalGross += $cartItem->getSubtotal();
                $totalNet += $cartItem->getSubtotalNet();
                $totalTax += $cartItem->getTaxAmount();
                $itemCount += $cartItem->getQuantity();
            }
        }

        $checkoutPid = (int)($this->settings['checkoutPid'] ?? 0);
        $continuePid = (int)($this->settings['continuePid'] ?? 0);
        $displayMode = $this->settings['displayMode'] ?? 'normal';
        $cartPid = (int)($this->settings['cartPid'] ?? 0);

        $this->view->assignMultiple([
            'cartItems' => $cartItems,
            'total' => $totalGross,
            'totalNet' => $totalNet,
            'totalTax' => $totalTax,
            'checkoutPid' => $checkoutPid,
            'continuePid' => $continuePid,
            'displayMode' => $displayMode,
            'cartPid' => $cartPid,
            'itemCount' => $itemCount,
        ]);

        return $this->htmlResponse();
    }

    public function addAction(int $product, int $quantity = 1): ResponseInterface
    {
        error_log('[CartController::addAction] Adding product: ' . $product . ', qty: ' . $quantity);
        
        $productObject = $this->productRepository->findByUidIgnoreStorage($product);
        if ($productObject === null) {
            $this->addFlashMessage('Produkt nicht gefunden.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
            return $this->redirect('index');
        }

        // Get cart items from session
        $frontendUser = $this->getFrontendUser();
        error_log('[CartController::addAction] Frontend user: ' . ($frontendUser ? 'yes' : 'no'));
        
        $cartItems = $this->cartService->getCartItemsFromSession($frontendUser);

        // Check if product is already in cart
        $existingKey = null;
        foreach ($cartItems as $key => $item) {
            if ($item->getProduct()?->getUid() === $product) {
                $existingKey = $key;
                break;
            }
        }

        if ($existingKey !== null) {
            // Update quantity
            $cartItems[$existingKey]->setQuantity($cartItems[$existingKey]->getQuantity() + $quantity);
        } else {
            // Create new cart item
            $cartItem = new CartItem();
            $cartItem->setProduct($productObject);
            $cartItem->setQuantity($quantity);
            $cartItems[] = $cartItem;
        }

        // Store updated cart in session
        $this->cartService->storeCartInSession($frontendUser, $cartItems);

        $this->addFlashMessage('Produkt wurde zum Warenkorb hinzugefügt.');

        $cartPid = (int)($this->settings['cartPid'] ?? 0);
        if ($cartPid > 0) {
            return $this->redirectToUri($this->uriBuilder->reset()->setTargetPageUid($cartPid)->build());
        }

        return $this->redirect('index');
    }

    public function updateAction(int $product, int $quantity): ResponseInterface
    {
        $frontendUser = $this->getFrontendUser();
        $cartItems = $this->cartService->getCartItemsFromSession($frontendUser);

        if ($quantity <= 0) {
            // Remove item
            $cartItems = array_filter($cartItems, fn($item) => $item->getProduct()?->getUid() !== $product);
            $this->addFlashMessage('Artikel wurde aus dem Warenkorb entfernt.');
        } else {
            // Update quantity
            foreach ($cartItems as $item) {
                if ($item->getProduct()?->getUid() === $product) {
                    $item->setQuantity($quantity);
                    break;
                }
            }
            $this->addFlashMessage('Menge wurde aktualisiert.');
        }

        $this->cartService->storeCartInSession($frontendUser, $cartItems);

        return $this->redirect('index');
    }

    public function removeAction(int $product): ResponseInterface
    {
        $frontendUser = $this->getFrontendUser();
        $cartItems = $this->cartService->getCartItemsFromSession($frontendUser);

        // Remove item from cart
        $cartItems = array_filter($cartItems, fn($item) => $item->getProduct()?->getUid() !== $product);

        $this->cartService->storeCartInSession($frontendUser, $cartItems);

        $this->addFlashMessage('Artikel wurde aus dem Warenkorb entfernt.');

        return $this->redirect('index');
    }



    /**
     * Get frontend user - creates anonymous user if none is logged in
     */
    private function getFrontendUser(): FrontendUserAuthentication
    {
        $frontendUser = $this->request->getAttribute('frontend.user');
        if ($frontendUser === null) {
            error_log('[CartController::getFrontendUser] Frontend user is NULL!');
            throw new \RuntimeException('Frontend user is not available');
        }
        return $frontendUser;
    }
}
