:navigation-title: Developer Guide

.. include:: /Includes.rst.txt

================
Developer Guide
================

This section provides technical documentation for developers extending the TuningToolShop extension.

.. toctree::
   :maxdepth: 2

   Architecture
   API
   Hooks
   Extending

Architecture Overview
=====================

Extension Structure
-------------------

.. code-block:: none

   tuning_tool_shop/
   ├── Classes/
   │   ├── Api/                    # REST API classes
   │   ├── Controller/             # Frontend controllers
   │   ├── Domain/
   │   │   ├── Model/             # Domain models
   │   │   └── Repository/        # Database repositories
   │   ├── Service/               # Business logic services
   │   ├── Payment/               # Payment handlers
   │   ├── Event/                 # Event listeners
   │   └── Dashboard/             # Dashboard widgets
   ├── Configuration/
   │   ├── TypoScript/           # TypoScript configuration
   │   └── TCA/                   # TYPO3 Column Arrangement
   ├── Resources/
   │   ├── Private/
   │   │   ├── Templates/        # Fluid templates
   │   │   ├── Partials/         # Fluid partials
   │   │   └── Layouts/          # Fluid layouts
   │   └── Public/               # Public assets (CSS, JS)
   └── Documentation/            # Extension documentation

Key Components
~~~~~~~~~~~~~~

- **Models** - Domain models for products, orders, customers
- **Repositories** - Database access layer
- **Controllers** - Frontend request handlers
- **Services** - Business logic implementation
- **API** - REST API endpoints

.. toctree::
   :hidden:

   Architecture
   API
   Hooks
   Extending
