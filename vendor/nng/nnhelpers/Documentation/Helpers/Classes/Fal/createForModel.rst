
.. include:: ../../../../Includes.txt

.. _Fal-createForModel:

==============================================
Fal::createForModel()
==============================================

\\nn\\t3::Fal()->createForModel(``$model, $field, $itemData = NULL``);
----------------------------------------------

Convert a file to a FileReference object and prepare it for ``attach()`` to an existing
model and field / property. The FileReference is not automatically
attached to the model. To set the FAL directly in the model, the helper
| ``\nn\t3::Fal()->attach( $model, $field, $itemData )`` can be used.

.. code-block:: php

	\nn\t3::Fal()->createForModel( $model, $fieldName, $filePath );
	\nn\t3::Fal()->createForModel( $model, 'image', 'fileadmin/user_uploads/image.jpg' );
	\nn\t3::Fal()->createForModel( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg'] );
	\nn\t3::Fal()->createForModel( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg', 'title'=>'Title...'] );

| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function createForModel( $model, $field, $itemData = null )
   {
   	$objHelper = \nn\t3::Obj();
   	if (is_string($itemData)) {
   		$itemData = ['publicUrl'=>$itemData];
   	}
   	if ($objHelper->isFile($itemData)) {
   		return $this->fromFalFile($itemData);
   	}
   	$filePath = $itemData['publicUrl'];
   	if (!$filePath || !\nn\t3::File()->exists($filePath)) {
   		\nn\t3::Exception('\nn\t3::Fal()->attach() :: File not found.');
   	}
   	$propVal = $objHelper->prop($model, $field);
   	$isStorage = $objHelper->isStorage( $propVal );
   	$table = $objHelper->getTableName( $model );
   	$cruser_id = \nn\t3::FrontendUser()->getCurrentUserUid();
   	$sorting = $isStorage ? count($propVal) : 0;
   	$fal = $this->fromFile([
   		'src'			=> $filePath,
   		'title'			=> $itemData['title'] ?? null,
   		'description'	=> $itemData['description'] ?? null,
   		'link'			=> $itemData['link'] ?? '',
   		'crop'			=> $itemData['crop'] ?? '',
   		'sorting'		=> $itemData['sorting'] ?? $sorting,
   		'pid'			=> $model->getPid(),
   		'uid'			=> $model->getUid(),
   		'table'			=> $table,
   		'field'			=> $field,
   		'cruser_id'		=> $cruser_id,
   	]);
   	return $fal;
   }
   

