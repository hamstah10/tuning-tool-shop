<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Payment;

use Hamstahstudio\TuningToolShop\Domain\Model\Order;

interface PaymentHandlerInterface
{
    /**
     * Process a payment for the given order
     * Returns a PaymentResult object with status and redirect info
     */
    public function processPayment(Order $order): PaymentResult;

    /**
     * Get a custom payment form (if needed)
     */
    public function getPaymentForm(Order $order): ?string;

    /**
     * Handle callback from payment provider
     */
    public function handleCallback(array $parameters): PaymentResult;

    /**
     * Get display name for the payment method
     */
    public function getDisplayName(): string;

    /**
     * Check if payment handler requires redirect to external URL
     */
    public function requiresRedirect(): bool;

    /**
     * Set configuration for the payment handler
     */
    public function setConfiguration(array $config): void;

    /**
     * Set return URL for payment callback
     */
    public function setReturnUrl(string $returnUrl): void;
}
