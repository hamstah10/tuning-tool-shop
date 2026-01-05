
.. include:: ../../../../Includes.txt

.. _Obj-isFile:

==============================================
Obj::isFile()
==============================================

\\nn\\t3::Obj()->isFile(``$obj``);
----------------------------------------------

Prüft, ob es sich bei dem Object um ein ``\TYPO3\CMS\Core\Resource\File`` handelt.

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
   

