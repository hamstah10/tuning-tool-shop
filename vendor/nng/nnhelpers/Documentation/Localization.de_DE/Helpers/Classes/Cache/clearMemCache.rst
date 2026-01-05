
.. include:: ../../../../Includes.txt

.. _Cache-clearMemCache:

==============================================
Cache::clearMemCache()
==============================================

\\nn\\t3::Cache()->clearMemCache(``$identifier = NULL``);
----------------------------------------------

Löscht den MemCache (APCu, Redis, Memcached).
Ohne Identifier wird der gesamte nnhelpers MemCache gelöscht.
Mit Identifier wird nur der spezifische Eintrag gelöscht.

.. code-block:: php

	// Gesamten nnhelpers MemCache löschen
	\nn\t3::Cache()->clearMemCache();
	
	// Nur einen spezifischen Eintrag löschen
	\nn\t3::Cache()->clearMemCache('mein_key');
	
	// Mit Array als Identifier
	\nn\t3::Cache()->clearMemCache(['pid'=>1, 'uid'=>'7']);

| ``@param mixed $identifier``  Optional: String oder Array zum Identifizieren des Cache-Eintrags
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
   

