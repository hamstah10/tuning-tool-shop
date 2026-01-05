
.. include:: ../../../../Includes.txt

.. _File-getImageSize:

==============================================
File::getImageSize()
==============================================

\\nn\\t3::File()->getImageSize(``$filename = ''``);
----------------------------------------------

imagesize für Datei holen.

.. code-block:: php

	\nn\t3::File()->getImageSize( 'yellowstone.jpg' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getImageSize($filename = '')
   {
   	if (!file_exists($filename)) return [];
   	$imageinfo = getimagesize($filename);
   	return [
   		'width' => $imageinfo[0],
   		'height' => $imageinfo[1],
   		'mime' => $imageinfo['mime'],
   	];
   }
   

