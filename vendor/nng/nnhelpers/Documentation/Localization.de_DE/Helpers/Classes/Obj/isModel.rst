
.. include:: ../../../../Includes.txt

.. _Obj-isModel:

==============================================
Obj::isModel()
==============================================

\\nn\\t3::Obj()->isModel(``$obj``);
----------------------------------------------

Prüft, ob es sich bei dem Object um ein Domain-Model handelt.

.. code-block:: php

	\nn\t3::Obj()->isModel( $obj );

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isModel ( $obj )
   {
   	if (!is_object($obj) || is_string($obj)) return false;
   	return is_a($obj, \TYPO3\CMS\Extbase\DomainObject\AbstractEntity::class);
   }
   

