<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class CartItem extends AbstractEntity
{
    /**
     * @var int
     * @Extbase\ORM\Lazy
     */
    protected int $feUser = 0;

    /**
     * @var string
     */
    protected string $sessionId = '';

    protected ?Product $product = null;

    protected int $quantity = 1;

    public function getFeUser(): int
    {
        return $this->feUser;
    }

    public function setFeUser(int $feUser): void
    {
        $this->feUser = $feUser;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId): void
    {
        $this->sessionId = $sessionId;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getSubtotal(): float
    {
        if ($this->product === null) {
            return 0.0;
        }
        return $this->product->getPriceGross() * $this->quantity;
    }

    public function getSubtotalNet(): float
    {
        if ($this->product === null) {
            return 0.0;
        }
        return $this->product->getEffectivePrice() * $this->quantity;
    }

    public function getTaxAmount(): float
    {
        if ($this->product === null) {
            return 0.0;
        }
        return $this->product->getTaxAmount() * $this->quantity;
    }
}
