<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Model\CartItem;
use Hamstahstudio\TuningToolShop\Domain\Model\Product;
use Hamstahstudio\TuningToolShop\Domain\Repository\CartItemRepository;
use Hamstahstudio\TuningToolShop\Domain\Repository\ProductRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class CartController extends ActionController
{
    public function __construct(
        protected readonly CartItemRepository $cartItemRepository,
        protected readonly ProductRepository $productRepository,
        protected readonly PersistenceManager $persistenceManager,
    ) {}

    public function indexAction(): ResponseInterface
    {
        $cartItems = $this->getCartItems();
        $totalGross = 0.0;
        $totalNet = 0.0;
        $totalTax = 0.0;

        foreach ($cartItems as $cartItem) {
            if ($cartItem->getProduct() !== null) {
                $totalGross += $cartItem->getSubtotal();
                $totalNet += $cartItem->getSubtotalNet();
                $totalTax += $cartItem->getTaxAmount();
            }
        }

        $checkoutPid = (int)($this->settings['checkoutPid'] ?? 0);
        $continuePid = (int)($this->settings['continuePid'] ?? 0);

        $this->view->assignMultiple([
            'cartItems' => $cartItems,
            'total' => $totalGross,
            'totalNet' => $totalNet,
            'totalTax' => $totalTax,
            'checkoutPid' => $checkoutPid,
            'continuePid' => $continuePid,
        ]);

        return $this->htmlResponse();
    }

    public function addAction(int $product, int $quantity = 1): ResponseInterface
    {
        $sessionId = $this->getSessionId();
        
        $productObject = $this->productRepository->findByUidIgnoreStorage($product);
        if ($productObject === null) {
            $this->addFlashMessage('Produkt nicht gefunden.', '', \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
            return $this->redirect('index');
        }

        $existingItem = $this->cartItemRepository->findBySessionIdAndProduct($sessionId, $product);

        if ($existingItem !== null) {
            $existingItem->setQuantity($existingItem->getQuantity() + $quantity);
            $this->cartItemRepository->update($existingItem);
        } else {
            $cartItem = new CartItem();
            $cartItem->setPid((int)($this->settings['storagePid'] ?? $GLOBALS['TSFE']->id));
            $cartItem->setSessionId($sessionId);
            $cartItem->setProduct($productObject);
            $cartItem->setQuantity($quantity);

            $this->cartItemRepository->add($cartItem);
        }

        $this->persistenceManager->persistAll();

        $this->addFlashMessage('Produkt wurde zum Warenkorb hinzugefügt.');

        $cartPid = (int)($this->settings['cartPid'] ?? 0);
        if ($cartPid > 0) {
            return $this->redirectToUri($this->uriBuilder->reset()->setTargetPageUid($cartPid)->build());
        }
        
        return $this->redirect('index');
    }

    public function updateAction(CartItem $cartItem, int $quantity): ResponseInterface
    {
        if ($quantity <= 0) {
            $this->cartItemRepository->remove($cartItem);
            $this->addFlashMessage('Artikel wurde aus dem Warenkorb entfernt.');
        } else {
            $cartItem->setQuantity($quantity);
            $this->cartItemRepository->update($cartItem);
            $this->addFlashMessage('Menge wurde aktualisiert.');
        }

        $this->persistenceManager->persistAll();

        return $this->redirect('index');
    }

    public function removeAction(CartItem $cartItem): ResponseInterface
    {
        $this->cartItemRepository->remove($cartItem);
        $this->persistenceManager->persistAll();

        $this->addFlashMessage('Artikel wurde aus dem Warenkorb entfernt.');

        return $this->redirect('index');
    }

    private function getSessionId(): string
    {
        $frontendUser = $this->request->getAttribute('frontend.user');

        if ($frontendUser !== null && $frontendUser->user !== null) {
            return 'user_' . $frontendUser->user['uid'];
        }

        if (!isset($_COOKIE['tx_tuning_tool_shop_session'])) {
            $sessionId = bin2hex(random_bytes(32));
            setcookie('tx_tuning_tool_shop_session', $sessionId, [
                'expires' => time() + 86400 * 30,
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
        } else {
            $sessionId = $_COOKIE['tx_tuning_tool_shop_session'];
        }

        return $sessionId;
    }

    private function getCartItems(): array
    {
        $sessionId = $this->getSessionId();

        return $this->cartItemRepository->findBySessionId($sessionId)->toArray();
    }
}
