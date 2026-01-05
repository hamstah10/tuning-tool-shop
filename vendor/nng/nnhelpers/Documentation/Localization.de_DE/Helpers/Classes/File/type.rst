
.. include:: ../../../../Includes.txt

.. _File-type:

==============================================
File::type()
==============================================

\\nn\\t3::File()->type(``$filename = NULL``);
----------------------------------------------

Gibt die Art der Datei anhand des Datei-Suffixes zurück

.. code-block:: php

	\nn\t3::File()->type('bild.jpg');  => gibt 'image' zurück
	\nn\t3::File()->type('text.doc');  => gibt 'document' zurück

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function type($filename = null)
   {
   	if (!$filename) return false;
   	$suffix = $this->suffix($filename);
   	foreach (self::$TYPES as $k => $arr) {
   		if (in_array($suffix, $arr)) return $k;
   	}
   	return 'other';
   }
   

