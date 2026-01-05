
.. include:: ../../../../Includes.txt

.. _Environment-getBaseURL:

==============================================
Environment::getBaseURL()
==============================================

\\nn\\t3::Environment()->getBaseURL();
----------------------------------------------

Gibt die baseUrl (``config.baseURL``) zurück, inkl. http(s) Protokoll z.B. https://www.webseite.de/

.. code-block:: php

	\nn\t3::Environment()->getBaseURL();

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getBaseURL ()
   {
   	$setup = \nn\t3::Settings()->getFullTyposcript();
   	if ($baseUrl = $setup['config']['baseURL'] ?? false) return $baseUrl;
   	$host = $_SERVER['HTTP_HOST'] ?? '';
   	$server = ($this->isHttps() ? 'https' : 'http') . "://{$host}/";
   	return $server;
   }
   

