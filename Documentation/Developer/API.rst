:navigation-title: REST API

.. include:: /Includes.rst.txt

========
REST API
========

The extension provides a comprehensive REST API based on nnrestapi.

API Base URL
============

.. code-block:: none

   https://yourdomain.com/api/

Product API
===========

Get All Products
----------------

.. code-block:: bash

   GET /api/product/all

Response:

.. code-block:: json

   {
     "success": true,
     "data": [
       {
         "uid": 1,
         "title": "Product Name",
         "sku": "SKU-001",
         "price": 299.99,
         "isActive": true
       }
     ],
     "count": 1
   }

Get Single Product
~~~~~~~~~~~~~~~~~~~

.. code-block:: bash

   GET /api/product/1

Get Active Products
~~~~~~~~~~~~~~~~~~~

.. code-block:: bash

   GET /api/product/active

Search Products
~~~~~~~~~~~~~~~

.. code-block:: bash

   GET /api/product/search?term=chiptuning

Get Recent Products
~~~~~~~~~~~~~~~~~~~

.. code-block:: bash

   GET /api/product/recent?limit=10

Get Product by SKU
~~~~~~~~~~~~~~~~~~

.. code-block:: bash

   GET /api/product/sku?sku=SKU-001

Order API
=========

Get All Orders
--------------

.. code-block:: bash

   GET /api/order/all

Get Single Order
~~~~~~~~~~~~~~~~

.. code-block:: bash

   GET /api/order/1

Get Order by Number
~~~~~~~~~~~~~~~~~~~

.. code-block:: bash

   GET /api/order/number?number=ORD-2024-0001

Get Orders by Email
~~~~~~~~~~~~~~~~~~~

.. code-block:: bash

   GET /api/order/email?email=customer@example.com

Get Orders by Status
~~~~~~~~~~~~~~~~~~~~

.. code-block:: bash

   GET /api/order/status?status=2

Get Orders by User
~~~~~~~~~~~~~~~~~~

.. code-block:: bash

   GET /api/order/user?user=123

Get Recent Orders
~~~~~~~~~~~~~~~~~

.. code-block:: bash

   GET /api/order/recent?limit=5

Response Format
===============

Success Response
----------------

.. code-block:: json

   {
     "success": true,
     "data": { /* Model or Array of Models */ },
     "count": 1
   }

Error Response
~~~~~~~~~~~~~~

.. code-block:: json

   {
     "success": false,
     "message": "Error description"
   }

OpenAPI Documentation
=====================

Full API specification in:

.. code-block:: none

   EXT:tuning_tool_shop/openapi.yaml

View interactive documentation:

- Use Swagger UI
- Use ReDoc
- Use Postman collection

API Implementation
==================

Product API Class
-----------------

Location: ``Classes/Api/Product.php``

.. code-block:: php

   class Product extends AbstractApi
   {
       public function __construct(
           readonly private ProductRepository $productRepository,
           readonly private LoggerInterface $logger
       ) {}

       /**
        * @Api\Route("/product/all")
        * @Api\Access("public")
        */
       public function getAllAction(): array
       {
           return [
               'success' => true,
               'data' => $this->productRepository->findAllIgnoreStorage(),
           ];
       }
   }

Order API Class
~~~~~~~~~~~~~~~

Location: ``Classes/Api/Order.php``

Similar structure for order endpoints.

Extending the API
=================

Creating Custom Endpoint
------------------------

1. Add method to API class:

.. code-block:: php

   /**
    * @Api\Route("/product/bestseller")
    * @Api\Access("public")
    */
   public function getBestsellerAction(): array
   {
       // Custom logic
       return [
           'success' => true,
           'data' => $products,
       ];
   }

2. Clear cache:

.. code-block:: bash

   php vendor/bin/typo3 cache:flush

3. Access endpoint:

.. code-block:: bash

   GET /api/product/bestseller

Repository Methods
==================

Common Methods
--------------

Existing repository methods:

- ``findAll()`` - All records with storage filtering
- ``findAllIgnoreStorage()`` - All records, no filtering
- ``findByUidIgnoreStorage(int $uid)`` - Single record
- ``findActive()`` - Only active products
- ``findRecent(int $limit)`` - Recent records
- ``searchByTerm(string $term)`` - Search products

Adding Repository Method
~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   public function findByPriceRange(float $min, float $max): QueryResultInterface
   {
       $query = $this->createQuery();
       $query->getQuerySettings()->setRespectStoragePage(false);
       $query->matching(
           $query->logicalAnd(
               $query->greaterThanOrEqual('price', $min),
               $query->lessThanOrEqual('price', $max)
           )
       );
       return $query->execute();
   }

Usage Examples
==============

JavaScript Fetch
----------------

.. code-block:: javascript

   fetch('/api/product/all')
     .then(res => res.json())
     .then(data => console.log(data));

JavaScript Axios
~~~~~~~~~~~~~~~~

.. code-block:: javascript

   axios.get('/api/product/all')
     .then(response => console.log(response.data));

PHP cURL
~~~~~~~~

.. code-block:: php

   $ch = curl_init('https://domain.com/api/product/all');
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   $response = curl_exec($ch);
   $data = json_decode($response, true);

Python Requests
~~~~~~~~~~~~~~~

.. code-block:: python

   import requests
   
   response = requests.get('https://domain.com/api/product/all')
   data = response.json()

API Documentation
==================

Interactive Documentation
--------------------------

Access via:

- Swagger UI: ``/api/swagger``
- ReDoc: ``/api/redoc``
- Postman collection included

Authentication (Future)
=======================

Currently APIs are public. To add authentication:

1. Add annotation:

.. code-block:: php

   /**
    * @Api\Access("token")
    */
   public function getIndexAction(): array
   {
       // Requires JWT token
   }

2. Include token in header:

.. code-block:: bash

   curl -H "Authorization: Bearer token" /api/endpoint
