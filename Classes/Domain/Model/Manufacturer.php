<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Manufacturer extends AbstractEntity
{
    protected string $title = '';

    protected string $slug = '';

    protected ?FileReference $logo = null;

    protected string $description = '';

    protected string $website = '';

    protected ?int $manufacturerPage = null;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getLogo(): ?FileReference
    {
        return $this->logo;
    }

    public function setLogo(?FileReference $logo): void
    {
        $this->logo = $logo;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function setWebsite(string $website): void
    {
        $this->website = $website;
    }

    public function getManufacturerPage(): ?int
    {
        return $this->manufacturerPage;
    }

    public function setManufacturerPage(?int $manufacturerPage): void
    {
        $this->manufacturerPage = $manufacturerPage;
    }
}
