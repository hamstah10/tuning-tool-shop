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

    /**
     * @var ObjectStorage<ProductDeliveryScope>
     */
    #[Extbase\ORM\Lazy]
    #[Extbase\ORM\Cascade(['value' => 'remove'])]
    protected ObjectStorage $lieferumfang;

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
     * @var ObjectStorage<Video>
     */
    #[Extbase\ORM\Lazy]
    #[Extbase\ORM\Cascade(['value' => 'remove'])]
    protected ObjectStorage $videos;

    /**
     * @var ObjectStorage<Download>
     */
    #[Extbase\ORM\Lazy]
    #[Extbase\ORM\Cascade(['value' => 'remove'])]
    protected ObjectStorage $documents;

    protected string $links = '';

    protected int $stock = 0;

    protected float $weight = 0.0;

    protected bool $isActive = true;

    protected bool $shippingFree = false;

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

    protected string $metaTitle = '';

    protected string $metaDescription = '';

    protected string $metaKeywords = '';

    protected string $canonicalUrl = '';

    protected string $badge = '';

    /**
     * @var ObjectStorage<Product>
     */
    #[Extbase\ORM\Lazy]
    protected ObjectStorage $relatedProducts;

    /**
     * @var ObjectStorage<Tag>
     */
    #[Extbase\ORM\Lazy]
    protected ObjectStorage $tags;

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
        $this->lieferumfang = new ObjectStorage();
        $this->shippingMethods = new ObjectStorage();
        $this->relatedProducts = new ObjectStorage();
        $this->tags = new ObjectStorage();
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

    /**
     * @return ObjectStorage<ProductDeliveryScope>
     */
    public function getLieferumfang(): ObjectStorage
    {
        return $this->lieferumfang;
    }

    /**
     * @param ObjectStorage<ProductDeliveryScope> $lieferumfang
     */
    public function setLieferumfang(ObjectStorage $lieferumfang): void
    {
        $this->lieferumfang = $lieferumfang;
    }

    public function addLieferumfang(ProductDeliveryScope $lieferumfang): void
    {
        $this->lieferumfang->attach($lieferumfang);
    }

    public function removeLieferumfang(ProductDeliveryScope $lieferumfang): void
    {
        $this->lieferumfang->detach($lieferumfang);
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
     * @return ObjectStorage<Video>
     */
    public function getVideos(): ObjectStorage
    {
        return $this->videos;
    }

    /**
     * @param ObjectStorage<Video> $videos
     */
    public function setVideos(ObjectStorage $videos): void
    {
        $this->videos = $videos;
    }

    public function addVideo(Video $video): void
    {
        $this->videos->attach($video);
    }

    public function removeVideo(Video $video): void
    {
        $this->videos->detach($video);
    }

    /**
     * @return ObjectStorage<Download>
     */
    public function getDocuments(): ObjectStorage
    {
        return $this->documents;
    }

    /**
     * @param ObjectStorage<Download> $documents
     */
    public function setDocuments(ObjectStorage $documents): void
    {
        $this->documents = $documents;
    }

    public function addDocument(Download $document): void
    {
        $this->documents->attach($document);
    }

    public function removeDocument(Download $document): void
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

    public function getShippingFree(): bool
    {
        return $this->shippingFree;
    }

    public function setShippingFree(bool $shippingFree): void
    {
        $this->shippingFree = $shippingFree;
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

    public function getMetaTitle(): string
    {
        return $this->metaTitle;
    }

    public function setMetaTitle(string $metaTitle): void
    {
        $this->metaTitle = $metaTitle;
    }

    public function getMetaDescription(): string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription): void
    {
        $this->metaDescription = $metaDescription;
    }

    public function getMetaKeywords(): string
    {
        return $this->metaKeywords;
    }

    public function setMetaKeywords(string $metaKeywords): void
    {
        $this->metaKeywords = $metaKeywords;
    }

    public function getCanonicalUrl(): string
    {
        return $this->canonicalUrl;
    }

    public function setCanonicalUrl(string $canonicalUrl): void
    {
        $this->canonicalUrl = $canonicalUrl;
    }

    public function getBadge(): string
    {
        return $this->badge;
    }

    public function setBadge(string $badge): void
    {
        $this->badge = $badge;
    }

    /**
     * @return ObjectStorage<Product>
     */
    public function getRelatedProducts(): ObjectStorage
    {
        return $this->relatedProducts;
    }

    /**
     * @param ObjectStorage<Product> $relatedProducts
     */
    public function setRelatedProducts(ObjectStorage $relatedProducts): void
    {
        $this->relatedProducts = $relatedProducts;
    }

    public function addRelatedProduct(Product $relatedProduct): void
    {
        $this->relatedProducts->attach($relatedProduct);
    }

    public function removeRelatedProduct(Product $relatedProduct): void
    {
        $this->relatedProducts->detach($relatedProduct);
    }

    /**
     * @return ObjectStorage<Tag>
     */
    public function getTags(): ObjectStorage
    {
        return $this->tags;
    }

    /**
     * @param ObjectStorage<Tag> $tags
     */
    public function setTags(ObjectStorage $tags): void
    {
        $this->tags = $tags;
    }

    public function addTag(Tag $tag): void
    {
        $this->tags->attach($tag);
    }

    public function removeTag(Tag $tag): void
    {
        $this->tags->detach($tag);
    }
}
