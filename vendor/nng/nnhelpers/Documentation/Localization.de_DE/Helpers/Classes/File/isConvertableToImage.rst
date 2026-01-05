
.. include:: ../../../../Includes.txt

.. _File-isConvertableToImage:

==============================================
File::isConvertableToImage()
==============================================

\\nn\\t3::File()->isConvertableToImage(``$filename = NULL``);
----------------------------------------------

Gibt an, ob die Datei in ein Bild konvertiert werden kann

.. code-block:: php

	\nn\t3::File()->isConvertableToImage('bild.jpg');  => gibt true zurück
	\nn\t3::File()->isConvertableToImage('text.ppt');  => gibt false zurück

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isConvertableToImage($filename = null)
   {
   	if (!$filename) return false;
   	$suffix = $this->suffix($filename);
   	$arr = array_merge(self::$TYPES['image'], self::$TYPES['pdf']);
   	return in_array($suffix, $arr);
   }
   

