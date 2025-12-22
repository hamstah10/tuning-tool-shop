<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Tag extends AbstractEntity
{
    protected string $title = '';

    protected string $slug = '';

    protected string $description = '';

    protected string $color = '';

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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }
}
