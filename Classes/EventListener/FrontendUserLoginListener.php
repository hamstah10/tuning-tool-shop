<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\EventListener;

use Hamstahstudio\TuningToolShop\Domain\Repository\CartItemRepository;
use Hamstahstudio\TuningToolShop\Service\SessionService;
use TYPO3\CMS\Core\Authentication\Event\BeforeUserLoggedInEvent;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

final class FrontendUserLoginListener
{
    public function __construct(
        private readonly CartItemRepository $cartItemRepository,
        private readonly SessionService $sessionService,
        private readonly PersistenceManager $persistenceManager,
    ) {}

    public function __invoke(BeforeUserLoggedInEvent $event): void
    {
        // Get the user that's about to be logged in
        $user = $event->getUser();
        if (!$user || !isset($user['uid'])) {
            return;
        }

        // Get old session ID (before login)
        $oldSessionId = $this->getOldSessionId();
        error_log('[CartMigration] oldSessionId: ' . ($oldSessionId ?? 'NULL'));
        if (!$oldSessionId) {
            return;
        }

        // Get new session ID (after login)
        $newSessionId = 'user_' . $user['uid'];
        error_log('[CartMigration] newSessionId: ' . $newSessionId);

        // Skip if they're the same
        if ($oldSessionId === $newSessionId) {
            return;
        }

        // Migrate cart items
        $this->migrateCartItems($oldSessionId, $newSessionId);
    }

    private function migrateCartItems(string $oldSessionId, string $newSessionId): void
    {
        try {
            // Find all cart items from the old session
            $oldCartItems = $this->cartItemRepository->findBySessionId($oldSessionId)->toArray();
            error_log('[CartMigration] Found ' . count($oldCartItems) . ' items in old session');

            foreach ($oldCartItems as $cartItem) {
                error_log('[CartMigration] Migrating item UID ' . $cartItem->getUid() . ' product ' . ($cartItem->getProduct() ? $cartItem->getProduct()->getUid() : 'NULL'));
                // Update the session ID to the user's session
                $cartItem->setSessionId($newSessionId);
                $this->cartItemRepository->update($cartItem);
            }

            $this->persistenceManager->persistAll();
            error_log('[CartMigration] Migration complete');
        } catch (\Throwable $e) {
            // Log error before silently failing
            error_log('[CartMigration] Error: ' . $e->getMessage());
        }
    }

    private function getOldSessionId(): ?string
    {
        // 1. Check for anonymous cart cookie
        $cookieName = 'tx_tuning_tool_shop_session';
        if (isset($_COOKIE[$cookieName]) && !empty($_COOKIE[$cookieName])) {
            $sessionId = $_COOKIE[$cookieName];
            // Only migrate if it's an anonymous session (not a user session)
            if (strpos($sessionId, 'anon_') === 0) {
                return $sessionId;
            }
        }

        // 2. Try to get from request
        if (isset($GLOBALS['TYPO3_REQUEST'])) {
            try {
                $sessionId = $this->sessionService->getSessionIdFromRequest($GLOBALS['TYPO3_REQUEST']);
                if ($sessionId && strpos($sessionId, 'anon_') === 0) {
                    return $sessionId;
                }
            } catch (\Throwable) {
                // Continue
            }
        }

        return null;
    }
}
