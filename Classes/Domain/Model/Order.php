<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Order extends AbstractEntity
{
    public const STATUS_NEW = 0;
    public const STATUS_PENDING = 1;
    public const STATUS_CONFIRMED = 2;
    public const STATUS_SHIPPED = 3;
    public const STATUS_COMPLETED = 4;
    public const STATUS_CANCELLED = 5;

    public const PAYMENT_STATUS_PENDING = 0;
    public const PAYMENT_STATUS_PAID = 1;
    public const PAYMENT_STATUS_FAILED = 2;
    public const PAYMENT_STATUS_REFUNDED = 3;

    public const EXPORT_STATUS_NOT_EXPORTED = 0;
    public const EXPORT_STATUS_PENDING = 1;
    public const EXPORT_STATUS_EXPORTED = 2;
    public const EXPORT_STATUS_FAILED = 3;

    protected string $orderNumber = '';

    protected string $transactionId = '';

    protected int $paymentStatus = self::PAYMENT_STATUS_PENDING;

    protected string $customerEmail = '';

    protected string $customerName = '';

    protected string $customerFirstName = '';

    protected string $customerLastName = '';

    protected string $customerCompany = '';

    protected string $billingAddress = '';

    protected string $billingStreet = '';

    protected string $billingZip = '';

    protected string $billingCity = '';

    protected string $billingCountry = '';

    protected string $shippingAddress = '';

    protected string $shippingFirstName = '';

    protected string $shippingLastName = '';

    protected string $shippingCompany = '';

    protected string $shippingStreet = '';

    protected string $shippingZip = '';

    protected string $shippingCity = '';

    protected string $shippingCountry = '';

    protected bool $shippingSameAsBilling = true;

    protected string $comment = '';

    protected float $subtotal = 0.0;

    protected float $discount = 0.0;

    protected float $shippingCost = 0.0;

    protected ?PaymentMethod $paymentMethod = null;

    protected ?ShippingMethod $shippingMethod = null;

    protected int $status = self::STATUS_NEW;

    protected float $total = 0.0;

    protected string $itemsJson = '';

    protected string $notes = '';

    protected ?\DateTime $createdAt = null;

    protected ?int $frontendUserId = null;

    protected float $taxAmount = 0.0;

    protected int $exportStatus = self::EXPORT_STATUS_NOT_EXPORTED;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): void
    {
        $this->orderNumber = $orderNumber;
    }

    public function getCustomerEmail(): string
    {
        return $this->customerEmail;
    }

    public function setCustomerEmail(string $customerEmail): void
    {
        $this->customerEmail = $customerEmail;
    }

    public function getCustomerName(): string
    {
        return $this->customerName;
    }

    public function setCustomerName(string $customerName): void
    {
        $this->customerName = $customerName;
    }

    public function getBillingAddress(): string
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(string $billingAddress): void
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * @return array<string, mixed>
     */
    public function getBillingAddressDecoded(): array
    {
        if ($this->billingAddress === '') {
            return [];
        }
        return json_decode($this->billingAddress, true) ?? [];
    }

    public function getShippingAddress(): string
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(string $shippingAddress): void
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return array<string, mixed>
     */
    public function getShippingAddressDecoded(): array
    {
        if ($this->shippingAddress === '') {
            return [];
        }
        return json_decode($this->shippingAddress, true) ?? [];
    }

    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?PaymentMethod $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_NEW => 'Neu',
            self::STATUS_PENDING => 'In Bearbeitung',
            self::STATUS_CONFIRMED => 'Bestätigt',
            self::STATUS_SHIPPED => 'Versendet',
            self::STATUS_COMPLETED => 'Abgeschlossen',
            self::STATUS_CANCELLED => 'Storniert',
            default => 'Unbekannt',
        };
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function setTransactionId(string $transactionId): void
    {
        $this->transactionId = $transactionId;
    }

    public function getPaymentStatus(): int
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus(int $paymentStatus): void
    {
        $this->paymentStatus = $paymentStatus;
    }

    public function getPaymentStatusLabel(): string
    {
        return match ($this->paymentStatus) {
            self::PAYMENT_STATUS_PENDING => 'Ausstehend',
            self::PAYMENT_STATUS_PAID => 'Bezahlt',
            self::PAYMENT_STATUS_FAILED => 'Fehlgeschlagen',
            self::PAYMENT_STATUS_REFUNDED => 'Erstattet',
            default => 'Unbekannt',
        };
    }

    public function getTotalAmount(): float
    {
        return $this->total;
    }

    public function setTotalAmount(float $total): void
    {
        $this->total = $total;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    public function getItemsJson(): string
    {
        return $this->itemsJson;
    }

    public function setItemsJson(string $itemsJson): void
    {
        $this->itemsJson = $itemsJson;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getItems(): array
    {
        if ($this->itemsJson === '') {
            return [];
        }
        return json_decode($this->itemsJson, true) ?? [];
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): void
    {
        $this->notes = $notes;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCustomerFirstName(): string
    {
        return $this->customerFirstName;
    }

    public function setCustomerFirstName(string $customerFirstName): void
    {
        $this->customerFirstName = $customerFirstName;
    }

    public function getCustomerLastName(): string
    {
        return $this->customerLastName;
    }

    public function setCustomerLastName(string $customerLastName): void
    {
        $this->customerLastName = $customerLastName;
    }

    public function getCustomerCompany(): string
    {
        return $this->customerCompany;
    }

    public function setCustomerCompany(string $customerCompany): void
    {
        $this->customerCompany = $customerCompany;
    }

    public function getBillingStreet(): string
    {
        return $this->billingStreet;
    }

    public function setBillingStreet(string $billingStreet): void
    {
        $this->billingStreet = $billingStreet;
    }

    public function getBillingZip(): string
    {
        return $this->billingZip;
    }

    public function setBillingZip(string $billingZip): void
    {
        $this->billingZip = $billingZip;
    }

    public function getBillingCity(): string
    {
        return $this->billingCity;
    }

    public function setBillingCity(string $billingCity): void
    {
        $this->billingCity = $billingCity;
    }

    public function getBillingCountry(): string
    {
        return $this->billingCountry;
    }

    public function setBillingCountry(string $billingCountry): void
    {
        $this->billingCountry = $billingCountry;
    }

    public function getBillingCountryName(): string
    {
        $countries = [
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
        return $countries[$this->billingCountry] ?? $this->billingCountry;
    }

    public function getShippingFirstName(): string
    {
        return $this->shippingFirstName;
    }

    public function setShippingFirstName(string $shippingFirstName): void
    {
        $this->shippingFirstName = $shippingFirstName;
    }

    public function getShippingLastName(): string
    {
        return $this->shippingLastName;
    }

    public function setShippingLastName(string $shippingLastName): void
    {
        $this->shippingLastName = $shippingLastName;
    }

    public function getShippingCompany(): string
    {
        return $this->shippingCompany;
    }

    public function setShippingCompany(string $shippingCompany): void
    {
        $this->shippingCompany = $shippingCompany;
    }

    public function getShippingStreet(): string
    {
        return $this->shippingStreet;
    }

    public function setShippingStreet(string $shippingStreet): void
    {
        $this->shippingStreet = $shippingStreet;
    }

    public function getShippingZip(): string
    {
        return $this->shippingZip;
    }

    public function setShippingZip(string $shippingZip): void
    {
        $this->shippingZip = $shippingZip;
    }

    public function getShippingCity(): string
    {
        return $this->shippingCity;
    }

    public function setShippingCity(string $shippingCity): void
    {
        $this->shippingCity = $shippingCity;
    }

    public function getShippingCountry(): string
    {
        return $this->shippingCountry;
    }

    public function setShippingCountry(string $shippingCountry): void
    {
        $this->shippingCountry = $shippingCountry;
    }

    public function getShippingCountryName(): string
    {
        $countries = [
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
        return $countries[$this->shippingCountry] ?? $this->shippingCountry;
    }

    public function getShippingSameAsBilling(): bool
    {
        return $this->shippingSameAsBilling;
    }

    public function setShippingSameAsBilling(bool $shippingSameAsBilling): void
    {
        $this->shippingSameAsBilling = $shippingSameAsBilling;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getSubtotal(): float
    {
        return $this->subtotal;
    }

    public function setSubtotal(float $subtotal): void
    {
        $this->subtotal = $subtotal;
    }

    public function getDiscount(): float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): void
    {
        $this->discount = $discount;
    }

    public function getShippingCost(): float
    {
        return $this->shippingCost;
    }

    public function setShippingCost(float $shippingCost): void
    {
        $this->shippingCost = $shippingCost;
    }

    public function getShippingMethod(): ?ShippingMethod
    {
        return $this->shippingMethod;
    }

    public function setShippingMethod(?ShippingMethod $shippingMethod): void
    {
        $this->shippingMethod = $shippingMethod;
    }

    public function getFrontendUserId(): ?int
    {
        return $this->frontendUserId;
    }

    public function setFrontendUserId(?int $frontendUserId): void
    {
        $this->frontendUserId = $frontendUserId;
    }

    public function getTaxAmount(): float
    {
        return $this->taxAmount;
    }

    public function setTaxAmount(float $taxAmount): void
    {
        $this->taxAmount = $taxAmount;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getParsedItems(): array
    {
        return $this->getItems();
    }

    public function getStatusString(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'pending',
            self::STATUS_CONFIRMED => 'confirmed',
            self::STATUS_SHIPPED => 'shipped',
            self::STATUS_COMPLETED => 'delivered',
            self::STATUS_CANCELLED => 'cancelled',
            default => 'unknown',
        };
    }

    public function getExportStatus(): int
    {
        return $this->exportStatus;
    }

    public function setExportStatus(int $exportStatus): void
    {
        $this->exportStatus = $exportStatus;
    }

    public function getExportStatusLabel(): string
    {
        return match ($this->exportStatus) {
            self::EXPORT_STATUS_NOT_EXPORTED => 'Nicht exportiert',
            self::EXPORT_STATUS_PENDING => 'Export läuft',
            self::EXPORT_STATUS_EXPORTED => 'Exportiert',
            self::EXPORT_STATUS_FAILED => 'Export fehlgeschlagen',
            default => 'Unbekannt',
        };
    }
}
