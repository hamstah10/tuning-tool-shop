<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Repository\ProductRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ProductSliderController extends ActionController
{
    public function __construct(
        protected readonly ProductRepository $productRepository,
    ) {}

    public function listAction(): ResponseInterface
    {
        // Check if specific products are selected
        $selectedProductIds = $this->settings['selectedProducts'] ?? '';
        
        if (!empty($selectedProductIds)) {
            // Use selected products
            $productIds = array_map('intval', array_filter(explode(',', $selectedProductIds)));
            $products = !empty($productIds) ? $this->productRepository->findByIds($productIds) : [];
        } else {
            // Fallback to all products if none selected
            $products = $this->productRepository->findAll();
        }

        // Convert ObjectStorage to array if needed for template
        $productsArray = is_array($products) ? $products : $products->toArray();

        // Apply items limit from FlexForm
        $itemsLimit = (int)($this->settings['itemsLimit'] ?? 4);
        if ($itemsLimit > 0 && count($productsArray) > $itemsLimit) {
            $productsArray = array_slice($productsArray, 0, $itemsLimit);
        }

        $detailPid = (int)($this->settings['detailPid'] ?? 0);
        $cartPid = (int)($this->settings['cartPid'] ?? 0);

        $this->view->assignMultiple([
            'products' => $productsArray,
            'detailPid' => $detailPid,
            'cartPid' => $cartPid,
        ]);

        return $this->htmlResponse();
    }
}
