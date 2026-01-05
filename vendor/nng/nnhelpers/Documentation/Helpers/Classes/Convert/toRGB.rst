
.. include:: ../../../../Includes.txt

.. _Convert-toRGB:

==============================================
Convert::toRGB()
==============================================

\\nn\\t3::Convert()->toRGB();
----------------------------------------------

Converts a color value to another number format

.. code-block:: php

	\nn\t3::Convert('#ff6600')->toRGB(); // -> 255,128,0

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function toRGB() {
   	$input = $this->initialArgument;
   	$isHex = substr($input, 0, 1) == '#' || strlen($input) == 6;
   	if ($isHex) {
   		$input = str_replace('#', '', $input);
   		$rgb = sscanf($input, "%02x%02x%02x");
   		return join(',', $rgb);
   	}
   	return '';
   }
   

