
.. include:: ../../../../Includes.txt

.. _Cache-getMemCache:

==============================================
Cache::getMemCache()
==============================================

\\nn\\t3::Cache()->getMemCache(``$identifier = ''``);
----------------------------------------------

Lädt Inhalt aus dem MemCache (APCu, Redis, Memcached) anhand eines Identifiers.
Wählt automatisch das beste verfügbare Backend.

.. code-block:: php

	// Einfache Verwendung mit String-Identifier
	$data = \nn\t3::Cache()->getMemCache('mein_key');
	
	// Mit Array als Identifier
	$data = \nn\t3::Cache()->getMemCache(['pid'=>1, 'uid'=>'7']);
	
	// Typische Verwendung im Controller
	if ($cache = \nn\t3::Cache()->getMemCache('mein_key')) {
	    return $cache;
	}
	$result = $this->expensiveOperation();
	\nn\t3::Cache()->setMemCache('mein_key', $result, 3600);

| ``@param mixed $identifier``  String oder Array zum Identifizieren des Cache
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
   

