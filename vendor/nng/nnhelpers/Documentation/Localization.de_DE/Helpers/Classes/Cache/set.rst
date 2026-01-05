
.. include:: ../../../../Includes.txt

.. _Cache-set:

==============================================
Cache::set()
==============================================

\\nn\\t3::Cache()->set(``$identifier = '', $data = NULL, $useRamCache = false``);
----------------------------------------------

Schreibt einen Eintrag in den Typo3-Cache.
Der Identifier ist ein beliebiger String oder ein Array, der den Cache eindeutif Identifiziert.

.. code-block:: php

	// Klassische Anwendung im Controller: Cache holen und setzen
	if ($cache = \nn\t3::Cache()->get('myid')) return $cache;
	...
	$cache = $this->view->render();
	return \nn\t3::Cache()->set('myid', $cache);

.. code-block:: php

	// RAM-Cache verwenden? TRUE als dritter Parameter setzen
	\nn\t3::Cache()->set('myid', $dataToCache, true);
	
	// Dauer des Cache auf 60 Minuten festlegen
	\nn\t3::Cache()->set('myid', $dataToCache, 3600);
	
	// Als key kann auch ein Array angegeben werden
	\nn\t3::Cache()->set(['pid'=>1, 'uid'=>'7'], $html);

| ``@param mixed $indentifier`` String oder Array zum Identifizieren des Cache
| ``@param mixed $data``            Daten, die in den Cache geschrieben werden sollen. (String oder Array)
| ``@param mixed $useRamCache`` ``true``: temporärer Cache in $GLOBALS statt Caching-Framework.
| ``integer``: Wie viele Sekunden cachen?

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
   

