
.. include:: ../../../Includes.txt

.. _Convert:

==============================================
Convert
==============================================

\\nn\\t3::Convert()
----------------------------------------------

Konvertieren von Arrays zu Models, Models zu JSONs, Arrays zu ObjectStorages,
Hex-Farben zu RGB und vieles mehr, was irgendwie mit Konvertieren von Dingen
zu tun hat.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Convert()->toArray(``$obj = NULL, $depth = 3``);
"""""""""""""""""""""""""""""""""""""""""""""""

Konvertiert ein Model in ein Array
Alias zu \nn\t3::Obj()->toArray();

Bei Memory-Problemen wegen Rekursionen: Max-Tiefe angebenen!

.. code-block:: php

	\nn\t3::Convert($model)->toArray(2);
	\nn\t3::Convert($model)->toArray();      => ['uid'=>1, 'title'=>'Beispiel', ...]

| ``@return array``

| :ref:`➜ Go to source code of Convert::toArray() <Convert-toArray>`

\\nn\\t3::Convert()->toBytes();
"""""""""""""""""""""""""""""""""""""""""""""""

Konvertiert eine für Menschen lesbare Angabe von Bytes/Megabytes in einen Byte-Integer.
Extrem tolerant, was Leerzeichen, Groß/Klein-Schreibung und Kommas statt Punkten angeht.

.. code-block:: php

	\nn\t3::Convert('1M')->toBytes();  // -> 1048576
	\nn\t3::Convert('1 MB')->toBytes();    // -> 1048576
	\nn\t3::Convert('1kb')->toBytes(); // -> 1024
	\nn\t3::Convert('1,5kb')->toBytes();   // -> 1024
	\nn\t3::Convert('1.5Gb')->toBytes();   // -> 1610612736

Für den umgekehrten Weg (Bytes zu menschenlesbarer Schreibweise wie 1024 -> 1kb) gibt
es einen praktischen Fluid ViewHelper im Core:

.. code-block:: php

	{fileSize->f:format.bytes()}

| ``@return integer``

| :ref:`➜ Go to source code of Convert::toBytes() <Convert-toBytes>`

\\nn\\t3::Convert()->toFileReference();
"""""""""""""""""""""""""""""""""""""""""""""""

Konvertiert ein ``\TYPO3\CMS\Core\Resource\FileReference`` (oder seine ``uid``)
in eine ``\TYPO3\CMS\Extbase\Domain\Model\FileReference``

.. code-block:: php

	\nn\t3::Convert( $input )->toFileReference() => \TYPO3\CMS\Extbase\Domain\Model\FileReference

| ``@param $input`` Kann ``\TYPO3\CMS\Core\Resource\FileReference`` oder ``uid`` davon sein
| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``

| :ref:`➜ Go to source code of Convert::toFileReference() <Convert-toFileReference>`

\\nn\\t3::Convert()->toIso();
"""""""""""""""""""""""""""""""""""""""""""""""

Konvertiert (normalisiert) einen String zu ISO-8859-1

.. code-block:: php

	\nn\t3::Convert('äöü')->toIso();

| ``@return string``

| :ref:`➜ Go to source code of Convert::toIso() <Convert-toIso>`

