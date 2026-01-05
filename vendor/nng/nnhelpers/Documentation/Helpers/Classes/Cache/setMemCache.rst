
.. include:: ../../../../Includes.txt

.. _Cache-setMemCache:

==============================================
Cache::setMemCache()
==============================================

\\nn\\t3::Cache()->setMemCache(``$identifier = '', $data = NULL, $lifetime = 3600``);
----------------------------------------------

Writes an entry to the MemCache (APCu, Redis, Memcached).
Automatically selects the best available backend.

.. code-block:: php

	// Easy to use
	\nn\t3::Cache()->setMemCache('my_key', $data);
	
	// With expiration time in seconds (here: 1 hour)
	\nn\t3::Cache()->setMemCache('my_key', $data, 3600);
	
	// With array as identifier
	\nn\t3::Cache()->setMemCache(['func'=>__METHOD__, 'args'=>$args], $result, 1800);
	
	// Typical use in the controller
	if ($cache = \nn\t3::Cache()->getMemCache('my_key')) {
	    return $cache;
	}
	$result = $this->expensiveOperation();
	return \nn\t3::Cache()->setMemCache('my_key', $result, 3600);

| ``@param mixed $identifier`` String or array to identify the cache
| ``@param mixed $data`` Data to be written to the cache
| ``@param int $lifetime`` Lifetime in seconds (default: 3600)
| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setMemCache( $identifier = '', $data = null, $lifetime = 3600 )
   {
   	$identifier = self::getIdentifier( $identifier );
   	$expires = time() + $lifetime;
   	$cacheUtility = $this->getMemCacheInstance();
   	if (!$cacheUtility) {
   		return $data;
   	}
   	$serializedData = json_encode(['content'=>$data, 'expires'=>$expires]);
   	$cacheUtility->set($identifier, $serializedData, [], $lifetime);
   	return $data;
   }
   

