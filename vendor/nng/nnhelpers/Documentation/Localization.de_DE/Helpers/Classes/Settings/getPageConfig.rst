
.. include:: ../../../../Includes.txt

.. _Settings-getPageConfig:

==============================================
Settings::getPageConfig()
==============================================

\\nn\\t3::Settings()->getPageConfig(``$tsPath = '', $pid = NULL``);
----------------------------------------------

Page-Configuration holen

.. code-block:: php

	\nn\t3::Settings()->getPageConfig();
	\nn\t3::Settings()->getPageConfig('RTE.default.preset');
	\nn\t3::Settings()->getPageConfig( $tsPath, $pid );

Existiert auch als ViewHelper:

.. code-block:: php

	{nnt3:ts.page(path:'pfad.zur.pageconfig')}

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getPageConfig( $tsPath = '', $pid = null )
   {
   	$pid = $pid ?: \nn\t3::Page()->getPid();
   	$config = \TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig( $pid );
   	$config = \nn\t3::TypoScript()->convertToPlainArray( $config );
   	return $tsPath ? $this->getFromPath( $tsPath, $config ) : $config;
   }
   

