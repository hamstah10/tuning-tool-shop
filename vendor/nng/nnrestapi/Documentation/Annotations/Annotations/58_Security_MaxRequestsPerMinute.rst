.. include:: ../../Includes.txt

.. _annotations_security_maxrequests:

==================
@Api\\Security\\MaxRequestsPerMinute
==================

Limiting number of requests to an endpoint
---------

This annotation allows you limit the number of request to an endpoint per minute from the current IP-address.

**The basic syntax is:**

.. code-block:: php

   @Api\Security\MaxRequestsPerMinute( $limit, $identifier )

An example would be:

.. code-block:: php

   // Limit access to all endpoints with "my_id" to 10 per IP and minute
   @Api\Security\MaxRequestsPerMinute( 10, "my_id" )

   // Limit overall access to all endpoints using this annotation to 10 per IP and minute
   @Api\Security\MaxRequestsPerMinute( 10 )

Exceeding the given number will result in an ``403`` Error response.

The optional argument ``my_id`` can be any arbitrary key.

- When using the same key in multiple endpoints, all endpoint calls with the same key will be counted
- Without an id, all endpoints using the annotation will be counted


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
       * @Api\Security\MaxRequestsPerMinute(5, "getSettings")
       * @Api\Access("public")
       *
       * @return array
       */
      public function getSettingsAction() 
      {
         return ['nice'=>'result'];
      }

   }


.. hint::

   The ``\nn\rest::Security()``-Helper has many useful methods in case you would like
   to handle checking for limits and locking users manually.

   Have a look at ``\Nng\Nnrestapi\Utilities\Security`` for more details.

   .. code-block:: php

      // returns FALSE if IP has exceeded number of requests for `my_key`
      $isBelowLimit = \nn\rest::Security( $this->request )->maxRequestsPerMinute(['my_key'=>60]);

      // manually lock an IP for 5 minutes
      \nn\rest::Security( $this->request )->lockIp( 300, 'Reason why...' );

      // unlock the IP
      \nn\rest::Security( $this->request )->unlockIp();


.. _annotations_security_maxrequests_reverseproxy:

Reverse Proxy Configuration
---------

If your TYPO3 installation is behind a reverse proxy (e.g., nginx, load balancer, CDN), 
the client's real IP address is typically forwarded in headers like ``X-Forwarded-For`` 
instead of being available in ``REMOTE_ADDR``.

Without proper configuration, **all requests would appear to come from the same IP** 
(the proxy's IP), causing rate limiting to affect all users collectively.

The nnrestapi uses TYPO3's ``NormalizedParams`` to determine the client IP, which 
respects TYPO3's reverse proxy configuration. To enable this, configure the following 
settings in your ``config/system/settings.php`` (in composer-based installations) and 
``typo3conf/LocalConfiguration.php`` in non-composer-based installations:

.. code-block:: php

   // IP address(es) of your reverse proxy
   $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyIP'] = '10.0.0.1';

   // For multiple proxies, use comma-separated list
   $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyIP'] = '10.0.0.1,10.0.0.2';

   // Which IP to use from X-Forwarded-For header: 'first' or 'last'
   // 'first' = original client (recommended for most setups)
   // 'last' = last proxy before TYPO3
   $GLOBALS['TYPO3_CONF_VARS']['SYS']['reverseProxyHeaderMultiValue'] = 'first';

.. tip::

   You can verify the detected IP by checking ``$this->request->getRemoteAddr()`` 
   in your endpoint or enabling debug logging.

