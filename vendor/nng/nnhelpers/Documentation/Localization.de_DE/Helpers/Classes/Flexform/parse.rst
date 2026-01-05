
.. include:: ../../../../Includes.txt

.. _Flexform-parse:

==============================================
Flexform::parse()
==============================================

\\nn\\t3::Flexform()->parse(``$xml = ''``);
----------------------------------------------

Wandelt ein Flexform-XML in ein Array um

.. code-block:: php

	\nn\t3::Flexform()->parse('<?xml...>');

Existiert auch als ViewHelper:

.. code-block:: php

	{rawXmlString->nnt3:parse.flexForm()->f:debug()}

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function parse( $xml = '' )
   {
   	$flexFormService = \nn\t3::injectClass( \TYPO3\CMS\Core\Service\FlexFormService::class );
   	if (!$xml) return [];
   	if (is_array($xml)) {
   		$data = [];
   		foreach (($xml['data']['sDEF']['lDEF'] ?? []) as $k=>$node) {
   			$data[$k] = $node['vDEF'];
   		}
   		return $data;
   	}
   	return $flexFormService->convertFlexFormContentToArray( $xml ) ?: [];
   }
   

