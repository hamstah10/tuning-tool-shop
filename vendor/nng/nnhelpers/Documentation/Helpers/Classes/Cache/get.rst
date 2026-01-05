
.. include:: ../../../../Includes.txt

.. _Cache-get:

==============================================
Cache::get()
==============================================

\\nn\\t3::Cache()->get(``$identifier = '', $useRamCache = false``);
----------------------------------------------

Reads the content of the Typo3 cache using an identifier.
The identifier is any string or array that uniquely identifies the cache.

.. code-block:: php

	\nn\t3::Cache()->get('myid');
	\nn\t3::Cache()->get(['pid'=>1, 'uid'=>'7']);
	\nn\t3::Cache()->get(['func'=>__METHOD__, 'uid'=>'17']);
	\nn\t3::Cache()->get([__METHOD__=>$this->request->getArguments()]);

| ``@param mixed $identifier`` String or array to identify the cache
| ``@param mixed $useRamCache`` temporary cache in $GLOBALS instead of caching framework

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function get( $identifier = '', $useRamCache = false )
   {
   	$identifier = self::getIdentifier( $identifier );
   	// Ram-Cache verwenden? Einfache globale.
   	if ($useRamCache && ($cache = $GLOBALS['nnhelpers_cache'][$identifier] ?? false)) {
   		return $cache;
   	}
   	$cacheUtility = $this->getCacheInstance();
   	if (!$cacheUtility) {
   		return false;
   	}
   	if ($data = $cacheUtility->get($identifier)) {
   		$data = json_decode( $cacheUtility->get($identifier), true );
   		if ($data['content'] && $data['expires'] < time()) return false;
   		return $data['content'] ?: false;
   	}
   	return false;
   }
   

