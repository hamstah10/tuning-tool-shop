
.. include:: ../../../../Includes.txt

.. _File-isConvertableToImage:

==============================================
File::isConvertableToImage()
==============================================

\\nn\\t3::File()->isConvertableToImage(``$filename = NULL``);
----------------------------------------------

Specifies whether the file can be converted to an image

.. code-block:: php

	\nn\t3::File()->isConvertableToImage('image.jpg'); => returns true
	\nn\t3::File()->isConvertableToImage('text.ppt'); => returns false

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
   

