
.. include:: ../../../../Includes.txt

.. _File-getImageData:

==============================================
File::getImageData()
==============================================

\\nn\\t3::File()->getImageData(``$filename = ''``);
----------------------------------------------

Get EXIF image data for file.

.. code-block:: php

	\nn\t3::File()->getImageData( 'yellowstone.jpg' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getImageData($filename = '')
   {
   	if (!function_exists('exif_read_data')) return [];
   	$exif = @\exif_read_data($filename);
   	if (!$exif) return [];
   	$orientation = $exif['Orientation'];
   	$imageProcessingMap = array(
   		'r2' => '-flop',
   		'r3' => '-flop -flip',
   		'r4' => '-rotate 180 -flop',
   		'r5' => '-flop -rotate 270',
   		'r6' => '-rotate 90',
   		'r7' => '-flop -rotate 90',
   		'r8' => '-rotate 270',
   	);
   	return [
   		'orient' => $orientation,
   		'time' => $exif['FileDateTime'],
   		'type' => $exif['FileType'],
   		'im' => $imageProcessingMap['r' . $orientation] ?? false,
   	];
   }
   

