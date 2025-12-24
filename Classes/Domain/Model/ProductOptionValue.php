<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class ProductOptionValue extends AbstractEntity
{
    protected string $title = '';

    protected string $description = '';

    protected float $priceModifier = 0.0;

    protected float $specialPrice = 0.0;

    /**
     * @var ObjectStorage<FileReference>
     */
    #[Extbase\ORM\Lazy]
    protected ObjectStorage $image;

    protected int $sorting = 0;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->image = new ObjectStorage();
    }

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

    public function getPriceModifier(): float
    {
        return $this->priceModifier;
    }

    public function setPriceModifier(float $priceModifier): void
    {
        $this->priceModifier = $priceModifier;
    }

    public function getSpecialPrice(): float
    {
        return $this->specialPrice;
    }

    public function setSpecialPrice(float $specialPrice): void
    {
        $this->specialPrice = $specialPrice;
    }

    /**
     * @return ObjectStorage<FileReference>
     */
    public function getImage(): ObjectStorage
    {
        return $this->image;
    }

    /**
     * @param ObjectStorage<FileReference> $image
     */
    public function setImage(ObjectStorage $image): void
    {
        $this->image = $image;
    }

    public function addImage(FileReference $image): void
    {
        $this->image->attach($image);
    }

    public function removeImage(FileReference $image): void
    {
        $this->image->detach($image);
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
