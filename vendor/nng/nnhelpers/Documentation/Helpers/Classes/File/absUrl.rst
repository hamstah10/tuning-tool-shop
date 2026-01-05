
.. include:: ../../../../Includes.txt

.. _File-absUrl:

==============================================
File::absUrl()
==============================================

\\nn\\t3::File()->absUrl(``$file = NULL``);
----------------------------------------------

Generate absolute URL to a file.
Returns the complete path to the file including ``https://.../``.

.. code-block:: php

	// => https://www.myweb.de/fileadmin/bild.jpg
	\nn\t3::File()->absUrl( 'fileadmin/image.jpg' );
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
   

