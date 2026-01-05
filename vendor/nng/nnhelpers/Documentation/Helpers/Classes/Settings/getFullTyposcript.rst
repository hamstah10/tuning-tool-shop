
.. include:: ../../../../Includes.txt

.. _Settings-getFullTyposcript:

==============================================
Settings::getFullTyposcript()
==============================================

\\nn\\t3::Settings()->getFullTyposcript(``$pid = NULL``);
----------------------------------------------

Get the complete TypoScript setup, as a simple array - without "." syntax
Works both in the frontend and backend, with and without passed pid

.. code-block:: php

	\nn\t3::Settings()->getFullTyposcript();
	\nn\t3::Settings()->getFullTyposcript( $pid );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getFullTyposcript( $pid = null )
   {
   	if ($this->typoscriptSetupCache) return $this->typoscriptSetupCache;
   	$setup = false;
   	try {
   		$setup = $this->parseTypoScriptForPage($pid);
   		if (!$setup) {
   			$setup = $this->getFullTypoScriptFromConfigurationManager();
   		}
   	} catch ( \Exception $e ) {
   		// this might be related to https://forge.typo3.org/projects/typo3cms-core/issues
   		$setup = false;
   	}
   	if (!$setup) {
   		\nn\t3::Exception('TypoScript-Setup could not be loaded. If you are trying to access it from a Middleware or the CLI, try using $request->getAttribute(\'frontend.controller\')->config[\'INTincScript\'][] = []; in your Middleware to disable caching.');
   	}
   	$this->typoscriptSetupCache = \nn\t3::TypoScript()->convertToPlainArray($setup);
   	return $this->typoscriptSetupCache;
   }
   

