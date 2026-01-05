# Solr Indexer for tuning_tool_shop Products

This configuration enables indexing of tuning_tool_shop products in Apache Solr.

## Setup

### 1. Enable the Configuration Set

In your main TypoScript constants, ensure the configuration set is included:

```typoscript
@import 'EXT:tuning_tool_shop/Configuration/Sets/TuningToolShopSolr/'
```

### 2. Configure Product Detail Page PID

Set the page ID for product detail views in your TypoScript constants:

```typoscript
plugin.tx_tuningtoolshop.settings.productDetailPid = YOUR_DETAIL_PAGE_ID
```

### 3. Indexed Fields

The following product fields are indexed:

| Field Name | Solr Field | Type | Description |
|---|---|---|---|
| Title | title | text | Product title |
| SKU | sku_stringS | string | Product SKU |
| Short Description | abstract | text | Short product description |
| Full Description | content | text | Concatenated product content |
| Price | price_doubleS | double | Product price |
| Special Price | special_price_doubleS | double | Discounted price |
| Stock | stock_intS | integer | Available stock quantity |
| In Stock | in_stock_boolS | boolean | Stock availability flag |
| Manufacturer | manufacturer_stringS | string | Product manufacturer |
| Categories | category_stringM | string (multi) | Product categories |
| Tags | tags_stringM | string (multi) | Product tags |
| Product Type | product_type_stringS | string | Product type (normal/digital) |
| Weight | weight_doubleS | double | Product weight |
| Shipping Free | shipping_free_boolS | boolean | Free shipping flag |
| Meta Title | metaTitle | text | SEO meta title |
| Meta Description | metaDescription | text | SEO meta description |
| Meta Keywords | metaKeywords | text | SEO meta keywords |

### 4. Indexing Only Active Products

By default, only products with `is_active = 1` are indexed. Modify the `where` clause in setup.typoscript if needed.

### 5. Trigger Indexing

Use TYPO3 backend scheduler or CLI to run the Solr Index Queue Worker:

```bash
php -r "require 'vendor/autoload.php'; \
  \TYPO3\CMS\Core\Core\Bootstrap::getInstance()->initializeClassLoader(\TYPO3\CMS\Core\Package\PackageManager::getInstance()); \
  \TYPO3\CMS\Solr\Task\IndexQueueWorkerTask::execute();"
```

Or use TYPO3 CLI:

```bash
typo3 solr:indexqueue:process
```

### 6. Search in Frontend

Use the standard Solr search plugin to search indexed products.

## Field Naming Convention

- **_stringS**: Single-valued string field
- **_stringM**: Multi-valued string field  
- **_doubleS**: Double (decimal) field
- **_intS**: Integer field
- **_boolS**: Boolean field
- **No suffix**: Standard text field (tokenized, searchable)

## Customization

To add additional fields:

1. Edit `setup.typoscript`
2. Add new field mapping in the `fields` section
3. Reindex products

## See Also

- [TYPO3 Solr Documentation](https://docs.typo3.org/p/apache-solr-for-typo3/solr/13.1/en-us/Index.html)
- [IndexQueue Configuration](https://docs.typo3.org/p/apache-solr-for-typo3/solr/13.1/en-us/IndexQueue/)
