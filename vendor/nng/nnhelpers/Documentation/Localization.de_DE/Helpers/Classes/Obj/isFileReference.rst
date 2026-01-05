
.. include:: ../../../../Includes.txt

.. _Obj-isFileReference:

==============================================
Obj::isFileReference()
==============================================

\\nn\\t3::Obj()->isFileReference(``$obj``);
----------------------------------------------

Prüft, ob es sich bei dem Object um eine ``\TYPO3\CMS\Extbase\Domain\Model\FileReference`` handelt.

.. code-block:: php

	\nn\t3::Obj()->isFileReference( $obj );

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isFileReference ( $obj )
   {
   	if (!is_object($obj)) return false;
   	if (is_a($obj, \TYPO3\CMS\Extbase\Domain\Model\FileReference::class)) return true;
   	$tableName = \nn\t3::Obj()->getTableName($obj);
   	return $tableName == 'sys_file_reference';
   }
   

