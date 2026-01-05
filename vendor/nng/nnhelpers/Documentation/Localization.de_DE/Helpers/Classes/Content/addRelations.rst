
.. include:: ../../../../Includes.txt

.. _Content-addRelations:

==============================================
Content::addRelations()
==============================================

\\nn\\t3::Content()->addRelations(``$data = []``);
----------------------------------------------

Lädt Relationen (``media``, ``assets``, ...) zu einem ``tt_content``-Data-Array.
Falls ``EXT:mask`` installiert ist, wird die entsprechende Methode aus mask genutzt.

.. code-block:: php

	\nn\t3::Content()->addRelations( $data );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function addRelations($data = [])
   {
   	if (!$data) return [];
   	if (\nn\t3::Environment()->extLoaded('mask')) {
   		$maskProcessor = GeneralUtility::makeInstance(\MASK\Mask\DataProcessing\MaskProcessor::class);
   		$cObjRenderer = GeneralUtility::makeInstance(ContentObjectRenderer::class);
   		$request = $GLOBALS['TYPO3_REQUEST'] ?? new \TYPO3\CMS\Core\Http\ServerRequest();
   		$cObjRenderer->setRequest($request);
   		$dataWithRelations = $maskProcessor->process($cObjRenderer, [], [], ['data' => $data, 'current' => null]);
   		$data = $dataWithRelations['data'] ?: [];
   	} else {
   		$falFields = \nn\t3::Tca()->getFalFields('tt_content');
   		$fileRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);
   		foreach ($falFields as $field) {
   			$data[$field] = $fileRepository->findByRelation('tt_content', $field, $data['uid']);
   		}
   	}
   	return $data;
   }
   

