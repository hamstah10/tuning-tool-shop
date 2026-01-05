
.. include:: ../../../../Includes.txt

.. _Cache-read:

==============================================
Cache::read()
==============================================

\\nn\\t3::Cache()->read(``$identifier``);
----------------------------------------------

Read static file cache.

Reads the PHP file that was written via ``\nn\t3::Cache()->write()``.

.. code-block:: php

	$cache = \nn\t3::Cache()->read( $identifier );

The PHP file is an executable PHP script with the ``return command``
It stores the cache content in an array.

.. code-block:: php

	...];

| ``@return string|array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function read( $identifier )
   {
   	if ($cache = $this->get( $identifier, true )) return $cache;
   	$identifier = self::getIdentifier( $identifier );
   	$path = \nn\t3::Environment()->getVarPath() . "/cache/code/nnhelpers/{$identifier}.php";
   	if (!file_exists($path)) {
   		return null;
   	}
   	$cache = require( $path );
   	return $cache['_'];
   }
   

