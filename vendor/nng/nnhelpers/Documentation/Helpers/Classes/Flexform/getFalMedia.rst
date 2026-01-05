
.. include:: ../../../../Includes.txt

.. _Flexform-getFalMedia:

==============================================
Flexform::getFalMedia()
==============================================

\\nn\\t3::Flexform()->getFalMedia(``$ttContentUid = NULL, $field = ''``);
----------------------------------------------

Deletes FAL media that were specified directly in the FlexForm

.. code-block:: php

	\nn\t3::Flexform()->getFalMedia( 'falmedia' );
	\nn\t3::Flexform()->getFalMedia( 'settings.falmedia' );
	\nn\t3::Flexform()->getFalMedia( 1201, 'falmedia' );

.. code-block:: php

	$cObjData = \nn\t3::Tsfe()->cObjData();
	$falMedia = \nn\t3::Flexform()->getFalMedia( $cObjData['uid'], 'falmedia' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getFalMedia( $ttContentUid = null, $field = '' )
   {
   	if (!$field && $ttContentUid) {
   		$field = $ttContentUid;
   		$ttContentUid = \nn\t3::Tsfe()->cObjData()['uid'];
   	}
   	$fileRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);
   	$fileObjects = $fileRepository->findByRelation('tt_content', $field, $ttContentUid);
   	foreach ($fileObjects as $n=>$fal) {
   		$fileObjects[$n] = \nn\t3::Convert( $fal )->toFileReference();
   	}
   	return $fileObjects;
   }
   

