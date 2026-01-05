
.. include:: ../../../../Includes.txt

.. _Fal-fileReferenceExists:

==============================================
Fal::fileReferenceExists()
==============================================

\\nn\\t3::Fal()->fileReferenceExists(``$sysFile = NULL, $params = []``);
----------------------------------------------

Prüft, ob für einen Datensatz bereits eine SysFileReference zum gleichen SysFile exisitert

.. code-block:: php

	\nn\t3::Fal()->fileReferenceExists( $sysFile, ['uid_foreign'=>123, 'tablenames'=>'tt_content', 'field'=>'media'] );

| ``@param $sysFile``
| ``@param array $params`` => uid_foreign, tablenames, fieldname
| ``@return FileReference|false``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function fileReferenceExists( $sysFile = null, $params = [] )
   {
   	$where = [
   		'uid_local' 	=> $sysFile->getUid(),
   		'uid_foreign' 	=> $params['uid'] ?? '',
   		'tablenames' 	=> $params['table'],
   		'fieldname' 	=> GeneralUtility::camelCaseToLowerCaseUnderscored($params['field']),
   	];
   	$ref = \nn\t3::Db()->findByValues( 'sys_file_reference', $where );
   	if (!$ref) return [];
   	// @returns \TYPO3\CMS\Extbase\Domain\Model\FileReference
   	return $this->persistenceManager->getObjectByIdentifier($ref[0]['uid'], \TYPO3\CMS\Extbase\Domain\Model\FileReference::class, false);
   }
   

