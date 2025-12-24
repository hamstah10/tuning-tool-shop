<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class ProductOption extends AbstractEntity
{
    protected string $title = '';

    protected string $type = 'select';

    protected bool $isRequired = false;

    protected int $sorting = 0;

    /**
     * @var ObjectStorage<ProductOptionValue>
     */
    #[Extbase\ORM\Lazy]
    #[Extbase\ORM\Cascade(['value' => 'remove'])]
    protected ObjectStorage $values;

    protected ?Product $product = null;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->values = new ObjectStorage();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getIsRequired(): bool
    {
        return $this->isRequired;
    }

    public function setIsRequired(bool $isRequired): void
    {
        $this->isRequired = $isRequired;
    }

    public function getSorting(): int
    {
        return $this->sorting;
    }

    public function setSorting(int $sorting): void
    {
        $this->sorting = $sorting;
    }

    /**
     * @return ObjectStorage<ProductOptionValue>
     */
    public function getValues(): ObjectStorage
    {
        return $this->values;
    }

    /**
     * @param ObjectStorage<ProductOptionValue> $values
     */
    public function setValues(ObjectStorage $values): void
    {
        $this->values = $values;
    }

    public function addValue(ProductOptionValue $value): void
    {
        $this->values->attach($value);
    }

    public function removeValue(ProductOptionValue $value): void
    {
        $this->values->detach($value);
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }
}
