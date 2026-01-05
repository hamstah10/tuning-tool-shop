<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Service;

use ApacheSolrForTypo3\Solr\IndexQueue\AbstractIndexer;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SolrIndexer extends AbstractIndexer
{
    public function indexItem($item)
    {
        $products = $this->getProducts();

        foreach ($products as $product) {
            $document = $this->getInitialDocument($item);
            $document->setField('id', $product['uid']);
            $document->setField('title', $product['title']);
            $document->setField('sku_stringS', $product['sku']);
            $document->setField('abstract', $product['short_description']);
            
            // Inhaltsfelder
            $content = trim($product['description'] . ' ' . $product['headline'] . ' ' . $product['features_text'] . ' ' . $product['recommendation_text']);
            $document->setField('content', $content);

            // Preise
            $document->setField('price_doubleS', $product['price']);
            $document->setField('special_price_doubleS', $product['special_price']);
            // Meta-Informationen
            $document->setField('metaDescription', $product['meta_description']);
            $document->setField('metaKeywords', $product['meta_keywords']);
            $document->setField('metaTitle', $product['meta_title']);
            // Lagerstatus
            $document->setField('stock_intS', $product['stock']);
            $document->setField('in_stock_boolS', $product['stock'] > 0 ? '1' : '0');
            // Hersteller
            $document->setField('manufacturer_stringS', $product['manufacturer']);
            // Kategorien
            $document->setField('category_stringM', implode(',', $product['categories']));
            // Tags
            $document->setField('tags_stringM', implode(',', $product['tags']));
            // Produkt-Typ
            $document->setField('product_type_stringS', $product['product_type']);
            // Gewicht
            $document->setField('weight_doubleS', $product['weight']);
            // URL generieren
            $document->setField('url', $this->generateUrl($product['uid']));
            
            // Hinzufügen des Dokuments zur Indexierung
            $this->solrConnection->addDocument($document);
        }
    }

    protected function getProducts()
    {
        // Abfrage zum Abrufen aktiver Produkte
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_tuningtoolshop_domain_model_product');

        return $queryBuilder
            ->select('*')
            ->from('tx_tuningtoolshop_domain_model_product')
            ->where('is_active = 1')
            ->executeQuery()
            ->fetchAllAssociative();
    }

    protected function generateUrl($uid)
    {
        return '/product-detail/' . $uid;
    }
}
