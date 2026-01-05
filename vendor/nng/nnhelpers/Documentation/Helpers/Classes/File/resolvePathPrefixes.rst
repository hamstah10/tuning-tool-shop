
.. include:: ../../../../Includes.txt

.. _File-resolvePathPrefixes:

==============================================
File::resolvePathPrefixes()
==============================================

\\nn\\t3::File()->resolvePathPrefixes(``$file = NULL, $absolute = false``);
----------------------------------------------

EXT: Resolve prefix to relative path specification

.. code-block:: php

	\nn\t3::File()->resolvePathPrefixes('EXT:extname'); => /typo3conf/ext/extname/
	\nn\t3::File()->resolvePathPrefixes('EXT:extname/'); => /typo3conf/ext/extname/
	\nn\t3::File()->resolvePathPrefixes('EXT:extname/image.jpg'); => /typo3conf/ext/extname/image.jpg
	\nn\t3::File()->resolvePathPrefixes('1:/uploads/image.jpg', true); => /var/www/website/fileadmin/uploads/image.jpg

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function resolvePathPrefixes($file = null, $absolute = false)
   {
   	// `1:/uploads`
   	if (preg_match('/^([0-9]*)(:\/)(.*)/i', $file, $matches)) {
   		$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
   		$storage = $resourceFactory->getStorageObject($matches[1]);
   		if (!$storage) return $file;
   		$basePath = $storage->getConfiguration()['basePath'];
   		$file = $basePath . $matches[3];
   	}
   	// `EXT:extname` => `EXT:extname/`
   	if (strpos($file, 'EXT:') == 0 && !pathinfo($file, PATHINFO_EXTENSION)) {
   		$file = rtrim($file, '/') . '/';
   	}
   	// `EXT:extname/` => `typo3conf/ext/extname/`
   	$absPathName = GeneralUtility::getFileAbsFileName($file);
   	if (!$absPathName) return $file;
   	if ($absolute) return $this->absPath($absPathName);
   	$pathSite = \nn\t3::Environment()->getPathSite();
   	return str_replace($pathSite, '', $absPathName);
   }
   

