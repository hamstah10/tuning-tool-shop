:navigation-title: Configuration

.. include:: /Includes.rst.txt

=============
Configuration
=============

Extension Configuration
=======================

Access Configuration
--------------------

1. **Admin Tools > Settings > Extension Configuration**
2. Select **tuning_tool_shop**
3. Modify settings
4. Save

General Settings
~~~~~~~~~~~~~~~~

- **Store Name** - Your shop name
- **Store Email** - Contact email
- **Base Currency** - Default currency
- **Tax Rate** - Default tax percentage
- **Allow Guests** - Allow guest checkout

TypoScript Setup
================

Basic Configuration
-------------------

Include setup file:

.. code-block:: typoscript

   <INCLUDE_TYPOSCRIPT: source="FILE:EXT:tuning_tool_shop/Configuration/TypoScript/setup.typoscript">

Plugin Setup
~~~~~~~~~~~~

Configure plugin:

.. code-block:: typoscript

   plugin.tx_tuningtoolshop {
       view {
           templateRootPaths.0 = EXT:tuning_tool_shop/Resources/Private/Templates/
           partialRootPaths.0 = EXT:tuning_tool_shop/Resources/Private/Partials/
           layoutRootPaths.0 = EXT:tuning_tool_shop/Resources/Private/Layouts/
       }
       persistence {
           storagePid = 123
       }
   }

Storage PID Configuration
~~~~~~~~~~~~~~~~~~~~~~~~~~

Set storage folder:

.. code-block:: typoscript

   plugin.tx_tuningtoolshop {
       persistence {
           storagePid = 123
       }
   }

Payment Methods
===============

PayPal Configuration
--------------------

1. **Admin Tools > Settings > Extension Configuration**
2. Select **tuning_tool_shop**
3. Find **Payment Methods** section
4. Configure PayPal:

   - Client ID
   - Client Secret
   - Mode (Sandbox/Live)
   - Webhook URL

Testing PayPal
~~~~~~~~~~~~~~

1. Use Sandbox credentials
2. Test checkout process
3. Verify payment success
4. Check order status

Live PayPal Setup
~~~~~~~~~~~~~~~~~

1. Get Production credentials
2. Switch to Live mode
3. Update Client ID/Secret
4. Clear caches

Stripe Configuration
--------------------

1. Go to Extension Configuration
2. Find **Stripe Settings**
3. Enter:

   - Publishable Key
   - Secret Key
   - Webhook Secret
   - Mode (Test/Live)

Testing Stripe
~~~~~~~~~~~~~~

1. Use Stripe Test keys
2. Use test card numbers:

   - 4242 4242 4242 4242 (Visa)
   - 5555 5555 5555 4444 (Mastercard)

Live Stripe Setup
~~~~~~~~~~~~~~~~~

1. Use Production keys
2. Switch to Live mode
3. Configure webhooks
4. Clear caches

Klarna Configuration
--------------------

1. Go to Extension Configuration
2. Find **Klarna Settings**
3. Configure:

   - Merchant ID
   - API Key
   - Mode (Test/Live)

Shipping Methods
================

Configuring Shipping
--------------------

1. Go to **Admin Tools > Shop Settings > Shipping**
2. Click "Add Shipping Method"
3. Enter details:

   - Carrier name (DHL, FedEx, etc.)
   - Description
   - Base price
   - Weight-based pricing
   - Countries/zones
   - Status (active/inactive)

Shipping Rates
~~~~~~~~~~~~~~

Configure by:

- Fixed price
- Weight brackets
- Zone-based pricing
- Order amount thresholds

Weight-Based Pricing
~~~~~~~~~~~~~~~~~~~~

Set prices by weight:

- **0-5 kg** - €10.00
- **5-10 kg** - €15.00
- **10-20 kg** - €20.00
- **20+ kg** - €30.00

Zone-Based Pricing
~~~~~~~~~~~~~~~~~~

Different rates by region:

- **Zone 1** - Domestic: €5.00
- **Zone 2** - Europe: €15.00
- **Zone 3** - Worldwide: €25.00

Tax Configuration
=================

Tax Settings
------------

1. Go to **Admin Tools > Shop Settings > Taxes**
2. Configure:

   - Default tax rate
   - Tax per category
   - Tax per country
   - Tax per product

Standard Tax Rate
~~~~~~~~~~~~~~~~~

.. code-block:: typoscript

   plugin.tx_tuningtoolshop {
       shop {
           tax {
               standardRate = 19
           }
       }
   }

Product-Specific Tax
~~~~~~~~~~~~~~~~~~~~

In product detail:

- Tax-exempt products
- Special tax rates
- Tax class assignment

Email Configuration
===================

Email Templates
---------------

Configure email notifications:

1. **Admin Tools > Shop Settings > Emails**
2. Select email type
3. Edit template
4. Configure sender
5. Set recipients

Email Types
~~~~~~~~~~~

- Order confirmation
- Payment confirmation
- Shipping notification
- Return confirmation
- Refund notification
- Abandoned cart

Email Settings
~~~~~~~~~~~~~~

.. code-block:: typoscript

   plugin.tx_tuningtoolshop {
       email {
           senderName = Your Shop
           senderEmail = orders@yourshop.com
           adminEmail = admin@yourshop.com
       }
   }

Cache Configuration
===================

Caching Settings
----------------

Enable caching for:

- Product listings
- Category pages
- Search results
- User sessions

Cache Invalidation
~~~~~~~~~~~~~~~~~~

Clear cache when:

- Products added/modified
- Prices changed
- Categories modified
- Shipping methods updated

.. code-block:: bash

   php vendor/bin/typo3 cache:flush

Security
========

SSL/HTTPS
---------

Enforce HTTPS:

.. code-block:: typoscript

   [request.getNormalizedParams()['HTTPS'] != 'on']
       config.absRefPrefix = https://yourdomain.com/
   [end]

Password Requirements
~~~~~~~~~~~~~~~~~~~~~

Configure in Extension Settings:

- Minimum length
- Complexity requirements
- Expiration period

PCI Compliance
~~~~~~~~~~~~~~

- Never store full card numbers
- Use tokenized payments
- Enable HTTPS everywhere
- Regular security audits

Advanced Configuration
======================

Custom Templates
----------------

Override templates:

1. Create folder: **typo3conf/ext/your_site/Resources/Private/Templates/**
2. Copy extension templates
3. Modify as needed
4. Update TypoScript path:

.. code-block:: typoscript

   plugin.tx_tuningtoolshop {
       view {
           templateRootPaths.0 = EXT:your_site/Resources/Private/Templates/
       }
   }

Custom Hooks
~~~~~~~~~~~~

Register custom hooks:

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tuning_tool_shop']
       ['beforeOrderCreation'][] = \Vendor\YourExt\Hooks\OrderHook::class;

Database Extensions
~~~~~~~~~~~~~~~~~~~

Extend models with additional fields via TCA configuration.

Debugging
=========

Enable Debug Mode
-----------------

In Local Configuration:

.. code-block:: php

   'BE' => [
       'debug' => true,
   ],

View System Information
~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: bash

   php vendor/bin/typo3 configuration:show

Check Extension Status
~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: bash

   php vendor/bin/typo3 extension:list
