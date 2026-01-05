
.. include:: ../../../../Includes.txt

.. _SysCategory-getTree:

==============================================
SysCategory::getTree()
==============================================

\\nn\\t3::SysCategory()->getTree(``$branchUid = NULL``);
----------------------------------------------

Den gesamten SysCategory-Baum (als Array) holen.
Jeder Knotenpunkt hat die Attribute 'parent' und 'children', um
rekursiv durch Baum iterieren zu können.

.. code-block:: php

	// Gesamten Baum holen
	\nn\t3::SysCategory()->getTree();
	
	// Bestimmten Ast des Baums holen
	\nn\t3::SysCategory()->getTree( $uid );
	
	// Alle Äste des Baums holen, key ist die UID der SysCategory
	\nn\t3::SysCategory()->getTree( true );

ToDo: Prüfen, ob Caching sinnvoll ist

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getTree ( $branchUid = null )
   {
   	// Alle Kategorien laden
   	$allCategories = $this->findAll();
   	// Array mit uid als Key erstellen
   	$categoriesByUid = [0=>['children'=>[]]];
   	foreach ($allCategories as $sysCategory) {
   		// Object zu Array konvertieren
   		$sysCatArray = \nn\t3::Obj()->toArray($sysCategory, 3);
   		$sysCatArray['children'] = [];
   		$sysCatArray['_parent'] = $sysCatArray['parent'];
   		$categoriesByUid[$sysCatArray['uid']] = $sysCatArray;
   	}
   	// Baum generieren
   	foreach ($categoriesByUid as $uid=>$sysCatArray) {
   		$parent = $sysCatArray['_parent'] ?? [];
   		if (($parent['uid'] ?? false) != $uid) {
   			$parentUid = $parent ? $parent['uid'] : 0;
   			$categoriesByUid[$parentUid]['children'][$uid] = &$categoriesByUid[$uid];
   			$categoriesByUid[$uid]['parent'] = $parentUid > 0 ? $categoriesByUid[$parentUid] : false;
   			unset($categoriesByUid[$uid]['_parent']);
   		}
   	}
   	// Wurzel
   	$root = $categoriesByUid[0]['children'] ?? false ?: [];
   	// Ganzen Baum – oder nur bestimmten Branch zurückgeben?
   	if (!$branchUid) return $root;
   	// Alle Äste holen
   	if ($branchUid === true) {
   		return $categoriesByUid;
   	}
   	// bestimmten Branch holen
   	return $categoriesByUid[$branchUid] ?? false ?: [];
   }
   

