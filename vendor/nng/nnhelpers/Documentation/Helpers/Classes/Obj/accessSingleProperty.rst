
.. include:: ../../../../Includes.txt

.. _Obj-accessSingleProperty:

==============================================
Obj::accessSingleProperty()
==============================================

\\nn\\t3::Obj()->accessSingleProperty(``$obj, $key``);
----------------------------------------------

Access to a key in an object or array
key must be a single string, not a path

\nn\t3::Obj()->accessSingleProperty( $obj, 'uid' );
\nn\t3::Obj()->accessSingleProperty( $obj, 'fal_media' );
\nn\t3::Obj()->accessSingleProperty( $obj, 'falMedia' );

| ``@param mixed $obj`` Model or array
| ``@param string $key`` the key that is to be fetched

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function accessSingleProperty ( $obj, $key )
   {
   	if ($key == '') return '';
   	if (is_object($obj)) {
   		if (is_numeric($key)) {
   			$obj = $this->forceArray($obj);
   			return $obj[intval($key)];
   		}
   		$gettable = ObjectAccess::isPropertyGettable($obj, $key);
   		if ($gettable) return ObjectAccess::getProperty($obj, $key);
   		$camelCaseKey = GeneralUtility::underscoredToLowerCamelCase( $key );
   		$gettable = ObjectAccess::isPropertyGettable($obj, $camelCaseKey);
   		if ($gettable) return ObjectAccess::getProperty($obj, $camelCaseKey);
   			if ($key == 'elementType' && $obj instanceof Property) {
   				$valueTypes = $obj->getPrimaryType()->getCollectionValueTypes();
   				if (!empty($valueTypes)) {
   					return $valueTypes[0]->getClassName();
   				}
   			}
   			if ($obj instanceof Property) {
   				return $obj->getPrimaryType()->getClassName() ?? $obj->getPrimaryType()->getBuiltinType() ?? null;
   			}
   		return $obj->$key ?? null;
   	} else {
   		if (is_array($obj)) return $obj[$key] ?? null;
   	}
   	return [];
   }
   

