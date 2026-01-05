
.. include:: ../../../../Includes.txt

.. _Cache-setMemCache:

==============================================
Cache::setMemCache()
==============================================

\\nn\\t3::Cache()->setMemCache(``$identifier = '', $data = NULL, $lifetime = 3600``);
----------------------------------------------

Schreibt einen Eintrag in den MemCache (APCu, Redis, Memcached).
Wählt automatisch das beste verfügbare Backend.

.. code-block:: php

	// Einfache Verwendung
	\nn\t3::Cache()->setMemCache('mein_key', $daten);
	
	// Mit Ablaufzeit in Sekunden (hier: 1 Stunde)
	\nn\t3::Cache()->setMemCache('mein_key', $daten, 3600);
	
	// Mit Array als Identifier
	\nn\t3::Cache()->setMemCache(['func'=>__METHOD__, 'args'=>$args], $result, 1800);
	
	// Typische Verwendung im Controller
	if ($cache = \nn\t3::Cache()->getMemCache('mein_key')) {
	    return $cache;
	}
	$result = $this->expensiveOperation();
	return \nn\t3::Cache()->setMemCache('mein_key', $result, 3600);

| ``@param mixed $identifier``  String oder Array zum Identifizieren des Cache
| ``@param mixed $data``        Daten, die in den Cache geschrieben werden sollen
| ``@param int $lifetime``      Lebensdauer in Sekunden (Standard: 3600)
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
   

