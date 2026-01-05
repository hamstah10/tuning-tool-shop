
.. include:: ../../../../Includes.txt

.. _Page-clearCache:

==============================================
Page::clearCache()
==============================================

\\nn\\t3::Page()->clearCache(``$pid = NULL``);
----------------------------------------------

Seiten-Cache einer (oder mehrerer) Seiten löschen

.. code-block:: php

	\nn\t3::Page()->clearCache( $pid );
	\nn\t3::Page()->clearCache( [1,2,3] );
	\nn\t3::Page()->clearCache();

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function clearCache ( $pid = null ) {
   	$pidList = \nn\t3::Arrays($pid ?: 'all')->trimExplode();
   	if (\nn\t3::Environment()->isFrontend()) {
   		// Im Frontend-Context
   		$cacheService = GeneralUtility::makeInstance( CacheService::class );
   		$cacheManager = GeneralUtility::makeInstance( CacheManager::class );
   		foreach ($pidList as $pid) {
   			if ($pid == 'all') {
   				$cacheService->clearCachesOfRegisteredPageIds();
   				$cacheService->clearPageCache();
   			} else {
   				$cacheService->clearPageCache($pid);
   				$cacheManager->flushCachesInGroupByTags('pages', [ 'pageId_'.$pid ]);
   				$cacheService->getPageIdStack()->push($pid);
   				$cacheService->clearCachesOfRegisteredPageIds();
   			}
   		}
   	} else {
   		// Im Backend-Context kann der DataHandler verwendet werden
   		$dataHandler = GeneralUtility::makeInstance( DataHandler::class );
   		$dataHandler->admin = 1;
   		$dataHandler->start([], []);
   		foreach ($pidList as $pid) {
   			$dataHandler->clear_cacheCmd($pid);
   		}
   	}
   }
   

