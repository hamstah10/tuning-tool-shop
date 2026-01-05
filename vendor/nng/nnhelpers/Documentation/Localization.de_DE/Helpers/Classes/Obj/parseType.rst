
.. include:: ../../../../Includes.txt

.. _Obj-parseType:

==============================================
Obj::parseType()
==============================================

\\nn\\t3::Obj()->parseType(``$paramType = ''``);
----------------------------------------------

Einen String mit Infos zu ``ObjectStorage<Model>`` parsen.

.. code-block:: php

	\nn\t3::Obj()->parseType( 'string' );
	\nn\t3::Obj()->parseType( 'Nng\Nnrestapi\Domain\Model\ApiTest' );
	\nn\t3::Obj()->parseType( '\TYPO3\CMS\Extbase\Persistence\ObjectStorage<Nng\Nnrestapi\Domain\Model\ApiTest>' );

Git ein Array mit Infos zurück:
| ``type`` ist dabei nur gesetzt, falls es ein Array oder eine ObjectStorage ist.
| ``elementType`` ist immer der Typ des Models oder das TypeHinting der Variable

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
   

