
.. include:: ../../../../Includes.txt

.. _Fal-setInModel:

==============================================
Fal::setInModel()
==============================================

\\nn\\t3::Fal()->setInModel(``$model, $fieldName = '', $imagesToAdd = []``);
----------------------------------------------

Replaces a ``FileReference`` or ``ObjectStorage`` in a model with images.
Typical use case: A FAL image is to be changed via an upload form in the frontend.
be able to be changed.

For each image, the system checks whether a ``FileReference`` already exists in the model.
Existing FileReferences are not overwritten, otherwise any
captions or cropping instructions would be lost!

Attention! The model is automatically persisted!

.. code-block:: php

	$newModel = new \My\Extension\Domain\Model\Example();
	\nn\t3::Fal()->setInModel( $newModel, 'falslideshow', 'path/to/file.jpg' );
	echo $newModel->getUid(); // Model has been persisted!

Example with a simple FileReference in the model:

.. code-block:: php

	$imageToSet = 'fileadmin/images/portrait.jpg';
	\nn\t3::Fal()->setInModel( $member, 'falprofileimage', $imageToSet );
	
	\nn\t3::Fal()->setInModel( $member, 'falprofileimage', ['publicUrl'=>'01.jpg', 'title'=>'Title', 'description'=>'...'] );

Example with a single SysFile:

.. code-block:: php

	$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
	$file = $resourceFactory->getFileObjectFromCombinedIdentifier('1:/foo.jpg');
	\nn\t3::Fal()->setInModel( $member, 'image', $file );

Example with a single SysFile that is to be stored in an ObjectStorage:

.. code-block:: php

	$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
	$file = $resourceFactory->getFileObjectFromCombinedIdentifier('1:/foo.jpg');
	\nn\t3::Fal()->setInModel( $member, 'images', [$file] );

Example with an ObjectStorage in the model:

.. code-block:: php

	$imagesToSet = ['fileadmin/images/01.jpg', 'fileadmin/images/02.jpg', ...];
	\nn\t3::Fal()->setInModel( $member, 'falslideshow', $imagesToSet );
	
	\nn\t3::Fal()->setInModel( $member, 'falslideshow', [['publicUrl'=>'01.jpg'], ['publicUrl'=>'02.jpg']] );
	\nn\t3::Fal()->setInModel( $member, 'falvideos', [['publicUrl'=>'https://youtube.com/?watch=zagd61231'], ...] );

Example with videos:

.. code-block:: php

	$videosToSet = ['https://www.youtube.com/watch?v=GwlU_wsT20Q', ...];
	\nn\t3::Fal()->setInModel( $member, 'videos', $videosToSet );

