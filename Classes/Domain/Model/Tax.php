<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Tax extends AbstractEntity
{
    protected string $title = '';

    protected float $rate = 0.0;

    protected string $country = 'DE';

    protected bool $isDefault = false;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getIsDefault(): bool
    {
        return $this->isDefault;
    }

    public function setIsDefault(bool $isDefault): void
    {
        $this->isDefault = $isDefault;
    }

    public function calculateTax(float $netPrice): float
    {
        return $netPrice * ($this->rate / 100);
    }

    public function calculateGross(float $netPrice): float
    {
        return $netPrice + $this->calculateTax($netPrice);
    }

    public function calculateNet(float $grossPrice): float
    {
        return $grossPrice / (1 + ($this->rate / 100));
    }
}
