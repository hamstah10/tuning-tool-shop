.. include:: ../Includes.txt

.. _security:

============
Security
============

Protecting your API endpoints
---------

.. important::

   **The most important security measure** is controlling who can access your endpoints. 
   Always use the :ref:`@Api\\Access() <access>` annotation to restrict access to your endpoints.
   
   Think twice before making an endpoint ``public`` and double-check that no sensitive data 
   is becoming publicly visible. An unprotected endpoint can expose user data, internal 
   information, or allow unauthorized modifications to your database.

The nnrestapi extension provides several security features to protect your API from 
common attacks and abuse. These can be applied:

* **Globally** via TypoScript for all endpoints
* **Per endpoint** via annotations

---------
Global security checks
---------

You can define security checks that are executed **before every API request** by configuring 
them in TypoScript. This is useful for applying consistent security policies across your entire API.

.. code-block:: typoscript

   plugin.tx_nnrestapi.settings.security {
      defaults {
         10 = \Nng\Nnrestapi\Utilities\Security->checkInjections
         20 = \Nng\Nnrestapi\Utilities\Security->checkLocked
      }
   }

The checks are executed in order of their numeric keys. If any check returns ``FALSE``, 
the API will respond with a ``403 Forbidden`` status code.

Built-in security checks
~~~~~~~~~~~~

checkInjections
""""""""""""""""

Scans the request body and GET parameters for typical SQL injection patterns. If a 
potential injection is detected, the IP is automatically blacklisted for 24 hours.

.. code-block:: typoscript

   10 = \Nng\Nnrestapi\Utilities\Security->checkInjections

Detected patterns include:

* SQL comments and escape sequences
* UNION SELECT statements
* INSERT, UPDATE, DELETE statements
* Sleep injection attacks
* Boolean-based injection patterns

checkLocked
""""""""""""""""

Checks if the current IP or frontend user has been blacklisted. Locked IPs/users 
are denied access to all endpoints.

.. code-block:: typoscript

   20 = \Nng\Nnrestapi\Utilities\Security->checkLocked

Custom security checks
~~~~~~~~~~~~

You can create your own security checks by defining a class with a method that returns 
``TRUE`` (allow) or ``FALSE`` (deny):

.. code-block:: php

   <?php
   namespace My\Extension\Utilities;

   class Security
   {
      /**
       * Check for honeypot fields in the request.
       * 
       * @param \Nng\Nnrestapi\Mvc\Request $request
       * @return bool
       */
      public function checkHoneypots($request)
      {
         $body = $request->getBody();
         
         // If honeypot field is filled, it's a bot
         if (!empty($body['hp_field'])) {
            // Optionally lock the IP
            \nn\rest::Security($request)->lockIp(86400);
            return false;
         }
         
         return true;
      }
   }

Register it in TypoScript:

.. code-block:: typoscript

   plugin.tx_nnrestapi.settings.security {
      defaults {
         5 = \My\Extension\Utilities\Security->checkHoneypots
         10 = \Nng\Nnrestapi\Utilities\Security->checkInjections
         20 = \Nng\Nnrestapi\Utilities\Security->checkLocked
      }
   }

---------
Per-endpoint security annotations
---------

For more granular control, you can apply security checks to individual endpoints using annotations.

@Api\\Security\\CheckInjections
~~~~~~~~~~~~

Check for SQL injection patterns on a specific endpoint:

.. code-block:: php

   /**
    * @Api\Security\CheckInjections()
    */
   public function postSearchAction($data)
   {
      // Request body is checked for injection patterns
   }

To disable auto-locking when an injection is detected:

.. code-block:: php

   /**
    * @Api\Security\CheckInjections(false)
    */
   public function postSearchAction($data)
   {
      // Injection check without auto-locking
   }

See :ref:`@Api\\Security\\CheckInjections <annotations_security_checkinjection>` for details.

@Api\\Security\\CheckLocked
~~~~~~~~~~~~

Check if the current IP or user is blacklisted:

.. code-block:: php

   /**
    * @Api\Security\CheckLocked()
    */
   public function postLoginAction($credentials)
   {
      // Locked IPs/users are denied access
   }

See :ref:`@Api\\Security\\CheckLocked <annotations_security_checklocked>` for details.

@Api\\Security\\MaxRequestsPerMinute
~~~~~~~~~~~~

Limit the number of requests from a single IP to prevent brute-force attacks and abuse:

.. code-block:: php

   /**
    * Limit to 60 requests per minute (default)
    * @Api\Security\MaxRequestsPerMinute()
    */
   public function getDataAction()
   {
   }

   /**
    * Limit to 5 requests per minute
    * @Api\Security\MaxRequestsPerMinute(5)
    */
   public function postLoginAction($credentials)
   {
   }

   /**
    * Limit to 10 requests per minute for this specific endpoint ID
    * @Api\Security\MaxRequestsPerMinute(10, "login")
    */
   public function postLoginAction($credentials)
   {
   }

See :ref:`@Api\\Security\\MaxRequestsPerMinute <annotations_security_maxrequests>` for details.

---------
IP and user locking
---------

The extension provides methods to manually lock and unlock IPs or frontend users.

Locking an IP
~~~~~~~~~~~~

.. code-block:: php

   // Lock current IP for 24 hours (default)
   \nn\rest::Security()->lockIp();

   // Lock current IP for 1 hour
   \nn\rest::Security()->lockIp(3600);

   // Lock with additional data for logging
   \nn\rest::Security()->lockIp(86400, 'Suspicious activity detected');

Unlocking an IP
~~~~~~~~~~~~

.. code-block:: php

   \nn\rest::Security()->unlockIp();

Locking a frontend user
~~~~~~~~~~~~

.. code-block:: php

   // Lock current frontend user for 24 hours
   \nn\rest::Security()->lockFeUser();

   // Lock specific user for 1 hour
   \nn\rest::Security()->lockFeUser(123, 3600);

Unlocking a frontend user
~~~~~~~~~~~~

.. code-block:: php

   // Unlock current frontend user
   \nn\rest::Security()->unlockFeUser();

   // Unlock specific user
   \nn\rest::Security()->unlockFeUser(123);

---------
Privacy considerations
---------

.. important::

   The security system **never stores legible IP addresses** in the database. All IPs are 
   hashed before storage, making it impossible to reconstruct the original IP from the 
   database records.

This ensures compliance with privacy regulations like GDPR while still allowing 
effective rate limiting and IP-based blocking.

---------
Database table
---------

Security data is stored in the ``nnrestapi_security`` table. Expired entries are 
automatically cleaned up when new security checks are performed.

The table stores:

* ``iphash`` - Hashed IP address
* ``feuser`` - Frontend user UID (if logged in)
* ``identifier`` - Type of entry (e.g., "lock", "all", custom IDs)
* ``expires`` - Timestamp when the entry expires
* ``data`` - Additional data (e.g., the suspicious request content)

