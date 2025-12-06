<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Category extends AbstractEntity
{
    protected string $title = '';

    protected string $slug = '';

    protected string $description = '';

    protected ?FileReference $image = null;

    #[Extbase\ORM\Lazy]
    protected ?Category $parent = null;

    /**
     * @var ObjectStorage<Category>
     */
    #[Extbase\ORM\Lazy]
    #[Extbase\ORM\Cascade(['value' => 'remove'])]
    protected ObjectStorage $children;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->children = new ObjectStorage();
    }

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

    public function getImage(): ?FileReference
    {
        return $this->image;
    }

    public function setImage(?FileReference $image): void
    {
        $this->image = $image;
    }

    public function getParent(): ?Category
    {
        return $this->parent;
    }

    public function setParent(?Category $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return ObjectStorage<Category>
     */
    public function getChildren(): ObjectStorage
    {
        return $this->children;
    }

    /**
     * @param ObjectStorage<Category> $children
     */
    public function setChildren(ObjectStorage $children): void
    {
        $this->children = $children;
    }

    public function addChild(Category $child): void
    {
        $this->children->attach($child);
    }

    public function removeChild(Category $child): void
    {
        $this->children->detach($child);
    }
}
