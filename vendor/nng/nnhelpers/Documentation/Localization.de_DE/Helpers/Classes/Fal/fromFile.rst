
.. include:: ../../../../Includes.txt

.. _Fal-fromFile:

==============================================
Fal::fromFile()
==============================================

\\nn\\t3::Fal()->fromFile(``$params = []``);
----------------------------------------------

Erzeugt ein FileRefence Objekt (Tabelle: ``sys_file_reference``) und verknüpft es mit einem Datensatz.
Beispiel: Hochgeladenes JPG soll als FAL an tt_news-Datensatz angehängt werden

Parameter:

key
Beschreibung

| ``src``
Pfad zur Quelldatei (kann auch http-Link zu YouTube-Video sein)

| ``dest``
Pfad zum Zielordner (optional, falls Datei verschoben/kopiert werden soll)

| ``table``
Ziel-Tabelle, dem die FileReference zugeordnet werden soll (z.B. ``tx_myext_domain_model_entry``)

| ``title``
Titel

| ``description``
Beschreibung

| ``link``
Link

| ``crop``
Beschnitt

| ``table``
Ziel-Tabelle, dem die FileReference zugeordnet werden soll (z.B. ``tx_myext_domain_model_entry``)

| ``sorting``
(int) Sortierung

| ``field``
Column-Name der Ziel-Tabelle, dem die FileReference zugeordnet werden soll (z.B. ``image``)

| ``uid``
(int) uid des Datensatzes in der Zieltabelle (``tx_myext_domain_model_entry.uid``)

| ``pid``
(int) pid des Datensatzes in der Zieltabelle

| ``cruser_id``
cruser_id des Datensatzes in der Zieltabelle

| ``copy``
src-Datei nicht verschieben sondern kopieren (default: ``true``)

| ``forceNew``
Im Zielordner neue Datei erzwingen (sonst wird geprüft, ob bereits Datei existiert) default: ``false``

| ``single``
Sicherstellen, dass gleiche FileReferenz nur 1x pro Datensatz verknüpft wird (default: ``true``)

Beispiel:

.. code-block:: php

	$fal = \nn\t3::Fal()->fromFile([
	    'src'         => 'fileadmin/test/bild.jpg',
	    'dest'            => 'fileadmin/test/fal/',
	    'pid'         => 132,
	    'uid'         => 5052,
	    'table'           => 'tx_myext_domain_model_entry',
	    'field'           => 'fallistimage'
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
   

