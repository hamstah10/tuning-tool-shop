
.. include:: ../../../../Includes.txt

.. _Environment-isHttps:

==============================================
Environment::isHttps()
==============================================

\\nn\\t3::Environment()->isHttps();
----------------------------------------------

Gibt ``true`` zurück, wenn die Seite über HTTPS aufgerufen wird.

.. code-block:: php

	$isHttps = \nn\t3::Environment()->isHttps();

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isHttps() {
   	return (
   		(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
   		|| (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
   		|| (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
   		|| (isset($_SERVER['HTTP_VIA']) && strpos($_SERVER['HTTP_VIA'], 'HTTPS') !== false)
   	);
   }
   

