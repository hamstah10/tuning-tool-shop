
.. include:: ../../../../Includes.txt

.. _Obj-set:

==============================================
Obj::set()
==============================================

\\nn\\t3::Obj()->set(``$obj, $key = '', $val = '', $useSetter = true``);
----------------------------------------------

Sets a value in an object or array.

.. code-block:: php

	\nn\t3::Obj()->set( $obj, 'title', $val );

| ``@param mixed $obj`` Model or array
| ``@param string $key`` the key / property
| ``@param mixed $val`` the value to be set
| ``@param boolean $useSetter`` setKey() method to use for setting

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function set( $obj, $key = '', $val = '', $useSetter = true)
   {
   	$settable = ObjectAccess::isPropertySettable($obj, $key);
   	if (!$settable) {
   		$key = GeneralUtility::underscoredToLowerCamelCase( $key );
   		$settable = ObjectAccess::isPropertySettable($obj, $key);
   	}
   	if ($settable) {
   		if (is_object($obj)) {
   			$modelProperties = $this->getProps($obj);
   			if ($type = $modelProperties[$key] ?? false) {
   				// SysFileReference wird gebraucht, aber SysFile wurde übergeben?
   				if (is_a($type, FalFileReference::class, true )) {
   					if (!$val) {
   						$val = '';
   					} else if ($this->isFile( $val )) {
   						$val = \nn\t3::Fal()->fromFalFile( $val );
   					}
   				}
   				// ObjectStorage soll geleert werden?
   				if (is_a($type, ObjectStorage::class, true )) {
   					$val = new ObjectStorage();
   				}
   				switch ($type) {
   					case 'int':
   						$val = (int)$val;
   						break;
   					case 'float':
   						$val = (float)$val;
   						break;
   				}
   			}
   		}
   		if (in_array($key, ['deleted', 'hidden'])) $val = $val ? true : false;
   		ObjectAccess::setProperty($obj, $key, $val, !$useSetter);
   	}
   	return $obj;
   }
   

