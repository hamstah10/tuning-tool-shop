
.. include:: ../../../../Includes.txt

.. _Obj-getMethodArguments:

==============================================
Obj::getMethodArguments()
==============================================

\\nn\\t3::Obj()->getMethodArguments(``$className = NULL, $methodName = NULL``);
----------------------------------------------

Infos zu den Argumenten einer Methode holen.
| ``Berücksichtigt auch das per``@param``angegebene Typehinting, z.B. zu``ObjectStorage<ModelName>``.``

.. code-block:: php

	\nn\t3::Obj()->getMethodArguments( \My\Model\Name::class, 'myMethodName' );
	\nn\t3::Obj()->getMethodArguments( $myClassInstance, 'myMethodName' );

Gibt als Beispiel zurück:

.. code-block:: php

	'varName' => [
	    'type' => 'Storage<Model>',
	    'storageType' => 'Storage',
	    'elementType' => 'Model',
	 'optional' => true,
	 'defaultValue' => '123'
	]

return array

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getMethodArguments( $className = null, $methodName = null )
   {
   	$result = [];
   	$method = $this->getClassSchema( $className )->getMethod( $methodName );
   	$parameters = $method->getParameters();
   	if (!$parameters) return [];
   	foreach ($parameters as $param) {
   		$paramType = $param->getType();
   		$typeInfo = $this->parseType( $paramType );
   		$result[$param->getName()] = [
   			'type' 			=> $paramType,
   			'simple' 		=> $typeInfo['simple'],
   			'storageType' 	=> $typeInfo['type'],
   			'elementType' 	=> $typeInfo['elementType'],
   			'optional' 		=> $param->isOptional(),
   			'defaultValue'	=> $param->getDefaultValue()
   		];
   	}
   	return $result;
   }
   

