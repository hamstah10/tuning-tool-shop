
.. include:: ../../../../Includes.txt

.. _Obj-isFalFile:

==============================================
Obj::isFalFile()
==============================================

\\nn\\t3::Obj()->isFalFile(``$obj``);
----------------------------------------------

Checks whether the object is a ``\TYPO3\CMS\Core\Resource\FileReference``.

.. code-block:: php

	\nn\t3::Obj()->isFalFile( $obj );

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isFalFile ( $obj )
   {
   	if (!is_object($obj)) return false;
   	if (is_a($obj, \TYPO3\CMS\Core\Resource\FileReference::class)) return true;
   	return false;
   }
   

