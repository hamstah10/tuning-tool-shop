<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Product extends AbstractEntity
{
    protected string $title = '';

    protected string $slug = '';

    protected string $sku = '';

    protected float $price = 0.0;

    protected float $specialPrice = 0.0;

    protected string $description = '';

    protected string $shortDescription = '';

    protected string $headline = '';

    protected string $lieferumfang = '';

    protected ?Manufacturer $manufacturer = null;

    /**
     * @var ObjectStorage<Category>
     */
    #[Extbase\ORM\Lazy]
    protected ObjectStorage $categories;

    /**
     * @var ObjectStorage<FileReference>
     */
    #[Extbase\ORM\Lazy]
    #[Extbase\ORM\Cascade(['value' => 'remove'])]
    protected ObjectStorage $images;

    /**
     * @var ObjectStorage<FileReference>
     */
    #[Extbase\ORM\Lazy]
    #[Extbase\ORM\Cascade(['value' => 'remove'])]
    protected ObjectStorage $videos;

    /**
     * @var ObjectStorage<FileReference>
     */
    #[Extbase\ORM\Lazy]
    #[Extbase\ORM\Cascade(['value' => 'remove'])]
    protected ObjectStorage $documents;

    protected string $links = '';

    protected int $stock = 0;

    protected float $weight = 0.0;

    protected bool $isActive = true;

    protected ?Tax $tax = null;

    /**
     * @var ObjectStorage<ShippingMethod>
     */
    #[Extbase\ORM\Lazy]
    protected ObjectStorage $shippingMethods;

    protected string $productType = 'normal';

    protected string $operatingCosts = '';

    protected string $extensions = '';

    protected string $startupHelpHeadline = '';

    protected string $startupHelpText = '';

    protected string $featuresHeadline = '';

    protected string $featuresText = '';

    protected string $recommendationHeadline = '';

    protected string $recommendationText = '';

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->categories = new ObjectStorage();
        $this->images = new ObjectStorage();
        $this->videos = new ObjectStorage();
        $this->documents = new ObjectStorage();
        $this->shippingMethods = new ObjectStorage();
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

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getSpecialPrice(): float
    {
        return $this->specialPrice;
    }

    public function setSpecialPrice(float $specialPrice): void
    {
        $this->specialPrice = $specialPrice;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }

    public function getHeadline(): string
    {
        return $this->headline;
    }

    public function setHeadline(string $headline): void
    {
        $this->headline = $headline;
    }

    public function getLieferumfang(): string
    {
        return $this->lieferumfang;
    }

    public function setLieferumfang(string $lieferumfang): void
    {
        $this->lieferumfang = $lieferumfang;
    }

    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?Manufacturer $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    /**
     * @return ObjectStorage<Category>
     */
    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    /**
     * @param ObjectStorage<Category> $categories
     */
    public function setCategories(ObjectStorage $categories): void
    {
        $this->categories = $categories;
    }

    public function addCategory(Category $category): void
    {
        $this->categories->attach($category);
    }

    public function removeCategory(Category $category): void
    {
        $this->categories->detach($category);
    }

    /**
     * @return ObjectStorage<FileReference>
     */
    public function getImages(): ObjectStorage
    {
        return $this->images;
    }

    /**
     * @param ObjectStorage<FileReference> $images
     */
    public function setImages(ObjectStorage $images): void
    {
        $this->images = $images;
    }

    public function addImage(FileReference $image): void
    {
        $this->images->attach($image);
    }

    public function removeImage(FileReference $image): void
    {
        $this->images->detach($image);
    }

    /**
     * @return ObjectStorage<FileReference>
     */
    public function getVideos(): ObjectStorage
    {
        return $this->videos;
    }

    /**
     * @param ObjectStorage<FileReference> $videos
     */
    public function setVideos(ObjectStorage $videos): void
    {
        $this->videos = $videos;
    }

    public function addVideo(FileReference $video): void
    {
        $this->videos->attach($video);
    }

    public function removeVideo(FileReference $video): void
    {
        $this->videos->detach($video);
    }

    /**
     * @return ObjectStorage<FileReference>
     */
    public function getDocuments(): ObjectStorage
    {
        return $this->documents;
    }

    /**
     * @param ObjectStorage<FileReference> $documents
     */
    public function setDocuments(ObjectStorage $documents): void
    {
        $this->documents = $documents;
    }

    public function addDocument(FileReference $document): void
    {
        $this->documents->attach($document);
    }

    public function removeDocument(FileReference $document): void
    {
        $this->documents->detach($document);
    }

    public function getLinks(): string
    {
        return $this->links;
    }

    public function setLinks(string $links): void
    {
        $this->links = $links;
    }

    /**
     * @return array<string, mixed>
     */
    public function getLinksDecoded(): array
    {
        if ($this->links === '') {
            return [];
        }
        return json_decode($this->links, true) ?? [];
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getEffectivePrice(): float
    {
        return $this->specialPrice > 0 ? $this->specialPrice : $this->price;
    }

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function getTax(): ?Tax
    {
        return $this->tax;
    }

    public function setTax(?Tax $tax): void
    {
        $this->tax = $tax;
    }

    public function getPriceGross(): float
    {
        $price = $this->getEffectivePrice();
        if ($this->tax !== null) {
            return $this->tax->calculateGross($price);
        }
        return $price;
    }

    public function getTaxAmount(): float
    {
        $price = $this->getEffectivePrice();
        if ($this->tax !== null) {
            return $this->tax->calculateTax($price);
        }
        return 0.0;
    }

    /**
     * @return ObjectStorage<ShippingMethod>
     */
    public function getShippingMethods(): ObjectStorage
    {
        return $this->shippingMethods;
    }

    /**
     * @param ObjectStorage<ShippingMethod> $shippingMethods
     */
    public function setShippingMethods(ObjectStorage $shippingMethods): void
    {
        $this->shippingMethods = $shippingMethods;
    }

    public function addShippingMethod(ShippingMethod $shippingMethod): void
    {
        $this->shippingMethods->attach($shippingMethod);
    }

    public function removeShippingMethod(ShippingMethod $shippingMethod): void
    {
        $this->shippingMethods->detach($shippingMethod);
    }

    public function getProductType(): string
    {
        return $this->productType;
    }

    public function setProductType(string $productType): void
    {
        $this->productType = $productType;
    }

    public function getOperatingCosts(): string
    {
        return $this->operatingCosts;
    }

    public function setOperatingCosts(string $operatingCosts): void
    {
        $this->operatingCosts = $operatingCosts;
    }

    public function getExtensions(): string
    {
        return $this->extensions;
    }

    public function setExtensions(string $extensions): void
    {
        $this->extensions = $extensions;
    }

    public function getStartupHelpHeadline(): string
    {
        return $this->startupHelpHeadline;
    }

    public function setStartupHelpHeadline(string $startupHelpHeadline): void
    {
        $this->startupHelpHeadline = $startupHelpHeadline;
    }

    public function getStartupHelpText(): string
    {
        return $this->startupHelpText;
    }

    public function setStartupHelpText(string $startupHelpText): void
    {
        $this->startupHelpText = $startupHelpText;
    }

    public function getFeaturesHeadline(): string
    {
        return $this->featuresHeadline;
    }

    public function setFeaturesHeadline(string $featuresHeadline): void
    {
        $this->featuresHeadline = $featuresHeadline;
    }

    public function getFeaturesText(): string
    {
        return $this->featuresText;
    }

    public function setFeaturesText(string $featuresText): void
    {
        $this->featuresText = $featuresText;
    }

    public function getRecommendationHeadline(): string
    {
        return $this->recommendationHeadline;
    }

    public function setRecommendationHeadline(string $recommendationHeadline): void
    {
        $this->recommendationHeadline = $recommendationHeadline;
    }

    public function getRecommendationText(): string
    {
        return $this->recommendationText;
    }

    public function setRecommendationText(string $recommendationText): void
    {
        $this->recommendationText = $recommendationText;
    }
}
