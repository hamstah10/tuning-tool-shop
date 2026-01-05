
.. include:: ../../../Includes.txt

.. _Cache:

==============================================
Cache
==============================================

\\nn\\t3::Cache()
----------------------------------------------

Methods for reading and writing to the TYPO3 cache.
Uses the TYPO3 caching framework, see ``EXT:nnhelpers/ext_localconf.php`` for details

TYPO3 Cache
| ``get( $identifier )`` / ``set( $identifier, $data )``
Caching framework (DB or file system, depending on TYPO3 configuration).
Medium performance, as based on database (or file system,
depending on TYPO3 configuration).
Remains across the requests of all clients.

RAM cache via global variable
| ``get( $identifier, true )`` / ``set( $identifier, $data, true )``
Saves data in the global variable ``$GLOBALS['nnhelpers_cache']``
Ideal for data that is retrieved multiple times in the same request.
Extremely fast, but can only be used during a request, is deleted after
deleted after each request.

Static PHP files in the file system
| ``read( $identifier )`` / ``write( $identifier, $data )``
Static PHP files in the file system``(var/cache/code/nnhelpers/``).
Fast through direct ``require()``
Remains across the requests of all clients.

In-Memory Cache
| ``getMemCache( $identifier )`` / ``setMemCache( $identifier, $data )``
In-memory cache (APCu, Redis, Memcached - depending on availability).
For frequently accessed data and sessions. Very fast, as it is RAM-based.
Remains intact across the requests of all clients.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Cache()->clear(``$identifier = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes caches.
If an ``identifier`` is specified, only the caches of the specific identifier are deleted
identifier are deleted Ã¢ otherwise ALL caches of all extensions and pages.

RAM caches
CachingFramework caches that were set via ``\nn\t3::Cache()->set()`` 
File caches that were set via ``\nn\t3::Cache()->write()`` 

.. code-block:: php

	// delete ALL caches Ã¢ also the caches of other extensions, pages etc.
	\nn\t3::Cache()->clear();
	
	// Delete only the caches with a specific identifier
	\nn\t3::Cache()->clear('nnhelpers');

| ``@param string $identifier``
| ``@return void``

| :ref:`➜ Go to source code of Cache::clear() <Cache-clear>`

\\nn\\t3::Cache()->clearMemCache(``$identifier = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes the MemCache (APCu, Redis, Memcached).
Without identifier, the entire nnhelpers MemCache is deleted.
With identifier, only the specific entry is deleted.

.. code-block:: php

	// Delete the entire nnhelpers MemCache
	\nn\t3::Cache()->clearMemCache();
	
	// Delete only one specific entry
	\nn\t3::Cache()->clearMemCache('my_key');
	
	// With array as identifier
	\nn\t3::Cache()->clearMemCache(['pid'=>1, 'uid'=>'7']);

| ``@param mixed $identifier`` Optional: String or array to identify the cache entry
| ``@return void``

| :ref:`➜ Go to source code of Cache::clearMemCache() <Cache-clearMemCache>`

\\nn\\t3::Cache()->clearPageCache(``$pid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes the page cache. Alias to ``\nn\t3::Page()->clearCache()``

.. code-block:: php

	\nn\t3::Cache()->clearPageCache( 17 ); // Delete page cache for pid=17
	\nn\t3::Cache()->clearPageCache(); // clear cache of ALL pages

| ``@param mixed $pid`` pid of the page whose cache is to be cleared or leave empty for all pages
| ``@return void``

| :ref:`➜ Go to source code of Cache::clearPageCache() <Cache-clearPageCache>`

\\nn\\t3::Cache()->get(``$identifier = '', $useRamCache = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

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

| :ref:`➜ Go to source code of Cache::get() <Cache-get>`

\\nn\\t3::Cache()->getIdentifier(``$identifier = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts transferred cache identifiers into a usable string.
Can also process an array as identifier.

| ``@param mixed $indentifier``
| ``@return string``

| :ref:`➜ Go to source code of Cache::getIdentifier() <Cache-getIdentifier>`

\\nn\\t3::Cache()->getMemCache(``$identifier = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

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

| :ref:`➜ Go to source code of Cache::getMemCache() <Cache-getMemCache>`

\\nn\\t3::Cache()->read(``$identifier``);
"""""""""""""""""""""""""""""""""""""""""""""""

Read static file cache.

Reads the PHP file that was written via ``\nn\t3::Cache()->write()``.

.. code-block:: php

	$cache = \nn\t3::Cache()->read( $identifier );

The PHP file is an executable PHP script with the ``return command``
It stores the cache content in an array.

.. code-block:: php

	...];

| ``@return string|array``

| :ref:`➜ Go to source code of Cache::read() <Cache-read>`

\\nn\\t3::Cache()->set(``$identifier = '', $data = NULL, $useRamCache = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

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

| :ref:`➜ Go to source code of Cache::set() <Cache-set>`

\\nn\\t3::Cache()->setMemCache(``$identifier = '', $data = NULL, $lifetime = 3600``);
"""""""""""""""""""""""""""""""""""""""""""""""

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

| :ref:`➜ Go to source code of Cache::setMemCache() <Cache-setMemCache>`

\\nn\\t3::Cache()->write(``$identifier, $cache``);
"""""""""""""""""""""""""""""""""""""""""""""""

Write static file cache.

Writes a PHP file that can be loaded via ``$cache = require('...')``.

Based on many core functions and extensions (e.g. mask), which place static PHP files
into the file system in order to better cache performance-intensive processes such as class paths, annotation parsing etc.
better. Deliberately do not use the core functions in order to avoid any overhead and
and to ensure the greatest possible compatibility with core updates.

.. code-block:: php

	$cache = ['a'=>1, 'b'=>2];
	$identifier = 'myid';
	
	\nn\t3::Cache()->write( $identifier, $cache );
	$read = \nn\t3::Cache()->read( $identifier );

The example above generates a PHP file with this content:

.. code-block:: php

	 ['a'=>1, 'b'=>2]];

| ``@return string|array``

| :ref:`➜ Go to source code of Cache::write() <Cache-write>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
