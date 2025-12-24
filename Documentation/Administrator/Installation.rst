:navigation-title: Installation

.. include:: /Includes.rst.txt

============
Installation
============

Prerequisites
=============

Required Software
-----------------

- **TYPO3 CMS** 13.4 or higher
- **PHP** 8.2 or higher
- **MySQL** 5.7+ or **MariaDB** 10.2+
- **nnrestapi** extension 13.0 or higher

Recommended
~~~~~~~~~~~

- PHP 8.3 or higher
- MySQL 8.0+ or MariaDB 10.5+
- Composer package manager
- Git for version control

Installation via Composer
=========================

Install Package
---------------

Using Composer (recommended):

.. code-block:: bash

   composer require hamstahstudio/tuning_tool_shop

This installs:

- tuning_tool_shop extension
- Dependencies (nnrestapi, etc.)
- Updates composer.json and composer.lock

Activate Extension
------------------

Via Command Line:

.. code-block:: bash

   php vendor/bin/typo3 extension:activate tuning_tool_shop

Or in TYPO3 Backend:

1. Go to **Admin Tools > Extensions**
2. Search for "TuningToolShop"
3. Click activate icon
4. Confirm activation

Running Setup
=============

Database Setup
--------------

Run TYPO3 setup:

.. code-block:: bash

   php vendor/bin/typo3 setup --no-interaction

This:

- Creates necessary database tables
- Initializes extension configuration
- Sets up default settings

Clear Caches
~~~~~~~~~~~~

After installation:

.. code-block:: bash

   php vendor/bin/typo3 cache:flush

Or in Backend:

1. **Admin Tools > Clear Cache**
2. Click "Flush all caches"

Verification
============

Verify Installation
-------------------

Check if extension loaded:

.. code-block:: bash

   php vendor/bin/typo3 configuration:show

Should show tuning_tool_shop listed.

Test REST API
~~~~~~~~~~~~~

Test API endpoints:

.. code-block:: bash

   curl -s https://yourdomain.com/api/product/all | json_pp

Should return JSON response.

Database Tables
~~~~~~~~~~~~~~~

Verify database tables created:

- tx_tuningtoolshop_domain_model_product
- tx_tuningtoolshop_domain_model_order
- tx_tuningtoolshop_domain_model_category
- tx_tuningtoolshop_domain_model_manufacturer
- (And additional tables)

Initial Configuration
=====================

Basic Setup
-----------

1. **Storage Folder** - Create folder for products/orders
2. **Page Tree** - Create shop pages:

   - Products page
   - Cart page
   - Checkout page
   - Order page

3. **TypoScript** - Add setup to root template
4. **Payment** - Configure payment methods
5. **Shipping** - Configure shipping methods

Creating Page Structure
~~~~~~~~~~~~~~~~~~~~~~~

Create in TYPO3 Page Tree:

- **Shop** (page)
  - Products (plugin page)
  - Cart (plugin page)
  - Checkout (plugin page)
  - Orders (plugin page)

Adding Plugins
--------------

On each page:

1. Click "Create content"
2. Select "Plugin"
3. Choose TuningToolShop plugin type
4. Configure plugin settings

Plugin Types
~~~~~~~~~~~~

- **Product List** - Display products
- **Product Detail** - Single product
- **Cart** - Shopping cart
- **Checkout** - Checkout process
- **Orders** - Order history

Configuration File
==================

Extension Configuration
-----------------------

File location:

.. code-block:: none

   EXT:tuning_tool_shop/ext_localconf.php
   EXT:tuning_tool_shop/ext_tables.php
   EXT:tuning_tool_shop/ext_emconf.php

Manual Configuration
~~~~~~~~~~~~~~~~~~~~

Edit in Backend:

1. **Admin Tools > Settings > Extension Configuration**
2. Select TuningToolShop
3. Modify settings
4. Save configuration

TypoScript Setup
================

Basic Template Setup
--------------------

Add to root template:

.. code-block:: typoscript

   <INCLUDE_TYPOSCRIPT: source="FILE:EXT:tuning_tool_shop/Configuration/TypoScript/setup.typoscript">

Plugin Configuration
~~~~~~~~~~~~~~~~~~~~

Configure plugin paths:

.. code-block:: typoscript

   plugin.tx_tuningtoolshop {
       view {
           templateRootPaths.0 = EXT:tuning_tool_shop/Resources/Private/Templates/
           partialRootPaths.0 = EXT:tuning_tool_shop/Resources/Private/Partials/
           layoutRootPaths.0 = EXT:tuning_tool_shop/Resources/Private/Layouts/
       }
   }

Troubleshooting
===============

Common Issues
-------------

**Extension not loading**

- Verify dependencies installed
- Check PHP version
- Clear caches
- Check error logs

**Database errors**

- Run setup again
- Check database permissions
- Verify MySQL version
- Check disk space

**API returns 404**

- Verify nnrestapi installed
- Clear REST API cache
- Check routing configuration
- Verify API classes registered

**Pages not displaying**

- Verify plugins added to pages
- Check page visibility
- Verify storage folder set
- Check TypoScript included

Error Logs
~~~~~~~~~~

Check logs in:

.. code-block:: bash

   var/log/typo3_*.log

Run diagnostics:

.. code-block:: bash

   php vendor/bin/typo3 upgrade:run

Support
~~~~~~~

For installation help:

- Check official documentation
- Review error messages
- Check system requirements
- Contact support
