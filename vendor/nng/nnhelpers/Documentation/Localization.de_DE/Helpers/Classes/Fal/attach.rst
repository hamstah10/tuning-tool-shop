
.. include:: ../../../../Includes.txt

.. _Fal-attach:

==============================================
Fal::attach()
==============================================

\\nn\\t3::Fal()->attach(``$model, $field, $itemData = NULL``);
----------------------------------------------

Eine Datei zu einem FileReference-Object konvertieren und
an die Property oder ObjectStorage eines Models hängen.
Siehe auch: ``\nn\t3::Fal()->setInModel( $member, 'falslideshow', $imagesToSet );`` mit dem
Array von mehreren Bildern an eine ObjectStorage gehängt werden können.

.. code-block:: php

	\nn\t3::Fal()->attach( $model, $fieldName, $filePath );
	\nn\t3::Fal()->attach( $model, 'image', 'fileadmin/user_uploads/image.jpg' );
	\nn\t3::Fal()->attach( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg'] );
	\nn\t3::Fal()->attach( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg', 'title'=>'Titel...'] );

| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference|array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function attach ( $model, $field, $itemData = null )
   {
   	if (!$itemData) return;
   	$returnFirstFal = !is_array($itemData);
   	$falsCreated = [];
   	if ($returnFirstFal) {
   		$itemData = [$itemData];
   	}
   	foreach ($itemData as $item) {
   		$fal = $this->createForModel($model, $field, $item);
   		$propVal = \nn\t3::Obj()->prop($model, $field);
   		$isStorage = \nn\t3::Obj()->isStorage( $propVal );
   		if ($fal) {
   			$falsCreated[] = $fal;
   			if ($isStorage) {
   				$propVal->attach( $fal );
   			} else {
   				\nn\t3::Obj()->set( $model, $field, $fal );
   			}
   		}
   	}
   	return $returnFirstFal ? array_pop($falsCreated) : $falsCreated;;
   }
   