\\nn\\t3::Convert()->toJson(``$obj = NULL, $depth = 3``);
"""""""""""""""""""""""""""""""""""""""""""""""

Konvertiert ein Model in ein JSON

.. code-block:: php

	\nn\t3::Convert($model)->toJson()        => ['uid'=>1, 'title'=>'Beispiel', ...]

| ``@return array``

| :ref:`➜ Go to source code of Convert::toJson() <Convert-toJson>`

\\nn\\t3::Convert()->toLanguage(``$sysLanguageUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Konvertiert eine Sprach-ID (z.B. '0', '1') in das zweistellige
Sprachkürzel (z.B. 'de', 'en')

.. code-block:: php

	// Sprach-ID 0 -> 'de'
	\nn\t3::Convert(0)->toLanguage();

| ``@param int $sysLanguageUid``
| ``@return string``

| :ref:`➜ Go to source code of Convert::toLanguage() <Convert-toLanguage>`

\\nn\\t3::Convert()->toLanguageId(``$languageCode = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Konvertiert ein zweistelliges Sprachkürzel (z.B. 'de', 'en')
in die Sprach-ID (z.B. '0', '1')

.. code-block:: php

	// Sprach-ID 0 -> 'de'
	\nn\t3::Convert('de')->toLanguageId();

| ``@param int $sysLanguageUid``
| ``@return string``

| :ref:`➜ Go to source code of Convert::toLanguageId() <Convert-toLanguageId>`

\\nn\\t3::Convert()->toModel(``$className = NULL, $parentModel = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Konvertiert ein Array in ein Model.

.. code-block:: php

	\nn\t3::Convert($array)->toModel( \Nng\Model\Name::class )       => \Nng\Model\Name

Kann auch automatisch FileReferences erzeugen.
In diesem Bespiel wird ein neues Model des Typs ``\Nng\Model\Name`` erzeugt und
danach in der Datenbank persistiert. Das Feld ``falMedia`` ist eine ObjectStorage
mit ``FileReferences``. Die FileReferences werden automatisch erzeugt!

.. code-block:: php

	$data = [
	    'pid' => 6,
	    'title' => 'Neuer Datensatz',
	    'description' => 'Der Text',
	    'falMedia' => [
	        ['title'=>'Bild 1', 'publicUrl'=>'fileadmin/_tests/5e505e6b6143a.jpg'],
	        ['title'=>'Bild 2', 'publicUrl'=>'fileadmin/_tests/5e505fbf5d3dd.jpg'],
	        ['title'=>'Bild 3', 'publicUrl'=>'fileadmin/_tests/5e505f435061e.jpg'],
	    ]
	];
	$newModel = \nn\t3::Convert( $data )->toModel( \Nng\Model\Name::class );
	$modelRepository->add( $newModel );
	\nn\t3::Db()->persistAll();

Beispiel: Aus einem Array einen News-Model erzeugen:

.. code-block:: php

	$entry = [
	    'pid'             => 12,
	    'title'           => 'News-Titel',
	    'description' => '<p>Meine News</p>',
	    'falMedia'        => [['publicUrl' => 'fileadmin/bild.jpg', 'title'=>'Bild'], ...],
	    'categories'  => [1, 2]
	];
	$model = \nn\t3::Convert( $entry )->toModel( \GeorgRinger\News\Domain\Model\News::class );
	$newsRepository->add( $model );
	\nn\t3::Db()->persistAll();

Hinweis
Um ein bereits existierendes Model mit Daten aus einem Array zu aktualisieren gibt
es die Methode ``$updatedModel = \nn\t3::Obj( $prevModel )->merge( $data );``

| ``@return mixed``

| :ref:`➜ Go to source code of Convert::toModel() <Convert-toModel>`

\\nn\\t3::Convert()->toObjectStorage(``$obj = NULL, $childType = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Konvertiert etwas in eine ObjectStorage

.. code-block:: php

	\nn\t3::Convert($something)->toObjectStorage()
	\nn\t3::Convert($something)->toObjectStorage( \My\Child\Type::class )
	
	\nn\t3::Convert()->toObjectStorage([['uid'=>1], ['uid'=>2], ...], \My\Child\Type::class )
	\nn\t3::Convert()->toObjectStorage([1, 2, ...], \My\Child\Type::class )

| ``@return ObjectStorage``

| :ref:`➜ Go to source code of Convert::toObjectStorage() <Convert-toObjectStorage>`

\\nn\\t3::Convert()->toRGB();
"""""""""""""""""""""""""""""""""""""""""""""""

Konvertiert einen Farbwert in ein anderes Zahlenformat

.. code-block:: php

	\nn\t3::Convert('#ff6600')->toRGB();   // -> 255,128,0

| ``@return string``

| :ref:`➜ Go to source code of Convert::toRGB() <Convert-toRGB>`

\\nn\\t3::Convert()->toSysCategories();
"""""""""""""""""""""""""""""""""""""""""""""""

Konvertiert eine Liste in eine ``ObjectStorage`` mit ``SysCategory``

.. code-block:: php

	Noch nicht implementiert!

| ``@return ObjectStorage``

| :ref:`➜ Go to source code of Convert::toSysCategories() <Convert-toSysCategories>`

\\nn\\t3::Convert()->toUTF8();
"""""""""""""""""""""""""""""""""""""""""""""""

Konvertiert (normalisiert) einen String zu UTF-8

.. code-block:: php

	\nn\t3::Convert('äöü')->toUTF8();

| ``@return string``

| :ref:`➜ Go to source code of Convert::toUTF8() <Convert-toUTF8>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
