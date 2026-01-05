
.. include:: ../../../../Includes.txt

.. _Cache-clear:

==============================================
Cache::clear()
==============================================

\\nn\\t3::Cache()->clear(``$identifier = NULL``);
----------------------------------------------

Löscht Caches.
Wird ein ``identifier`` angegeben, dann werden nur die Caches des spezifischen
identifiers gelöscht – sonst ALLE Caches aller Extensions und Seiten.

RAM-Caches
CachingFramework-Caches, die per ``\nn\t3::Cache()->set()`` gesetzt wurde
Datei-Caches, die per ``\nn\t3::Cache()->write()`` gesetzt wurde

.. code-block:: php

	// ALLE Caches löschen – auch die Caches anderer Extensions, der Seiten etc.
	\nn\t3::Cache()->clear();
	
	// Nur die Caches mit einem bestimmten Identifier löschen
	\nn\t3::Cache()->clear('nnhelpers');

| ``@param string $identifier``
| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function clear( $identifier = null )
   {
   	if (!$identifier) {
   		// ALLE TYPO3 Caches löschen, der über das CachingFramework registriert wurde
   		$this->cacheManager->flushCaches();
   	} else {
   		// Spezifischen Cache löschen
   		if ($cacheUtility = $this->cacheManager->getCache( $identifier )) {
   			$cacheUtility->flush();
   		}
   	}
   	if (!$identifier || $identifier == 'nnhelpers') {
   		// RAM Cache löschen
   		$GLOBALS['nnhelpers_cache'] = [];
   		// File-Cache löschen
   		$cacheDir = \nn\t3::Environment()->getVarPath() . "/cache/code/nnhelpers";
   		if (is_dir($cacheDir)) {
   			$iterator = new \DirectoryIterator($cacheDir);
   			foreach ($iterator as $file) {
   				if ($file->isFile() && $file->getExtension() === 'php') {
   					unlink($file->getPathname());
   				}
   			}
   		}
   	}
   }
   

