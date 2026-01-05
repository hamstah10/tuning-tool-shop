
.. include:: ../../../../Includes.txt

.. _File-isImage:

==============================================
File::isImage()
==============================================

\\nn\\t3::File()->isImage(``$filename = NULL``);
----------------------------------------------

Indicates whether the file is in an image

.. code-block:: php

	\nn\t3::File()->isImage('image.jpg'); => returns true
	\nn\t3::File()->isImage('text.ppt'); => returns false

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
   

