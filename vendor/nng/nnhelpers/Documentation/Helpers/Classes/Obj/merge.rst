
.. include:: ../../../../Includes.txt

.. _Obj-merge:

==============================================
Obj::merge()
==============================================

\\nn\\t3::Obj()->merge(``$model = NULL, $overlay = NULL``);
----------------------------------------------

Merge an array into an object

.. code-block:: php

	\nn\t3::Obj( \My\Doman\Model )->merge(['title'=>'New title']);

This can even be used to write / overwrite FileReferences.
In this example, ``$data`` is merged with an existing model.
| ``falMedia`` is an ObjectStorage in the example. The first element in ``falMedia`` already exists
already exists in the database``(uid = 12``). Only the title is updated here.
The second element in the array (without ``uid``) is new. For this, a new
| ``sys_file_reference`` is automatically created in the database.

.. code-block:: php

	$data = [
	    'uid' => 10,
	    'title' => 'The title',
	    'falMedia' => [
	        ['uid'=>12, 'title'=>'1st image title'],
	        ['title'=>'NEW image title', 'publicUrl'=>'fileadmin/_tests/5e505e6b6143a.jpg'],
	    ]
	];
	$oldModel = $repository->findByUid( $data['uid'] );
	$mergedModel = \nn\t3::Obj($oldModel)->merge($data);

Hint
To create a new model with data from an array, there is the method
there is the method ``$newModel = \nn\t3::Convert($data)->toModel( \My\Model\Name::class );``

