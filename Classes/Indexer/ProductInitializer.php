<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Indexer;

use ApacheSolrForTypo3\Solr\IndexQueue\Initializer\AbstractInitializer;

class ProductInitializer extends AbstractInitializer
{
    /**
     * Initialize the index queue - ensure $this->type is set
     */
    public function initialize(): bool
    {
        // Ensure type is set before calling parent
        if (empty($this->type)) {
            $this->type = 'tx_tuningtoolshop_domain_model_product';
        }
        
        // Call parent initialize which uses buildTcaWhereClause
        return parent::initialize();
    }

    /**
     * Override the WHERE clause to only include active products
     */
    protected function buildTcaWhereClause(): string
    {
        // Get base TCA where clause (deleted, hidden, etc.)
        $where = parent::buildTcaWhereClause();
        
        // Add is_active = 1 condition
        if ($where) {
            $where .= ' AND is_active = 1';
        } else {
            $where = 'is_active = 1';
        }
        
        return $where;
    }
}
