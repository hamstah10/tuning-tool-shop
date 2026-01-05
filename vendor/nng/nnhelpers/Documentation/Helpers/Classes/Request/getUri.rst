
.. include:: ../../../../Includes.txt

.. _Request-getUri:

==============================================
Request::getUri()
==============================================

\\nn\\t3::Request()->getUri(``$varName = NULL``);
----------------------------------------------

Return the request URI. Basically the URL / the GET string
in the browser URL bar, which is stored in ``$_SERVER['REQUEST_URI']``
is saved.

.. code-block:: php

	\nn\t3::Request()->getUri();

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getUri ( $varName = null )
   {
   	return GeneralUtility::getIndpEnv('REQUEST_URI');
   }
   

