
.. include:: ../../../../Includes.txt

.. _File-cleanFilename:

==============================================
File::cleanFilename()
==============================================

\\nn\\t3::File()->cleanFilename(``$filename = ''``);
----------------------------------------------

Cleans a file name

.. code-block:: php

	$clean = \nn\t3::File()->cleanFilename('fileadmin/noe_so_not.jpg'); // 'fileadmin/noe_so_not.jpg'

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function cleanFilename($filename = '')
   {
   	$path = pathinfo($filename, PATHINFO_DIRNAME) . '/';
   	$suffix = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
   	$filename = pathinfo($filename, PATHINFO_FILENAME);
   	$filename = GeneralUtility::makeInstance(CharsetConverter::class)->utf8_char_mapping($filename);
   	$cleanFilename = utf8_decode($filename);
   	$cleanFilename = strtolower(preg_replace('/[' . self::UNSAFE_FILENAME_CHARACTER_EXPRESSION . '\\xC0-\\xFF]/', '_', trim($cleanFilename)));
   	$cleanFilename = str_replace(['@'], '_', $cleanFilename);
   	if ($secondSuffix = pathinfo($cleanFilename, PATHINFO_EXTENSION)) {
   		$cleanFilename = substr($cleanFilename, 0, -strlen($secondSuffix));
   		$suffix = "{$secondSuffix}.{$suffix}";
   	}
   	$cleanFilename = preg_replace('/_+/', '_', $cleanFilename);
   	$cleanFilename = substr($cleanFilename, 0, 64 - strlen($suffix) - 1);
   	return $path . rtrim($cleanFilename, '.') . ".{$suffix}";
   }
   