| ``@param mixed $model`` The model that is to be changed
| ``@param string $fieldName`` Property (field name) of the ObjectStorage or FileReference
| ``@param mixed $imagesToAdd`` String / array with images

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setInModel( $model, $fieldName = '', $imagesToAdd = [] )
   {
   	if (!$model) \nn\t3::Exception( 'Parameter $model is not a Model' );
   	$objHelper = \nn\t3::Obj();
   	$repository = \nn\t3::Db()->getRepositoryForModel( $model );
   	// Sicher gehen, dass das Model bereits persistiert wurde – ohne uid keine FileReference!
   	if (!$model->getUid()) {
   		if ($repository) {
   			$repository->add( $model );
   		}
   		\nn\t3::Db()->persistAll();
   	}
   	$modelUid = $model->getUid();
   	if (!$modelUid) return false;
   	// Der passende Tabellen-Name in der DB zum Model
   	$modelTableName = $objHelper->getTableName( $model );
   	// Aktuellen Wert auslesen und ermitteln, ob das Feld eine FileReference oder ObjectStorage ist
   	$props = $objHelper->getProps( $model );
   	$fieldValue = $objHelper->prop( $model, $fieldName );
   	$isObjectStorage = is_a( $props[$fieldName], ObjectStorage::class, true );
   	$isSysFileReference = is_a($props[$fieldName], SysFileReference::class, true );
   	if ($isObjectStorage && !$fieldValue) {
   		$objHelper->set( $model, $fieldName, new ObjectStorage() );
   	}
   	// Array der bereits bestehenden FileReferences erzeugen mit Pfad zu Bildern als Key
   	$existingFileReferencesByPublicUrl = [];
   	if ($fieldValue) {
   		if (!$isObjectStorage) {
   			$fieldValue = [$fieldValue];
   		}
   		foreach ($fieldValue as $sysFileRef) {
   			$publicUrl = $sysFileRef->getOriginalResource()->getPublicUrl();
   			$existingFileReferencesByPublicUrl[$publicUrl] = $sysFileRef;
   		}
   	}
   	// Normalisieren der Pfadangaben zu den Bildern.
   	// Aus 'pfad/zum/bild.jpg' wird ['publicUrl'=>'pfad/zum/bild.jpg']
   	if (is_string($imagesToAdd)) {
   		$imagesToAdd = ['publicUrl'=>$imagesToAdd];
   	}
   	// Grundsätzlich mit Arrays arbeiten, vereinfacht die Logik unten.
   	// Aus ['publicUrl'=>'pfad/zum/bild.jpg'] wird [['publicUrl'=>'pfad/zum/bild.jpg']]
   	if (is_array($imagesToAdd) && isset($imagesToAdd['publicUrl'])) {
   		$imagesToAdd = [$imagesToAdd];
   	}
   	// sysFiles und sysFileReferences erlauben
   	if ($objHelper->isFalFile($imagesToAdd) || $objHelper->isFile($imagesToAdd)) {
   		$imagesToAdd = [$imagesToAdd];
   	}
   	// Aus ['01.jpg', '02.jpg', ...] wird [['publicUrl'=>'01.jpg'], ['publicUrl'=>'02.jpg'], ...]
   	foreach ($imagesToAdd as $k=>$v) {
   		if (is_string($v)) {
   			$imagesToAdd[$k] = ['publicUrl'=>$v];
   		}
   	}
   	// Durch die Liste der neuen Bilder gehen ...
   	foreach ($imagesToAdd as $n=>$imgObj) {
   		// Bereits ein falFile oder eine sysFileReference
   		if ($objHelper->isFile($imgObj) || $objHelper->isFalFile($imgObj)) {
   			continue;
   		}
   		$imgToAdd = $imgObj['publicUrl'];
   		$publicUrl = \nn\t3::File()->stripPathSite( $imgToAdd );
   		// Falls bereits eine FileReference zu dem gleichen Bild existiert, diese verwenden
   		$value = $existingFileReferencesByPublicUrl[$publicUrl] ?? '' ?: $publicUrl;
   		// Falls das Bild noch nicht im Model existierte, eine neue FileReference erzeugen
   		if (is_string($value)) {
   			$falParams = [
   				'src'		   => $value,
   				'title'			=> $imgObj['title'] ?? '',
   				'description'	=> $imgObj['description'] ?? '',
   				'link'			=> $imgObj['link'] ?? '',
   				'crop'			=> $imgObj['crop'] ?? '',
   				'pid'		   => $model->getPid(),
   				'uid'		   => $model->getUid(),
   				'table'		 => $modelTableName,
   				'field'		 => $fieldName,
   			];
   			$value = $this->fromFile( $falParams );
   		}
   		// Sollte etwas schief gegangen sein, ist $value == FALSE
   		if ($value) {
   			$imagesToAdd[$n] = $value;
   		}
   	}
   	if ($isSysFileReference) {
   		// Feld ist eine SysFileReference (ohne ObjectStorage)
   		$objectToSet = $imagesToAdd[0] ?? false;
   	} else if ($isObjectStorage) {
   		// Feld ist eine ObjectStorage: Neue ObjectStorage zum Ersetzen der bisherigen erzeugen
   		$objectToSet = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage;
   		foreach ($imagesToAdd as $n=>$imgToAdd) {
   			if ($objHelper->isFile( $imgToAdd )) {
   				$imgToAdd = \nn\t3::Fal()->fromFalFile( $imgToAdd );
   			}
   			$objectToSet->attach( $imgToAdd );
   		}
   	} else {
   		// Feld ist keine ObjectStorage: Also einfach die erste FileReference verwenden.
   		$objectToSet = array_shift($imagesToAdd);
   		if (!$objectToSet && $existingFileReferencesByPublicUrl) {
   			// FileReference soll entfernt werden
   			foreach ($existingFileReferencesByPublicUrl as $sysFileRef) {
   				$this->deleteSysFileReference( $sysFileRef );
   			}
   		}
   	}
   	// Property im Model aktualisieren
   	if ($objectToSet) {
   		$objHelper->set( $model, $fieldName, $objectToSet );
   	}
   	// Model aktualisieren
   	if ($repository) {
   		$repository->update( $model );
   		\nn\t3::Db()->update( $model );
   	}
   	return $model;
   }
   

