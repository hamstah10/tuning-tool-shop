
.. include:: ../../../../Includes.txt

.. _File-type:

==============================================
File::type()
==============================================

\\nn\\t3::File()->type(``$filename = NULL``);
----------------------------------------------

Returns the type of file based on the file suffix

.. code-block:: php

	\nn\t3::File()->type('image.jpg'); => returns 'image'
	\nn\t3::File()->type('text.doc'); => returns 'document'

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
   

