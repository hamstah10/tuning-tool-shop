<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class ProductLink extends AbstractEntity
{
    protected string $title = '';
    protected string $url = '';
    protected int $sorting = 0;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getSorting(): int
    {
        return $this->sorting;
    }

    public function setSorting(int $sorting): void
    {
        $this->sorting = $sorting;
    }
}
