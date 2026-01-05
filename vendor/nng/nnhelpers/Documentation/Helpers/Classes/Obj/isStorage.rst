
.. include:: ../../../../Includes.txt

.. _Obj-isStorage:

==============================================
Obj::isStorage()
==============================================

\\nn\\t3::Obj()->isStorage(``$obj``);
----------------------------------------------

Checks whether the object is a storage.

.. code-block:: php

	\nn\t3::Obj()->isStorage( $obj );

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isStorage ( $obj )
   {
   	if (!is_object($obj) || is_string($obj)) return false;
   	$type = get_class($obj);
   	return is_a($obj, ObjectStorage::class) || $type == LazyObjectStorage::class || $type == ObjectStorage::class || $type == \TYPO3\CMS\Extbase\Persistence\ObjectStorage::class;
   }
   

