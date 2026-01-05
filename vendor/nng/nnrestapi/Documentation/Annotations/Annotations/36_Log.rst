.. include:: ../../Includes.txt

.. _annotations_log:

============
@Api\\Log
============

Enable or disable logging for an endpoint
---------

The ``@Api\Log()`` annotation can be used to explicitly enable or disable logging of requests 
to a specific endpoint. Logged requests are saved in the database table ``nnrestapi_log`` and 
can be viewed in the backend module.

For a complete overview of the logging system, see :ref:`Logging <logging>`.

This is useful when:

* You want to **disable logging** for endpoints that are called frequently (e.g., health checks, polling)
* You want to **force enable logging** for specific endpoints regardless of global settings
* You need to debug specific endpoints by enabling logging temporarily

**The syntax is:**

.. code-block:: php

   @Api\Log(true)    // Enable logging for this endpoint
   @Api\Log(false)   // Disable logging for this endpoint
   @Api\Log()        // Same as true


**Full example:**

.. code-block:: php

   <?php

   namespace My\Extension\Api;

   use Nng\Nnrestapi\Annotations as Api;
   use Nng\Nnrestapi\Api\AbstractApi;

   /**
    * @Api\Endpoint()
    */
   class Example extends AbstractApi
   {
      /**
       * This endpoint will NEVER be logged, unless `loggingMode` 
       * was set to "force" in the Extension Manager.
       * 
       * Useful for high-frequency endpoints like health checks.
       *
       * @Api\Log(false)
       * @Api\Access("public")
       * @return array
       */
      public function getHealthAction() 
      {
         return ['status' => 'ok'];
      }

      /**
       * This endpoint will be logged, if:
       * - custom logging is enabled in the Extension Manager
       * - AND the `loggingMode` was set to "explicit" or "force"
       *
       * @Api\Log(true)
       * @Api\Access("fe_users")
       * @return array
       */
      public function postSensitiveAction() 
      {
         return ['result' => 'logged'];
      }
   }


Logging behavior overview
---------

.. list-table::
   :header-rows: 1
   :widths: 30 70

   * - Annotation
     - Description
   * - ``@Api\Log(false)``
     - Disables logging, except if loggingMode is ``force``
   * - ``@Api\Log(true)``
     - Enables logging if "Enable custom logging" is enabled in the Extension Manager
   * - ``@Api\Log()``
     - Same as ``@Api\Log(true)``
   * - *(no annotation)*
     - Uses global logging settings from Extension Manager


Global logging settings
---------

The global logging behavior can be configured in the Extension Manager settings:

.. figure:: ../../Images/ext-manager-logging.jpg
   :alt: Extension Manager logging settings
   :class: with-shadow

   Logging configuration in the Extension Manager

* **Logging enabled**: Enable/disable logging globally
* **Logging mode**: Controls how the ``@Api\Log()`` annotation is interpreted:

  * ``all``: Log all requests, except those with ``@Api\Log(false)``
  * ``explicit``: Only log requests that have ``@Api\Log()`` or ``@Api\Log(true)``
  * ``force``: Log all requests, ignoring any ``@Api\Log()`` annotations

* **Error logging**: Log errors and exceptions
* **Auto-clear logs**: Automatically remove old log entries after X days

See the :ref:`Configuration <configuration>` section for more details on global settings.
