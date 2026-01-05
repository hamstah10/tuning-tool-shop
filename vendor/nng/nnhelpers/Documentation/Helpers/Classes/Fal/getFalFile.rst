
.. include:: ../../../../Includes.txt

.. _Fal-getFalFile:

==============================================
Fal::getFalFile()
==============================================

\\nn\\t3::Fal()->getFalFile(``$srcFile``);
----------------------------------------------

Retrieves a \File (FAL) object``(sys_file``)

.. code-block:: php

	\nn\t3::Fal()->getFalFile( 'fileadmin/image.jpg' );

| ``@param string $srcFile``
| ``@return \TYPO3\CMS\Core\Resource\File|boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getFalFile ( $srcFile )
   {
   	try {
   		$srcFile = \nn\t3::File()->stripPathSite( $srcFile );
   		$storage = \nn\t3::File()->getStorage( $srcFile, true );
   		if (!$storage) return false;
   		// \TYPO3\CMS\Core\Resource\File
   		$storageBasePath = $storage->getConfiguration()['basePath'];
   		$file = $storage->getFile( substr( $srcFile, strlen($storageBasePath) ) );
   		return $file;
   	} catch( \Exception $e ) {
   		return false;
   	}
   }
   

