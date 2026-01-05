
.. include:: ../../../../Includes.txt

.. _Fal-fromFile:

==============================================
Fal::fromFile()
==============================================

\\nn\\t3::Fal()->fromFile(``$params = []``);
----------------------------------------------

Creates a FileRefence object (table: ``sys_file_reference``) and links it to a data set.
Example: Uploaded JPG is to be attached to tt_news dataset as FAL

Parameters:

key
Description: src

| ``src``
Path to the source file (can also be http link to YouTube video)

| ``dest``
Path to the destination folder (optional if file is to be moved/copied)

| ``table``
Target table to which the FileReference is to be assigned (e.g. ``tx_myext_domain_model_entry``)

| ``title``
title

| ``description``
description

| ``link``
link

| ``crop``
crop

| ``table``
Target table to which the FileReference is to be assigned (e.g. ``tx_myext_domain_model_entry``)

| ``sorting``
(int) Sorting

| ``field``
Column name of the target table to which the FileReference is to be assigned (e.g. ``image``)

| ``uid``
(int) uid of the data record in the target table``(tx_myext_domain_model_entry.uid``)

| ``pid``
(int) pid of the data record in the target table

| ``cruser_id``
cruser_id of the data record in the target table

| ``copy``
Do not move src file but copy it (default: ``true``)

| ``forceNew``
Force new file in target folder (otherwise it is checked whether file already exists) default: ``false``

| ``single``
Ensure that the same FileReference is only linked once per data record (default: ``true``)

Example:

.. code-block:: php

	$fal = \nn\t3::Fal()->fromFile([
	    'src' => 'fileadmin/test/image.jpg',
	    'dest' => 'fileadmin/test/fal/',
	    'pid' => 132,
	    'uid' => 5052,
	    'table' => 'tx_myext_domain_model_entry',
	    'field' => 'fallistimage'
	]);

| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function fromFile ( $params = [] )
   {
   	$params = \nn\t3::Arrays([
   		'dest'		=> '',
   		'forceNew'	=> false,
   		'copy'		=> true,
   		'single'	=> true,
   	])->merge( $params );
   	$fileReferenceRepository = \nn\t3::injectClass( FileReferenceRepository::class );
   	$newFile = $this->createFalFile( $params['dest'], $params['src'], $params['copy'], $params['forceNew'] );
   	if (!$newFile) return false;
   	if ($params['single']) {
   		if ($fileReferenceExists = $this->fileReferenceExists( $newFile, $params )) {
   			return $fileReferenceExists;
   		}
   	}
   	$fieldname = GeneralUtility::camelCaseToLowerCaseUnderscored($params['field']);
   	$entry = [
   		'fieldname' 		=> $fieldname,
   		'tablenames' 		=> $params['table'],
   		'table_local' 		=> 'sys_file',
   		'uid_local' 		=> $newFile->getUid(),
   		'uid_foreign' 		=> 0,
   		'sorting_foreign' 	=> $params['sorting_foreign'] ?? $params['sorting'] ?? time(),
   		'pid' 				=> $params['pid'] ?? 0,
   		'description' 		=> $params['description'] ?? null,
   		'title' 			=> $params['title'] ?? null,
   		'link' 				=> $params['link'] ?? '',
   		'crop' 				=> $params['crop'] ?? '',
   		'tstamp'			=> time(),
   		'crdate'			=> time(),
   	];
   	if ($uid = $params['uid'] ?? null) {
   		$entry['uid_foreign'] = $uid;
   	}
   	$entry = \nn\t3::Db()->insert('sys_file_reference', $entry);
   	// @returns \TYPO3\CMS\Extbase\Domain\Model\FileReference
   	$persistenceManager = \nn\t3::injectClass(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
   	return $persistenceManager->getObjectByIdentifier($entry['uid'], \TYPO3\CMS\Extbase\Domain\Model\FileReference::class, false);
   }
   

