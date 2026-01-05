
.. include:: ../../../../Includes.txt

.. _Cache-clear:

==============================================
Cache::clear()
==============================================

\\nn\\t3::Cache()->clear(``$identifier = NULL``);
----------------------------------------------

Deletes caches.
If an ``identifier`` is specified, only the caches of the specific identifier are deleted
identifier are deleted Ã¢ otherwise ALL caches of all extensions and pages.

RAM caches
CachingFramework caches that were set via ``\nn\t3::Cache()->set()`` 
File caches that were set via ``\nn\t3::Cache()->write()`` 

.. code-block:: php

	// delete ALL caches Ã¢ also the caches of other extensions, pages etc.
	\nn\t3::Cache()->clear();
	
	// Delete only the caches with a specific identifier
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
   

