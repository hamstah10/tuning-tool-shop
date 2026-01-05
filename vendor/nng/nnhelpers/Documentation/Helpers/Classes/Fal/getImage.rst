
.. include:: ../../../../Includes.txt

.. _Fal-getImage:

==============================================
Fal::getImage()
==============================================

\\nn\\t3::Fal()->getImage(``$src = NULL``);
----------------------------------------------

Retrieves / converts to a \TYPO3\CMS\Core\Resource\FileReference object (sys_file_reference)
"Smart" variant of ``\TYPO3\CMS\Extbase\Service\ImageService->getImage()``

.. code-block:: php

	\nn\t3::Fal()->getImage( 1 );
	\nn\t3::Fal()->getImage( 'path/to/image.jpg' );
	\nn\t3::Fal()->getImage( $fileReference );

| ``@param string|\TYPO3\CMS\Extbase\Domain\Model\FileReference $src``
| ``@return \TYPO3\CMS\Core\Resource\FileReference|boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getImage ( $src = null )
   {
   	if (!$src) return null;
   	$imageService = \nn\t3::injectClass( ImageService::class );
   	$treatIdAsReference = is_numeric($src);
   	if (is_string($src) || $treatIdAsReference) {
   		return $imageService->getImage( $src, null, $treatIdAsReference );
   	}
   	return $imageService->getImage( '', $src, false );
   }
   

