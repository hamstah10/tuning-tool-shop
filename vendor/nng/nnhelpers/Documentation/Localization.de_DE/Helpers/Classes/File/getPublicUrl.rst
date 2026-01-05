
.. include:: ../../../../Includes.txt

.. _File-getPublicUrl:

==============================================
File::getPublicUrl()
==============================================

\\nn\\t3::File()->getPublicUrl(``$obj = NULL, $absolute = false``);
----------------------------------------------

Holt Pfad zur Datei, relativ zum Typo3-Installtionsverzeichnis (PATH_site).
Kann mit allen Arten von Objekten umgehen.

.. code-block:: php

	\nn\t3::File()->getPublicUrl( $falFile );        // \TYPO3\CMS\Core\Resource\FileReference
	\nn\t3::File()->getPublicUrl( $fileReference );  // \TYPO3\CMS\Extbase\Domain\Model\FileReference
	\nn\t3::File()->getPublicUrl( $folder );         // \TYPO3\CMS\Core\Resource\Folder
	\nn\t3::File()->getPublicUrl( $folder, true );   // https://.../fileadmin/bild.jpg

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getPublicUrl($obj = null, $absolute = false)
   {
   	$url = false;
   	if (is_string($obj)) {
   		$url = $obj;
   	} else if (\nn\t3::Obj()->isFalFile($obj) || \nn\t3::Obj()->isFile($obj)) {
   		$url = $obj->getPublicUrl();
   	} else if (\nn\t3::Obj()->isFileReference($obj)) {
   		$url = $obj->getOriginalResource()->getPublicUrl();
   	} else if (is_array($obj) && $url = ($obj['publicUrl'] ?? false)) {
   		// $url kann genutzt werden!
   	} else if (is_a($obj, \TYPO3\CMS\Core\Resource\Folder::class, true)) {
   		$url = $obj->getPublicUrl();
   	}
   	$url = ltrim($url, '/');
   	return !$absolute ? $url : $this->absUrl($url);
   }
   

