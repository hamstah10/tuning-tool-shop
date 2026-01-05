
.. include:: ../../../../Includes.txt

.. _SysCategory-getTree:

==============================================
SysCategory::getTree()
==============================================

\\nn\\t3::SysCategory()->getTree(``$branchUid = NULL``);
----------------------------------------------

Get the entire SysCategory tree (as an array).
Each node has the attributes 'parent' and 'children' in order to
recursively iterate through the tree.

.. code-block:: php

	// Get the entire tree
	\nn\t3::SysCategory()->getTree();
	
	// Get a specific branch of the tree
	\nn\t3::SysCategory()->getTree( $uid );
	
	// Get all branches of the tree, key is the UID of the SysCategory
	\nn\t3::SysCategory()->getTree( true );

ToDo: Check whether caching makes sense

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
   

