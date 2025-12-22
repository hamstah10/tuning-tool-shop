<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Seo;

use Hamstahstudio\TuningToolShop\Domain\Model\Product;
use TYPO3\CMS\Core\PageTitle\PageTitleProviderInterface;

class ProductPageTitleProvider implements PageTitleProviderInterface
{
    private string $title = '';
    private ?Product $product = null;

    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }

    public function getTitle(): string
    {
        if ($this->product instanceof Product) {
            if (!empty($this->product->getMetaTitle())) {
                return $this->product->getMetaTitle();
            }
            
            if (!empty($this->product->getTitle())) {
                return $this->product->getTitle();
            }
        }
        
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
