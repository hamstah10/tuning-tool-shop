
.. include:: ../../../../Includes.txt

.. _Cache-getMemCache:

==============================================
Cache::getMemCache()
==============================================

\\nn\\t3::Cache()->getMemCache(``$identifier = ''``);
----------------------------------------------

Loads content from the MemCache (APCu, Redis, Memcached) using an identifier.
Automatically selects the best available backend.

.. code-block:: php

	// Simple use with string identifier
	$data = \nn\t3::Cache()->getMemCache('my_key');
	
	// With array as identifier
	$data = \nn\t3::Cache()->getMemCache(['pid'=>1, 'uid'=>'7']);
	
	// Typical use in the controller
	if ($cache = \nn\t3::Cache()->getMemCache('my_key')) {
	    return $cache;
	}
	$result = $this->expensiveOperation();
	\nn\t3::Cache()->setMemCache('my_key', $result, 3600);

| ``@param mixed $identifier`` String or array to identify the cache
| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getMemCache( $identifier = '' )
   {
   	$identifier = self::getIdentifier( $identifier );
   	$cacheUtility = $this->getMemCacheInstance();
   	if (!$cacheUtility) {
   		return false;
   	}
   	if ($data = $cacheUtility->get($identifier)) {
   		$data = json_decode( $data, true );
   		if ($data['content'] && $data['expires'] < time()) return false;
   		return $data['content'] ?: false;
   	}
   	return false;
   }
   

