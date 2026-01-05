
.. include:: ../../../../Includes.txt

.. _Request-getUri:

==============================================
Request::getUri()
==============================================

\\nn\\t3::Request()->getUri(``$varName = NULL``);
----------------------------------------------

Request-URI zurückgeben. Im Prinzip die URL / der GET-String
in der Browser URL-Leiste, der in ``$_SERVER['REQUEST_URI']``
gespeichert wird.

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
   

