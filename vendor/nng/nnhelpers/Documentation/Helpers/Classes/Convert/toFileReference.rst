
.. include:: ../../../../Includes.txt

.. _Convert-toFileReference:

==============================================
Convert::toFileReference()
==============================================

\\nn\\t3::Convert()->toFileReference();
----------------------------------------------

Converts a ``\TYPO3\CMS\Core\Resource\FileReference`` (or its ``uid``)
to a ``\TYPO3\CMS\Extbase\Domain\Model\FileReference``

.. code-block:: php

	\nn\t3::Convert( $input )->toFileReference() => \TYPO3\CMS\Extbase\Domain\Model\FileReference

| ``@param $input`` Can be ``\TYPO3\CMS\Core\Resource\FileReference`` or ``uid`` thereof
| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function toFileReference() {
   	$input = $this->initialArgument;
   	if (is_a( $input, \TYPO3\CMS\Core\Resource\FileReference::class )) {
   		$falFileReference = $input;
   	} else if (is_numeric($input)) {
   		$resourceFactory = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
   		$falFileReference = $resourceFactory->getFileReferenceObject($input);
   	}
   	$sysFileReference = GeneralUtility::makeInstance( \TYPO3\CMS\Extbase\Domain\Model\FileReference::class );
   	$sysFileReference->setOriginalResource($falFileReference);
   	return $sysFileReference;
   }
   

