
.. include:: ../../../../Includes.txt

.. _Obj-toArray:

==============================================
Obj::toArray()
==============================================

\\nn\\t3::Obj()->toArray(``$obj, $depth = 3, $fields = [], $addClass = false``);
----------------------------------------------

Konvertiert ein Object in ein Array
Bei Memory-Problemen wegen Rekursionen: Max-Tiefe angebenen!

.. code-block:: php

	\nn\t3::Obj()->toArray($obj, 2, ['uid', 'title']);
	\nn\t3::Obj()->toArray($obj, 1, ['uid', 'title', 'parent.uid']);

| ``@param mixed $obj``             ObjectStorage, Model oder Array das Konvertiert werden soll
| ``@param integer $depth``         Tiefe, die konvertiert werden soll. Bei rekursivem Konvertieren unbedingt nutzen
| ``@param array $fields``      nur diese Felder aus dem Object / Array zurückgeben
| ``@param boolean $addClass``  '__class' mit Infos zur Klasse ergänzen?

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function toArray ( $obj, $depth = 3, $fields = [], $addClass = false )
   {
   	if ($obj === null) {
   		return null;
   	}
   	$isSimpleType = $this->isSimpleType( gettype($obj) );
   	$isStorage = !$isSimpleType && $this->isStorage($obj);
   	if ($depth < 0) {
   		return $isSimpleType && !is_array($obj) ? $obj : self::END_OF_RECURSION;
   	}
   	if ($isSimpleType && !is_array($obj)) {
   		return $obj;
   	}
   	$type = is_object($obj) ? get_class($obj) : false;
   	$final = [];
   	$depth--;
   	if (is_a($obj, \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult::class)) {
   		$obj = $obj->toArray();
   	} else if (is_a($obj, \DateTime::class)) {
   		// DateTime in UTC konvertieren
   		$utc = $obj->getTimestamp();
   		return $utc;
   	} else if ($isStorage) {
   		// StorageObject in einfaches Array konvertieren
   		$obj = $this->forceArray( $obj );
   		if ($addClass) $obj['__class'] = ObjectStorage::class;
   	} else if (\nn\t3::Obj()->isSysCategory($obj)) {
   		//$categoryData = ['uid' => $obj->getUid(), 'title'=>$obj->getTitle(), 'parent'=>$parent];
   		$categoryData = [];
   		foreach ($this->getKeys($obj) as $k) {
   			if ($k == 'parent') {
   				$categoryData[$k] = $this->toArray( $obj->getParent(), $depth, $fields, $addClass );
   				continue;
   			}
   			$categoryData[$k] = ObjectAccess::getProperty($obj, $k);
   		}
   		if ($addClass) $categoryData['__class'] = $type;
   		return $categoryData;
   	} else if (\nn\t3::Obj()->isFalFile($obj)) {
   		// SysFile in Array konvertieren
   		$falData = ['uid' => $obj->getUid(), 'title'=>$obj->getTitle(), 'publicUrl'=>$obj->getPublicUrl()];
   		if ($addClass) $falData['__class'] = $type;
   		return $falData;
   	} else if (\nn\t3::Obj()->isFileReference($obj)) {
   		// FileReference in einfaches Array konvertieren
   		$map = ['uid', 'pid', 'title', 'alternative', 'link', 'description', 'size', 'publicUrl', 'crop', 'type'];
   		$falData = [];
   		if ($originalResource = $obj->getOriginalResource()) {
   			$props = $originalResource->getProperties();
   			$props['publicUrl'] = $originalResource->getPublicUrl();
   			foreach ($map as $k=>$v) {
   				$falData[$v] = $props[$v];
   			}
   		}
   		// Falls FAL nicht über Backend erzeugt wurde, fehlt evtl. das Feld "crop". Also: mit default nachrüsten
   		if (!$falData['crop']) {
   			$falData['crop'] = json_encode(['default'=>['cropArea' => ['x'=>0, 'y'=>0, 'width'=>1, 'height'=>1]]]);
   		}
   		if ($addClass) $falData['__class'] = FalFileReference::class;
   		return $falData;
   	} else if ($type) {
   		// Alle anderen Objekte
   		$keys = $fields ?: $this->getKeys($obj);
   		foreach ($keys as $field) {
   			$val = $this->prop($obj, $field);
   			$val = $this->toArray($val, $depth, $fields, $addClass);
   			if ($val === self::END_OF_RECURSION) continue;
   			$final[$field] = $val;
   		}
   		return $final;
   	}
   	foreach ($obj as $k=>$v) {
   		$val = $this->toArray( $v, $depth, $fields, $addClass );
   		if ($val === self::END_OF_RECURSION) continue;
   		$final[$k] = $val;
   	}
   	return $final;
   }
   

