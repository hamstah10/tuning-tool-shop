
.. include:: ../../../../Includes.txt

.. _Environment-getLocalConf:

==============================================
Environment::getLocalConf()
==============================================

\\nn\\t3::Environment()->getLocalConf(``$path = ''``);
----------------------------------------------

Get configuration from ``LocalConfiguration.php`` 

.. code-block:: php

	\nn\t3::Environment()->getLocalConf('FE.cookieName');

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getLocalConf ( $path = '' ) {
   	if (!$path) return $GLOBALS['TYPO3_CONF_VARS'];
   	return \nn\t3::Settings()->getFromPath( $path, $GLOBALS['TYPO3_CONF_VARS'] ) ?: '';
   }
   

