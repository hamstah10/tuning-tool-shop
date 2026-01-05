<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class PaymentMethod extends AbstractEntity
{
    protected string $title = '';

    protected string $description = '';

    protected ?FileReference $icon = null;

    protected bool $isActive = true;

    protected int $sortOrder = 0;

    protected string $handlerClass = '';

    protected string $clientId = '';

    protected string $secret = '';

    protected string $apiUrl = '';

    protected bool $isSandbox = true;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getIcon(): ?FileReference
    {
        return $this->icon;
    }

    public function setIcon(?FileReference $icon): void
    {
        $this->icon = $icon;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): void
    {
        $this->sortOrder = $sortOrder;
    }

    public function getHandlerClass(): string
    {
        return $this->handlerClass;
    }

    public function setHandlerClass(string $handlerClass): void
    {
        $this->handlerClass = $handlerClass;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function setClientId(string $clientId): void
    {
        $this->clientId = $clientId;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function setSecret(string $secret): void
    {
        $this->secret = $secret;
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    public function setApiUrl(string $apiUrl): void
    {
        $this->apiUrl = $apiUrl;
    }

    public function getIsSandbox(): bool
    {
        return $this->isSandbox;
    }

    public function setIsSandbox(bool $isSandbox): void
    {
        $this->isSandbox = $isSandbox;
    }
}
