
.. include:: ../../../../Includes.txt

.. _Fal-fromFalFile:

==============================================
Fal::fromFalFile()
==============================================

\\nn\\t3::Fal()->fromFalFile(``$sysFile = NULL``);
----------------------------------------------

Erzeugt eine sys_file_reference aus einem sys_file

.. code-block:: php

	$sysFileRef = \nn\t3::Fal()->fromFalFile( $sysFile );

| ``@param \TYPO3\CMS\Core\Resource\File $sysFile``
| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function fromFalFile( $sysFile = null )
   {
   	$fal = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
   	$falFile = new \TYPO3\CMS\Core\Resource\FileReference([
   		'uid_local' => $sysFile->getUid(),
   		'uid_foreign' => 0,
   		'tablenames' => '',
   		'uid' => null,
   	]);
   	$fal->setOriginalResource( $falFile );
   	return $fal;
   }
   

