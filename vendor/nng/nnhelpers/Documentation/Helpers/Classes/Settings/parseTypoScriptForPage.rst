
.. include:: ../../../../Includes.txt

.. _Settings-parseTypoScriptForPage:

==============================================
Settings::parseTypoScriptForPage()
==============================================

\\nn\\t3::Settings()->parseTypoScriptForPage(``$pageUid = 0, $request = NULL``);
----------------------------------------------

Parse TypoScript for specific pageUid.

Returns the notation with dots. This can be done via
| ``\nn\t3::TypoScript()->convertToPlainArray()`` into a normal`` array``
be converted into a normal array.

.. code-block:: php

	// Get TypoScript for current pageUid
	\nn\t3::Settings()->parseTypoScriptForPage();
	
	// Get TypoScript for specific pageUid
	\nn\t3::Settings()->parseTypoScriptForPage(123);

| ``@param int $pid`` PageUid
| ``@param ServerRequestInterface $request``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function parseTypoScriptForPage($pageUid = 0, $request = null): array
   {
   	if (!$pageUid) {
   		$pageUid = \nn\t3::Page()->getPid();
   	}
   	$helper = \nn\t3::injectClass( \Nng\Nnhelpers\Helpers\TypoScriptHelper::class );
   	$result = $helper->getTypoScript( $pageUid );
   	return $result;
   }
   

