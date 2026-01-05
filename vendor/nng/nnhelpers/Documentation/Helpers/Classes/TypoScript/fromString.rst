
.. include:: ../../../../Includes.txt

.. _TypoScript-fromString:

==============================================
TypoScript::fromString()
==============================================

\\nn\\t3::TypoScript()->fromString(``$str = '', $overrideSetup = []``);
----------------------------------------------

Converts a text into a TypoScript array.

.. code-block:: php

	$example = '
	    lib.test {
	      someVal = 10
	    }
	';
	\nn\t3::TypoScript()->fromString($example); => ['lib'=>['test'=>['someVal'=>10]]]
	\nn\t3::TypoScript()->fromString($example, $mergeSetup); => ['lib'=>['test'=>['someVal'=>10]]]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function fromString ( $str = '', $overrideSetup = [] ) {
   	if (!trim($str)) return $overrideSetup;
   	$typoScriptStringFactory = GeneralUtility::makeInstance( TypoScriptStringFactory::class );
   	$rootNode = $typoScriptStringFactory->parseFromStringWithIncludes('nnhelpers-fromstring', $str);
   	$setup = $rootNode->toArray();
   	if ($overrideSetup) {
   		$setup = array_replace_recursive($overrideSetup, $setup);
   	}
   	return $this->convertToPlainArray($setup);
   }
   

