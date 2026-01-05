
.. include:: ../../../../Includes.txt

.. _Obj-getProps:

==============================================
Obj::getProps()
==============================================

\\nn\\t3::Obj()->getProps(``$obj, $key = 'type', $onlySettable = true``);
----------------------------------------------

Return the list of properties of an object or model with type.

.. code-block:: php

	\nn\t3::Obj()->getProps( $obj ); // ['uid'=>'integer', 'title'=>'string' ...]
	\nn\t3::Obj()->getProps( $obj, true ); // ['uid'=>[type=>'integer', 'private'=>TRUE]]
	\nn\t3::Obj()->getProps( $obj, 'default' ); // ['uid'=>TRUE]
	\nn\t3::Obj()->getProps( \Nng\MyExt\Domain\Model\Demo::class );

| ``@param mixed $obj`` Model or class name
| ``@param mixed $key`` If TRUE, array with all information is retrieved, e.g. also default value etc.
| ``@param boolean $onlySettable`` Only get properties that can also be set via setName()
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getProps ( $obj, $key = 'type', $onlySettable = true )
   {
   	if (is_string($obj) && class_exists($obj)) {
   		$obj = new $obj();
   	}
   	$schema = $this->getClassSchema( $obj );
   	$properties = $schema->getProperties();
   	if ($onlySettable) {
   		$settables = array_flip(ObjectAccess::getSettablePropertyNames($obj));
   		foreach ($properties as $k=>$p) {
   			if (isset($settables[$k]) && !$settables[$k]) unset( $properties[$k] );
   		}
   	}
   	$flatProps = [];
   	foreach ($properties as $name=>$property) {
   		$flatProps[$name] = $this->accessSingleProperty( $property, $key );
   	}
   	return $flatProps;
   }
   

