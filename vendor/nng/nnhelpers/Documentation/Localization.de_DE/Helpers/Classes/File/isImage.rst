
.. include:: ../../../../Includes.txt

.. _File-isImage:

==============================================
File::isImage()
==============================================

\\nn\\t3::File()->isImage(``$filename = NULL``);
----------------------------------------------

Gibt an, ob die Datei in ein Bild ist

.. code-block:: php

	\nn\t3::File()->isImage('bild.jpg');   => gibt true zurück
	\nn\t3::File()->isImage('text.ppt');   => gibt false zurück

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isImage($filename = null)
   {
   	if (!$filename) return false;
   	$suffix = $this->suffix($filename);
   	$arr = array_merge(self::$TYPES['image']);
   	return in_array($suffix, $arr);
   }
   

