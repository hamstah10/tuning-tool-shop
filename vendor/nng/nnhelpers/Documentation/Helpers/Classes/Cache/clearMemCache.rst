
.. include:: ../../../../Includes.txt

.. _Cache-clearMemCache:

==============================================
Cache::clearMemCache()
==============================================

\\nn\\t3::Cache()->clearMemCache(``$identifier = NULL``);
----------------------------------------------

Deletes the MemCache (APCu, Redis, Memcached).
Without identifier, the entire nnhelpers MemCache is deleted.
With identifier, only the specific entry is deleted.

.. code-block:: php

	// Delete the entire nnhelpers MemCache
	\nn\t3::Cache()->clearMemCache();
	
	// Delete only one specific entry
	\nn\t3::Cache()->clearMemCache('my_key');
	
	// With array as identifier
	\nn\t3::Cache()->clearMemCache(['pid'=>1, 'uid'=>'7']);

| ``@param mixed $identifier`` Optional: String or array to identify the cache entry
| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function clearMemCache( $identifier = null )
   {
   	$cacheUtility = $this->getMemCacheInstance();
   	if (!$cacheUtility) {
   		return;
   	}
   	if ($identifier === null) {
   		$cacheUtility->flush();
   	} else {
   		$identifier = self::getIdentifier( $identifier );
   		$cacheUtility->remove($identifier);
   	}
   }
   

