<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\ViewHelpers;

use Hamstahstudio\TuningToolShop\Domain\Model\Product;
use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class SeoMetaTagsViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument(
            'product',
            Product::class,
            'The product object to extract meta information from',
            true
        );
    }

    public function render(): string
    {
        $product = $this->arguments['product'];

        if (!$product instanceof Product) {
            return '';
        }

        $metaTagManagerRegistry = GeneralUtility::makeInstance(MetaTagManagerRegistry::class);
        $manager = $metaTagManagerRegistry->getManagerForProperty('description');

        // Set description meta tag
        if (!empty($product->getMetaDescription())) {
            $manager->addProperty(
                'description',
                $product->getMetaDescription(),
                [],
                false
            );
        } elseif (!empty($product->getShortDescription())) {
            $manager->addProperty(
                'description',
                strip_tags($product->getShortDescription()),
                [],
                false
            );
        }

        // Set keywords meta tag
        if (!empty($product->getMetaKeywords())) {
            $manager = $metaTagManagerRegistry->getManagerForProperty('keywords');
            $manager->addProperty(
                'keywords',
                $product->getMetaKeywords(),
                [],
                false
            );
        }

        // Set canonical URL
        if (!empty($product->getCanonicalUrl())) {
            $manager = $metaTagManagerRegistry->getManagerForProperty('canonical');
            $manager->addProperty(
                'canonical',
                $product->getCanonicalUrl(),
                [],
                false
            );
        }

        // Open Graph tags
        if (!empty($product->getTitle())) {
            $manager = $metaTagManagerRegistry->getManagerForProperty('og:title');
            $manager->addProperty(
                'og:title',
                $product->getTitle(),
                [],
                false
            );
        }

        if (!empty($product->getShortDescription())) {
            $manager = $metaTagManagerRegistry->getManagerForProperty('og:description');
            $manager->addProperty(
                'og:description',
                strip_tags($product->getShortDescription()),
                [],
                false
            );
        }

        // Product image if available
        if ($product->getImages() && count($product->getImages()) > 0) {
            $firstImage = $product->getImages()->current();
            if ($firstImage) {
                $manager = $metaTagManagerRegistry->getManagerForProperty('og:image');
                $manager->addProperty(
                    'og:image',
                    (string)$firstImage->getOriginalResource()->getPublicUrl(),
                    [],
                    false
                );
            }
        }

        return '';
    }
}
