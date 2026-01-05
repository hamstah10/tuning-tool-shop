
.. include:: ../../../../Includes.txt

.. _File-absUrl:

==============================================
File::absUrl()
==============================================

\\nn\\t3::File()->absUrl(``$file = NULL``);
----------------------------------------------

Absolute URL zu einer Datei generieren.
Gibt den kompletten Pfad zur Datei inkl. ``https://.../`` zurück.

.. code-block:: php

	// => https://www.myweb.de/fileadmin/bild.jpg
	\nn\t3::File()->absUrl( 'fileadmin/bild.jpg' );
	\nn\t3::File()->absUrl( 'https://www.myweb.de/fileadmin/bild.jpg' );
	\nn\t3::File()->absUrl( $sysFileReference );
	\nn\t3::File()->absUrl( $falFile );

| ``@param string|\TYPO3\CMS\Core\Resource\FileReference|\TYPO3\CMS\Core\Resource\File $file``
| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function absUrl($file = null)
   {
   	if (is_object($file)) {
   		$file = $this->getPublicUrl($file);
   	}
   	if (substr($file, 0, 4) == 'EXT:') {
   		$absoluteFilePath = GeneralUtility::getFileAbsFileName($file);
   		$file = PathUtility::getAbsoluteWebPath($absoluteFilePath);
   	}
   	$baseUrl = \nn\t3::Environment()->getBaseURL();
   	$file = $this->stripPathSite($file);
   	$file = str_replace($baseUrl, '', $file);
   	return $baseUrl . ltrim($file, '/');
   }
   

