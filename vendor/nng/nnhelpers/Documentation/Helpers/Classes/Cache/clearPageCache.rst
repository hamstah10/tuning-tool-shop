
.. include:: ../../../../Includes.txt

.. _Cache-clearPageCache:

==============================================
Cache::clearPageCache()
==============================================

\\nn\\t3::Cache()->clearPageCache(``$pid = NULL``);
----------------------------------------------

Deletes the page cache. Alias to ``\nn\t3::Page()->clearCache()``

.. code-block:: php

	\nn\t3::Cache()->clearPageCache( 17 ); // Delete page cache for pid=17
	\nn\t3::Cache()->clearPageCache(); // clear cache of ALL pages

| ``@param mixed $pid`` pid of the page whose cache is to be cleared or leave empty for all pages
| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function clearPageCache( $pid = null )
   {
   	return \nn\t3::Page()->clearCache( $pid );
   }
   

