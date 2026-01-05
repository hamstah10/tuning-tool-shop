
.. include:: ../../../../Includes.txt

.. _Fal-createForModel:

==============================================
Fal::createForModel()
==============================================

\\nn\\t3::Fal()->createForModel(``$model, $field, $itemData = NULL``);
----------------------------------------------

Eine Datei zu einem FileReference-Object konvertieren und für ``attach()`` an ein vorhandenes
Model und Feld / Property vorbereiten. Die FileReference wird dabei nicht automatisch
an das Model gehängt. Um das FAL direkt in dem Model zu setzen, kann der Helper
| ``\nn\t3::Fal()->attach( $model, $field, $itemData )`` verwendet werden.

.. code-block:: php

	\nn\t3::Fal()->createForModel( $model, $fieldName, $filePath );
	\nn\t3::Fal()->createForModel( $model, 'image', 'fileadmin/user_uploads/image.jpg' );
	\nn\t3::Fal()->createForModel( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg'] );
	\nn\t3::Fal()->createForModel( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg', 'title'=>'Titel...'] );

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
   

