
.. include:: ../../../../Includes.txt

.. _Cache-set:

==============================================
Cache::set()
==============================================

\\nn\\t3::Cache()->set(``$identifier = '', $data = NULL, $useRamCache = false``);
----------------------------------------------

Writes an entry to the Typo3 cache.
The identifier is an arbitrary string or an array that uniquely identifies the cache.

.. code-block:: php

	// Classic application in the controller: Get and set cache
	if ($cache = \nn\t3::Cache()->get('myid')) return $cache;
	...
	$cache = $this->view->render();
	return \nn\t3::Cache()->set('myid', $cache);

.. code-block:: php

	// Use RAM cache? Set TRUE as the third parameter
	\nn\t3::Cache()->set('myid', $dataToCache, true);
	
	// Set the duration of the cache to 60 minutes
	\nn\t3::Cache()->set('myid', $dataToCache, 3600);
	
	// An array can also be specified as the key
	\nn\t3::Cache()->set(['pid'=>1, 'uid'=>'7'], $html);

| ``@param mixed $indentifier`` String or array to identify the cache
| ``@param mixed $data`` Data to be written to the cache. (string or array)
| ``@param mixed $useRamCache`` ``true``: temporary cache in $GLOBALS instead of caching framework.
| ``integer``: How many seconds to cache?

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function set( $identifier = '', $data = null, $useRamCache = false )
   {
   	$identifier = self::getIdentifier( $identifier );
   	$lifetime = 86400;
   	if ($useRamCache === true) {
   		if (!isset($GLOBALS['nnhelpers_cache'])) {
   			$GLOBALS['nnhelpers_cache'] = [];
   		}
   		return $GLOBALS['nnhelpers_cache'][$identifier] = $data;
   	} else if ( $useRamCache !== false ) {
   		$lifetime = intval($useRamCache);
   	}
   	$expires = time() + $lifetime;
   	$cacheUtility = $this->getCacheInstance();
   	if (!$cacheUtility) {
   		return $data;
   	}
   	$serializedData = json_encode(['content'=>$data, 'expires'=>$expires]);
   	$cacheUtility->set($identifier, $serializedData, [], $lifetime);
   	return $data;
   }
   

