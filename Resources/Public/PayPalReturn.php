<?php
/**
 * eID handler for PayPal return redirects
 * Called by PayPal after payment completion
 * URL format: domain.de/index.php?eID=tuning_tool_shop_paypal_return&custom=ORDER_UID&success=true
 */

declare(strict_types=1);

// Bootstrap TYPO3
require_once(__DIR__ . '/../../../../../../public/index.php');

// Get order UID from ?custom parameter
$orderUid = (int)($_GET['custom'] ?? 0);
if ($orderUid === 0) {
    header('Location: /');
    exit;
}

// Redirect to PaymentController->successAction
$successUrl = '/?tx_tuningtoolshop_payment[action]=success&tx_tuningtoolshop_payment[order]=' . $orderUid;

// Check if payment was successful
$success = ($_GET['success'] ?? '') === 'true';
if (!$success) {
    $successUrl = '/?tx_tuningtoolshop_payment[action]=cancel';
}

header('Location: ' . $successUrl);
exit;
