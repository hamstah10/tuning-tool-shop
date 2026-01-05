
.. include:: ../../../../Includes.txt

.. _Tsfe-get:

==============================================
Tsfe::get()
==============================================

\\nn\\t3::Tsfe()->get(``$pid = NULL``);
----------------------------------------------

Get $GLOBALS['TSFE'].
If not available (because in BE) initialize.

.. code-block:: php

	\nn\t3::Tsfe()->get()
	\nn\t3::Tsfe()->get()

| ``@return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function get( $pid = null )
   {
   	if (!isset($GLOBALS['TSFE'])) $this->init( $pid );
   	return $GLOBALS['TSFE'] ?? '';
   }
   

