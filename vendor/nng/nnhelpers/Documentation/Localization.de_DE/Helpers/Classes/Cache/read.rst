
.. include:: ../../../../Includes.txt

.. _Cache-read:

==============================================
Cache::read()
==============================================

\\nn\\t3::Cache()->read(``$identifier``);
----------------------------------------------

Statischen Datei-Cache lesen.

Liest die PHP-Datei, die per ``\nn\t3::Cache()->write()`` geschrieben wurde.

.. code-block:: php

	$cache = \nn\t3::Cache()->read( $identifier );

Die PHP-Datei ist ein ausführbares PHP-Script mit dem ``return``-Befehl.
Sie speichert den Cache-Inhalt in einem Array.

.. code-block:: php

	<?php
	    return ['_'=>...];

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
   

