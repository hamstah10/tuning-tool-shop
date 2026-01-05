
.. include:: ../../../../Includes.txt

.. _Fal-detach:

==============================================
Fal::detach()
==============================================

\\nn\\t3::Fal()->detach(``$model, $field, $obj = NULL``);
----------------------------------------------

Empties an ObjectStorage in a model or removes a single
individual object from the model or an ObjectStorage.
In the example, ``image`` can be an ObjectStorage or a single ``FileReference``:

.. code-block:: php

	\nn\t3::Fal()->detach( $model, 'image' );
	\nn\t3::Fal()->detach( $model, 'image', $singleObjToRemove );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function detach ( $model, $field, $obj = null )
   {
   	$propVal = \nn\t3::Obj()->prop($model, $field);
   	$isStorage = \nn\t3::Obj()->isStorage( $propVal );
   	if ($isStorage) {
   		foreach ($propVal->toArray() as $item) {
   			if (!$obj || $obj->getUid() == $item->getUid()) {
   				$propVal->detach( $item );
   			}
   		}
   	} else if ($propVal) {
   		$this->deleteSysFileReference( $propVal );
   		\nn\t3::Obj()->set( $model, $field, null, false );
   	}
   }
   

