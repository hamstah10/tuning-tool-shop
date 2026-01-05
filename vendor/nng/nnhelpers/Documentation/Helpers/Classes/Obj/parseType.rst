
.. include:: ../../../../Includes.txt

.. _Obj-parseType:

==============================================
Obj::parseType()
==============================================

\\nn\\t3::Obj()->parseType(``$paramType = ''``);
----------------------------------------------

Parse a string with information about ``ObjectStorage``.

.. code-block:: php

	\nn\t3::Obj()->parseType( 'string' );
	\nn\t3::Obj()->parseType( 'Nng\Nnrestapi\Domain\Model\ApiTest' );
	\nn\t3::Obj()->parseType( '\TYPO3\CMS\Extbase\Persistence\ObjectStorage' );

Git an array with information back:
| ``type`` is only set if it is an array or an ObjectStorage.
| ``elementType`` is always the type of the model or the TypeHinting of the variable

.. code-block:: php

	[
	    'elementType' => 'Nng\Nnrestapi\Domain\Model\ApiTest',
	    'type' => 'TYPO3\CMS\Extbase\Persistence\ObjectStorage',
	    'simple' => FALSE
	]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function parseType( $paramType = '' )
   {
   	if (!$paramType || !trim($paramType)) {
   		return ['elementType'=>'', 'type'=>'', 'simple'=>true ];
   	}
   	if (class_exists(TypeHandlingUtility::class)) {
   		$typeInfo = \TYPO3\CMS\Extbase\Utility\TypeHandlingUtility::parseType( $paramType );
   	} else {
   		preg_match( '/([^<]*)<?([^>]*)?>?/', $paramType, $type );
   		$typeInfo = [
   			'elementType' => ltrim($type[2], '\\'),
   			'type' => ltrim($type[1], '\\')
   		];
   	}
   	if (!$typeInfo['elementType']) {
   		$typeInfo['elementType'] = $typeInfo['type'];
   		$typeInfo['type'] = '';
   	}
   	$typeInfo['simple'] = $this->isSimpleType($typeInfo['elementType']);
   	return $typeInfo;
   }
   

