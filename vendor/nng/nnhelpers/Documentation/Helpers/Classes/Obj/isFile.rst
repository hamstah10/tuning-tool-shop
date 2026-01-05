
.. include:: ../../../../Includes.txt

.. _Obj-isFile:

==============================================
Obj::isFile()
==============================================

\\nn\\t3::Obj()->isFile(``$obj``);
----------------------------------------------

Checks whether the object is a ``\TYPO3\CMS\Core\Resource\File``.

.. code-block:: php

	\nn\t3::Obj()->isFile( $obj );

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isFile ( $obj )
   {
   	if (!is_object($obj)) return false;
   	if (is_a($obj, \TYPO3\CMS\Core\Resource\File::class)) return true;
   	return false;
   }
   

