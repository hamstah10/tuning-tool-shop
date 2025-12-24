:navigation-title: Hooks & Events

.. include:: /Includes.rst.txt

===============
Hooks & Events
===============

Extension points for custom development.

Available Hooks
===============

Order Creation Hook
-------------------

Register custom hook:

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tuning_tool_shop']
       ['beforeOrderCreation'][] = \YourVendor\YourExt\Hooks\OrderHook::class;

Hook class:

.. code-block:: php

   class OrderHook
   {
       public function beforeCreation(Order $order): void
       {
           // Custom logic before order is created
           // Validate, modify, or cancel order
       }
   }

Payment Processing Hook
-----------------------

Hook for payment processing:

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tuning_tool_shop']
       ['afterPayment'][] = \YourVendor\YourExt\Hooks\PaymentHook::class;

Email Sending Hook
~~~~~~~~~~~~~~~~~~

Customize emails:

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tuning_tool_shop']
       ['beforeEmailSend'][] = \YourVendor\YourExt\Hooks\EmailHook::class;

TYPO3 Events
============

Event-Based Hooks
-----------------

Modern TYPO3 uses PSR-14 events:

.. code-block:: php

   namespace YourVendor\YourExt\EventListener;

   use Hamstahstudio\TuningToolShop\Event\OrderCreatedEvent;

   class OrderListener
   {
       public function __invoke(OrderCreatedEvent $event): void
       {
           $order = $event->getOrder();
           // Custom processing
       }
   }

Register listener in Services.yaml:

.. code-block:: yaml

   services:
     YourVendor\YourExt\EventListener\OrderListener:
       tags:
         - name: event.listener
           event: Hamstahstudio\TuningToolShop\Event\OrderCreatedEvent

Signal Slots (Legacy)
=====================

Using TYPO3 Signal/Slot pattern:

.. code-block:: php

   $signalSlotDispatcher = GeneralUtility::makeInstance(Dispatcher::class);
   $signalSlotDispatcher->connect(
       Order::class,
       'created',
       YourClass::class,
       'processOrder'
   );

Custom Models & Extensions
===========================

Extending Models
----------------

Add fields to models via TCA:

.. code-block:: php

   $GLOBALS['TCA']['tx_tuningtoolshop_domain_model_product']['columns']
       ['custom_field'] = [
           'label' => 'Custom Field',
           'config' => [
               'type' => 'input',
           ],
       ];

Using Extended Model
~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   class Product extends \Hamstahstudio\TuningToolShop\Domain\Model\Product
   {
       protected string $customField = '';

       public function getCustomField(): string
       {
           return $this->customField;
       }

       public function setCustomField(string $value): void
       {
           $this->customField = $value;
       }
   }

Custom Payment Handler
======================

Create Payment Handler
----------------------

Extend PaymentHandler:

.. code-block:: php

   namespace YourVendor\YourExt\Payment;

   use Hamstahstudio\TuningToolShop\Payment\PaymentHandlerInterface;

   class CustomPaymentHandler implements PaymentHandlerInterface
   {
       public function handle(Order $order): PaymentResult
       {
           // Implement payment logic
           return new PaymentResult();
       }
   }

Register Handler
~~~~~~~~~~~~~~~~

In ext_localconf.php:

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tuning_tool_shop']
       ['paymentHandlers'][] = CustomPaymentHandler::class;

Customizing Repositories
========================

Extending Repository
---------------------

.. code-block:: php

   namespace YourVendor\YourExt\Domain\Repository;

   use Hamstahstudio\TuningToolShop\Domain\Repository\ProductRepository 
       as BaseProductRepository;

   class ProductRepository extends BaseProductRepository
   {
       public function findByCustomField($value)
       {
           // Custom query
       }
   }

Using Custom Repository
~~~~~~~~~~~~~~~~~~~~~~~

Register in Services.yaml:

.. code-block:: yaml

   services:
     YourVendor\YourExt\Domain\Repository\ProductRepository:
       public: true

View Helpers
============

Custom ViewHelpers
------------------

Create custom ViewHelper:

.. code-block:: php

   namespace YourVendor\YourExt\ViewHelpers;

   use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

   class FormatPriceViewHelper extends AbstractViewHelper
   {
       public function render(float $price): string
       {
           return '€ ' . number_format($price, 2);
       }
   }

Use in Templates:

.. code-block:: html

   {namespace yvt=YourVendor\YourExt\ViewHelpers}
   <yvt:formatPrice price="{product.price}" />

Middleware & Security
=====================

Custom Middleware
-----------------

Add security middleware:

.. code-block:: php

   namespace YourVendor\YourExt\Middleware;

   use Psr\Http\Message\RequestInterface;
   use Psr\Http\Message\ResponseInterface;

   class CustomMiddleware
   {
       public function process(
           RequestInterface $request,
           RequestHandlerInterface $handler
       ): ResponseInterface {
           // Custom logic
           return $handler->handle($request);
       }
   }

Configuration
=============

Extension Configuration
-----------------------

Define configuration options:

.. code-block:: php

   'customOption' => [
       'label' => 'Custom Option',
       'config' => ['type' => 'input'],
   ],

Access in Code
~~~~~~~~~~~~~~

.. code-block:: php

   $config = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['tuning_tool_shop'];
   $value = $config['customOption'];

Testing Hooks
=============

Unit Testing
------------

Test custom hooks:

.. code-block:: php

   final class OrderHookTest extends TestCase
   {
       public function testBeforeCreation(): void
       {
           $hook = new OrderHook();
           $order = new Order();
           $hook->beforeCreation($order);
           
           $this->assertTrue($order->isValid());
       }
   }

Debugging
=========

Enable Debug Mode
-----------------

In LocalConfiguration.php:

.. code-block:: php

   'BE' => [
       'debug' => true,
   ],

Log Hooks
~~~~~~~~~

.. code-block:: php

   $logger->debug('Hook called', ['order' => $order]);

Use Xdebug
~~~~~~~~~~

Set breakpoints in hooks to debug execution.

Best Practices
==============

- Always null-check injected dependencies
- Use type hints for all parameters
- Log significant operations
- Handle exceptions gracefully
- Document custom hooks
- Test custom code thoroughly
- Follow PSR-12 coding standards
