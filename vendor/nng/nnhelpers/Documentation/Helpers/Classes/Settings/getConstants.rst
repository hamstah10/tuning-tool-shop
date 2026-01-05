
.. include:: ../../../../Includes.txt

.. _Settings-getConstants:

==============================================
Settings::getConstants()
==============================================

\\nn\\t3::Settings()->getConstants(``$tsPath = ''``);
----------------------------------------------

Get array of TypoScript constants.

.. code-block:: php

	\nn\t3::Settings()->getConstants();
	\nn\t3::Settings()->getConstants('path.to.constant');

Also exists as ViewHelper:

.. code-block:: php

	{nnt3:ts.constants(path:'path.to.constant')}

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getConstants ( $tsPath = '' )
   {
   	$constants = [];
   	if ($request = $GLOBALS['TYPO3_REQUEST'] ?? false) {
   		if ($ts = $request->getAttribute('frontend.typoscript')) {
   			try {
   				$constants = $ts->getSettingsTree()->toArray();
   			} catch ( \Exception $e ) {
   				// this might be related to https://forge.typo3.org/projects/typo3cms-core/issues
   				\nn\t3::Exception('TypoScript-Setup could not be loaded. If you are trying to access it from a Middleware or the CLI, try using $request->getAttribute(\'frontend.controller\')->config[\'INTincScript\'][] = []; in your Middleware to disable caching.');
   			}
   		}
   	}
   	$config = \nn\t3::TypoScript()->convertToPlainArray( $constants );
   	return $tsPath ? $this->getFromPath( $tsPath, $config ) : $config;
   }
   

