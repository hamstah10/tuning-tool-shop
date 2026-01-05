
.. include:: ../../../../Includes.txt

.. _Obj-set:

==============================================
Obj::set()
==============================================

\\nn\\t3::Obj()->set(``$obj, $key = '', $val = '', $useSetter = true``);
----------------------------------------------

Setzt einen Wert in einem Object oder Array.

.. code-block:: php

	\nn\t3::Obj()->set( $obj, 'title', $val );

| ``@param mixed $obj``             Model oder Array
| ``@param string $key``            der Key / Property
| ``@param mixed $val``             der Wert, der gesetzt werden soll
| ``@param boolean $useSetter``     setKey()-Methode zum Setzen verwenden

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
   

