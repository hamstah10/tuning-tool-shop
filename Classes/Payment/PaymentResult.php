<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Payment;

class PaymentResult
{
    public const STATUS_SUCCESS = 'success';
    public const STATUS_PENDING = 'pending';
    public const STATUS_FAILED = 'failed';
    public const STATUS_REDIRECT = 'redirect';

    protected string $status;
    protected string $message = '';
    protected string $transactionId = '';
    protected ?string $redirectUrl = null;
    protected array $formFields = [];
    protected ?string $formAction = null;

    public function __construct(string $status, string $message = '')
    {
        $this->status = $status;
        $this->message = $message;
    }

    public static function success(string $transactionId = '', string $message = 'Payment successful'): self
    {
        $result = new self(self::STATUS_SUCCESS, $message);
        $result->transactionId = $transactionId;
        return $result;
    }

    public static function pending(string $message = 'Payment pending'): self
    {
        return new self(self::STATUS_PENDING, $message);
    }

    public static function failed(string $message = 'Payment failed'): self
    {
        return new self(self::STATUS_FAILED, $message);
    }

    public static function redirect(string $url): self
    {
        $result = new self(self::STATUS_REDIRECT);
        $result->redirectUrl = $url;
        return $result;
    }

    public static function form(string $actionUrl, array $fields): self
    {
        $result = new self(self::STATUS_REDIRECT);
        $result->formAction = $actionUrl;
        $result->formFields = $fields;
        return $result;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function getRedirectUrl(): ?string
    {
        return $this->redirectUrl;
    }

    public function getFormFields(): array
    {
        return $this->formFields;
    }

    public function getFormAction(): ?string
    {
        return $this->formAction;
    }

    public function isSuccess(): bool
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function requiresRedirect(): bool
    {
        return $this->status === self::STATUS_REDIRECT;
    }

    public function hasForm(): bool
    {
        return $this->formAction !== null && !empty($this->formFields);
    }
}
