
.. include:: ../../../../Includes.txt

.. _Cache-clearPageCache:

==============================================
Cache::clearPageCache()
==============================================

\\nn\\t3::Cache()->clearPageCache(``$pid = NULL``);
----------------------------------------------

Löscht den Seiten-Cache. Alias zu ``\nn\t3::Page()->clearCache()``

.. code-block:: php

	\nn\t3::Cache()->clearPageCache( 17 );       // Seiten-Cache für pid=17 löschen
	\nn\t3::Cache()->clearPageCache();           // Cache ALLER Seiten löschen

| ``@param mixed $pid``     pid der Seite, deren Cache gelöscht werden soll oder leer lassen für alle Seite
| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function clearPageCache( $pid = null )
   {
   	return \nn\t3::Page()->clearCache( $pid );
   }
   

