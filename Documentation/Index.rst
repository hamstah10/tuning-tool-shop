:navigation-title: TuningToolShop

.. include:: /Includes.rst.txt

====================
TuningToolShop
====================

:Version:
   1.0.0

:Language:
   en

:Description:
   Professional e-commerce extension for TYPO3 CMS 13.4 providing comprehensive product management, shopping cart, order processing, and payment integration for automotive tuning devices and accessories.

:Keywords:
   shop, ecommerce, products, orders, cart, payment

:Copyright:
   2024

:Author:
   Hamstahstudio

:License:
   MIT

.. contents::
   :backlinks: none

Overview
========

TuningToolShop is a feature-rich e-commerce extension for TYPO3 CMS that enables you to:

- Manage products with detailed configurations and attributes
- Process customer orders with full order management
- Implement shopping cart functionality
- Integrate multiple payment providers (PayPal, Stripe, Klarna)
- Configure shipping methods
- Provide a REST API for external integrations
- Manage customers and their order history

Features
========

**Product Management**

- Create and manage products with SKU, pricing, and inventory
- Organize products into categories and manufacturers
- Tag products for flexible categorization
- Product variants and configurable attributes
- Product images and rich descriptions

**Shopping & Orders**

- Full shopping cart implementation
- Customer checkout process
- Order management and status tracking
- Order history for authenticated customers
- Payment status tracking

**Payment Integration**

- PayPal Commerce integration
- Stripe payment processing
- Klarna Buy Now Pay Later
- Extensible payment handler system

**REST API**

- Product endpoints for catalog access
- Order endpoints for order management
- OpenAPI 3.0 specification included
- Public API access without authentication

**Admin Interface**

- Dashboard with order and inventory widgets
- Product administration panel
- Category and manufacturer management
- Shipping and payment method configuration

Requirements
============

- TYPO3 CMS 13.4 or higher
- PHP 8.2 or higher
- nnrestapi extension 13.0 or higher
- MySQL/MariaDB or PostgreSQL

Installation
============

1. Install via Composer:

   .. code-block:: bash

      composer require hamstahstudio/tuning_tool_shop

2. Activate the extension in the TYPO3 backend or via command line:

   .. code-block:: bash

      php vendor/bin/typo3 extension:activate tuning_tool_shop

3. Run the setup script:

   .. code-block:: bash

      php vendor/bin/typo3 setup --no-interaction

4. Clear caches:

   .. code-block:: bash

      php vendor/bin/typo3 cache:flush

Configuration
=============

Basic Configuration
-------------------

After installation, configure the extension in TYPO3:

1. Go to **Admin Tools > Settings > Extension Configuration**
2. Select **tuning_tool_shop**
3. Configure your preferences

TypoScript
----------

Add the following to your TypoScript Setup:

.. code-block:: typoscript

   plugin.tx_tuningtoolshop {
       view {
           templateRootPaths.0 = EXT:tuning_tool_shop/Resources/Private/Templates/
           partialRootPaths.0 = EXT:tuning_tool_shop/Resources/Private/Partials/
           layoutRootPaths.0 = EXT:tuning_tool_shop/Resources/Private/Layouts/
       }
       persistence {
           storagePid = 
       }
   }

Pages Structure
---------------

Create the following page structure:

- **Shop** (main page)
  - Products
  - Categories
  - Cart
  - Checkout
  - Orders (for authenticated users)

Usage
=====

.. toctree::
   :maxdepth: 2

   User/Index
   Administrator/Index
   Developer/Index

API Reference
=============

The extension provides a comprehensive REST API:

- ``GET /api/product/all`` - All products
- ``GET /api/product/{uid}`` - Single product
- ``GET /api/product/active`` - Active products
- ``GET /api/product/search?term=...`` - Search products
- ``GET /api/order/all`` - All orders
- ``GET /api/order/{uid}`` - Single order
- ``GET /api/order/email?email=...`` - Orders by email

Full API documentation is available in ``openapi.yaml``.

Contributing
============

Contributions are welcome! Please follow the TYPO3 coding guidelines (PSR-12) and include tests for new features.

Support
=======

For issues, feature requests, or questions, please visit the extension repository or contact Hamstahstudio.

License
=======

This extension is licensed under the MIT License. See LICENSE file for details.