| ``@return object``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function merge( $model = null, $overlay = null )
   {
   	$overlay = $this->initialArgument !== null ? $model : $overlay;
   	$model = $this->initialArgument !== null ? $this->initialArgument : $model;
   	$schema = \nn\t3::Obj()->getClassSchema($model);
   	$modelProperties = $schema->getProperties();
   	if (!is_array($overlay)) return $model;
   	foreach ($overlay as $propName=>$value) {
   		if ($propInfo = $modelProperties[$propName] ?? false) {
   			// Typ für Property des Models, z.B. `string`
   			$propType = $this->get( $propInfo, 'type');
   			$isSysFile = is_a( $propType, \TYPO3\CMS\Core\Resource\File::class, true );
   			if ($this->isSimpleType($propType)) {
   				// -----
   				// Es ist ein "einfacher Typ" (`string`, `int` etc.). Kann direkt gesetzt werden!
   				$this->set( $model, $propName, $value );
   				continue;
   			}
   			if (!class_exists($propType)) {
   				\nn\t3::Exception( "Class of type `{$propType}` is not defined." );
   			}
   			$curPropValue = $this->get( $model, $propName );
   			if (!$isSysFile) {
   				// Es ist ein `Model`, `FileReference` etc.
   			$child = \nn\t3::newClass( $propType );
   			}
   			if ($isSysFile) {
   				$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
   				$uid = false;
   				// '1'
   				if (is_numeric($value)) {
   					$uid = $value;
   				}
   				// ['uid'=>1]
   				if (!$uid && is_array($value)) {
   					$uid = $value['uid'] ?? false;
   				}
   				// 'index.php?eID=dumpFile&t=f&f=255&token=...' or 'https://www.website.com/fileadmin/file.txt'
   				if (!$uid && is_string($value)) {
   					$queryParams = [];
   					$parsedUrl = parse_url($value);
   					parse_str($parsedUrl['query'], $queryParams);
   					if (($queryParams['eID'] ?? false) == 'dumpFile' && $uid = intval($queryParams['f'] ?? 0)) {
   						$value = $resourceFactory->getFileObject($uid);
   					} else if ($parsedUrl['host'] ?? false) {
   						$value = ltrim($parsedUrl['path'], '/');
   					}
   				}
   				if ($uid) {
   					$value = $resourceFactory->getFileObject(intval($uid));
   				} else {
   					try {
   						// '/var/www/path/to/file.txt' or '1:/path/to/file.txt' or '/fileadmin/path/to/file.txt'
   						$value = $resourceFactory->getFileObjectFromCombinedIdentifier($value);
   					} catch( \Exception $e ) {
   						$value = null;
   					}
   				}
   			} else if ($this->isFileReference($child)) {
   				// -----
   				// Die Property ist eine einzelne `SysFileReference` – keine `ObjectStorage`
   				$curPublicUrl = \nn\t3::File()->getPublicUrl( $curPropValue );
   				$publicUrl = \nn\t3::File()->getPublicUrl( $value );
   				if ($curPublicUrl == $publicUrl) {
   					// An der URL hat sich nichts geändert. Bisherige `SysFileReference` weiter verwenden.
   					$value = $curPropValue;
   				} else {
   					// Neue URL. Falls bereits ein FAL am Model: Entfernen
   					if ($this->isFileReference($curPropValue)) {
   						$persistenceManager = GeneralUtility::makeInstance( PersistenceManager::class );
   						$persistenceManager->remove( $curPropValue );
   					}
   					// ... und neues FAL erzeugen
   					if ($value) {
   						\nn\t3::Fal()->attach( $model, $propName, $value );
   						continue;
   					} else {
   						$value = null;
   					}
   				}
   			} else if ($this->isStorage($child)) {
   				// -----
   				// Die Property ist eine `ObjectStorage`
   				$value = $this->forceArray( $value );
   				$childPropType = \nn\t3::Obj()->get($propInfo, 'elementType');
   				if (!class_exists($childPropType)) {
   					\nn\t3::Exception( "Class of type `{$childPropType}` is not defined." );
   				}
   				// sys_file stored in the ObjectStorage?
   				$isSysFile = is_a($childPropType, \TYPO3\CMS\Core\Resource\File::class, true);
   				$isFileReference = false;
   				if (!$isSysFile) {
   					$storageItemInstance = \nn\t3::newClass( $childPropType );
   					$isFileReference = $this->isFileReference( $storageItemInstance );
   				}
   				// Array der existierende Items in der `ObjectStorage` holen. Key ist `uid` oder `publicUrl`
   				$existingStorageItemsByUid = [];
   				if ($curPropValue) {
   					foreach ($curPropValue as $item) {
   						$uid = $isFileReference ? \nn\t3::File()->getPublicUrl( $item ) : $this->get( $item, 'uid' );
   						if (!isset($existingStorageItemsByUid)) {
   							$existingStorageItemsByUid[$uid] = [];
   						}
   						$existingStorageItemsByUid[$uid][] = $item;
   					}
   				}
   				$storageClassName = get_class($child);
   				$objectStorage =  \nn\t3::newClass( $storageClassName );
   				// Jedes Item in die Storage einfügen. Dabei werden bereits vorhandene Items aus der alten Storage verwendet.
   				foreach ($value as $itemData) {
   					$uid = false;
   					// `[1, ...]`
   					if (is_numeric($itemData)) $uid = $itemData;
   					// `[['publicUrl'=>'bild.jpg'], ...]` oder `[['bild.jpg'], ...]`
   					if (!$uid && $isFileReference) $uid = \nn\t3::File()->getPublicUrl( $itemData );
   					// `[['uid'=>'1'], ...]`
   					if (!$uid) $uid = $this->get( $itemData, 'uid' );
   					// Gibt es das Item bereits? Dann vorhandenes Item verwenden, kein neues erzeugen!
   					$arrayReference = $existingStorageItemsByUid[$uid] ?? [];
   					$item = array_shift($arrayReference);
   					// Item bereits vorhanden?
   					if ($item) {
   						// ... dann das bisherige Item verwenden.
   						// $item = \nn\t3::Obj( $item )->merge( $itemData );
   					} else if ($isSysFile) {
   						\nn\t3::Exception( "Converting to SysFile not supported yet." );
   					} else if ($isFileReference) {
   						// sonst: Falls eine FileReference gewünscht ist, dann neu erzeugen!
   						$item = \nn\t3::Fal()->createForModel( $model, $propName, $itemData );
   					} else if ($uid) {
   						// Alles AUSSER `FileReference` – und `uid` übergeben/bekannt? Dann das Model aus der Datenbank laden.
   						$item = \nn\t3::Db()->get( $uid, $childPropType );
   						// Model nicht in DB gefunden? Dann ignorieren.
   						if (!$item) continue;
   					} else {
   						// Keine `FileReference` und KEINE `uid` übergeben? Dann neues Model erzeugen.
   						$item = \nn\t3::newClass( $childPropType );
   					}
   					// Model konnte nicht erzeugt / gefunden werden? Dann ignorieren!
   					if (!$item) continue;
   					// Merge der neuen Overlay-Daten und ans Storage hängen
   					$item = \nn\t3::Obj( $item )->merge( $itemData );
   					$objectStorage->attach( $item );
   				}
   				$value = $objectStorage;
   			}
   			else if ( is_a($child, \DateTime::class, true )) {
   				// -----
   				// Die Property ist ein `DateTime`
   				if ($value) {
   					$value = (new \DateTime())->setTimestamp( $value );
   				} else {
   					$value = null;
   				}
   			}
   			else {
   				// -----
   				// Property enthält eine einzelne Relation, ist aber weder eine `FileReference` noch eine `ObjectStorage`
   				if ($uid = is_numeric($value) ? $value : $this->get( $value, 'uid' )) {
   					$child = \nn\t3::Db()->get( $uid, get_class($child) );
   					if (!$child) $value = null;
   				}
   				if ($value) {
   					$value = \nn\t3::Obj( $child )->merge( $value );
   				}
   			}
   			$this->set( $model, $propName, $value );
   		}
   	}
   	return $model;
   }
   

