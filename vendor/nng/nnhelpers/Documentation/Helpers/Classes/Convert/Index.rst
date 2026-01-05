
.. include:: ../../../Includes.txt

.. _Convert:

==============================================
Convert
==============================================

\\nn\\t3::Convert()
----------------------------------------------

Converting arrays to models, models to JSONs, arrays to ObjectStorages,
hex colors to RGB and much more that somehow has to do with converting things.
has to do with converting things.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Convert()->toArray(``$obj = NULL, $depth = 3``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a model into an array
Alias to \nn\t3::Obj()->toArray();

For memory problems due to recursion: Specify max depth!

.. code-block:: php

	\nn\t3::Convert($model)->toArray(2);
	\nn\t3::Convert($model)->toArray(); => ['uid'=>1, 'title'=>'Example', ...]

| ``@return array``

| :ref:`➜ Go to source code of Convert::toArray() <Convert-toArray>`

\\nn\\t3::Convert()->toBytes();
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a human-readable specification of bytes/megabytes into a byte integer.
Extremely tolerant when it comes to spaces, upper/lower case and commas instead of periods.

.. code-block:: php

	\nn\t3::Convert('1M')->toBytes(); // -> 1048576
	\nn\t3::Convert('1 MB')->toBytes(); // -> 1048576
	\nn\t3::Convert('1kb')->toBytes(); // -> 1024
	\nn\t3::Convert('1.5kb')->toBytes(); // -> 1024
	\nn\t3::Convert('1.5Gb')->toBytes(); // -> 1610612736

For the reverse path (bytes to human-readable notation such as 1024 -> 1kb) there is a practical
there is a practical Fluid ViewHelper in the core:

.. code-block:: php

	{fileSize->f:format.bytes()}

| ``@return integer``

| :ref:`➜ Go to source code of Convert::toBytes() <Convert-toBytes>`

\\nn\\t3::Convert()->toFileReference();
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a ``\TYPO3\CMS\Core\Resource\FileReference`` (or its ``uid``)
to a ``\TYPO3\CMS\Extbase\Domain\Model\FileReference``

.. code-block:: php

	\nn\t3::Convert( $input )->toFileReference() => \TYPO3\CMS\Extbase\Domain\Model\FileReference

| ``@param $input`` Can be ``\TYPO3\CMS\Core\Resource\FileReference`` or ``uid`` thereof
| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``

| :ref:`➜ Go to source code of Convert::toFileReference() <Convert-toFileReference>`

\\nn\\t3::Convert()->toIso();
"""""""""""""""""""""""""""""""""""""""""""""""

Converts (normalizes) a string to ISO-8859-1

.. code-block:: php

	\nn\t3::Convert('ÃÃÃ')->toIso();

| ``@return string``

| :ref:`➜ Go to source code of Convert::toIso() <Convert-toIso>`

\\nn\\t3::Convert()->toJson(``$obj = NULL, $depth = 3``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a model into a JSON

.. code-block:: php

	\nn\t3::Convert($model)->toJson() => ['uid'=>1, 'title'=>'Example', ...]

| ``@return array``

| :ref:`➜ Go to source code of Convert::toJson() <Convert-toJson>`

\\nn\\t3::Convert()->toLanguage(``$sysLanguageUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a language ID (e.g. '0', '1') into the two-character
language abbreviation (e.g. 'de', 'en')

.. code-block:: php

	// Language ID 0 -> 'de'
	\nn\t3::Convert(0)->toLanguage();

| ``@param int $sysLanguageUid``
| ``@return string``

| :ref:`➜ Go to source code of Convert::toLanguage() <Convert-toLanguage>`

\\nn\\t3::Convert()->toLanguageId(``$languageCode = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a two-character language abbreviation (e.g. 'de', 'en')
into the language ID (e.g. '0', '1')

.. code-block:: php

	// Language ID 0 -> 'de'
	\nn\t3::Convert('de')->toLanguageId();

| ``@param int $sysLanguageUid``
| ``@return string``

| :ref:`➜ Go to source code of Convert::toLanguageId() <Convert-toLanguageId>`

\\nn\\t3::Convert()->toModel(``$className = NULL, $parentModel = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts an array into a model.

.. code-block:: php

	\nn\t3::Convert($array)->toModel( \Nng\Model\Name::class ) => \Nng\Model\Name

Can also automatically generate FileReferences.
In this example, a new model of the type ``\Nng\Model\Name`` is created and then
then persisted in the database. The ``falMedia`` field is an ObjectStorage
with ``FileReferences``. The FileReferences are created automatically!

.. code-block:: php

	$data = [
	    'pid' => 6,
	    'title' => 'New data record',
	    'description' => 'The text',
	    'falMedia' => [
	        ['title'=>'Image 1', 'publicUrl'=>'fileadmin/_tests/5e505e6b6143a.jpg'],
	        ['title'=>'Image 2', 'publicUrl'=>'fileadmin/_tests/5e505fbf5d3dd.jpg'],
	        ['title'=>'Image 3', 'publicUrl'=>'fileadmin/_tests/5e505f435061e.jpg'],
	    ]
	];
	$newModel = \nn\t3::Convert( $data )->toModel( \Nng\Model\Name::class );
	$modelRepository->add( $newModel );
	\nn\t3::Db()->persistAll();

Example: Create a news model from an array:

.. code-block:: php

	$entry = [
	    'pid' => 12,
	    'title' => 'News title',
	    'description' =>'My news',
	    'falMedia' => [['publicUrl' => 'fileadmin/image.jpg', 'title'=>'Image'], ...],
	    'categories' => [1, 2]
	];
	$model = \nn\t3::Convert( $entry )->toModel( \GeorgRinger\News\Domain\Model\News::class );
	$newsRepository->add( $model );
	\nn\t3::Db()->persistAll();

Hint
To update an existing model with data from an array, there is the method
there is the method ``$updatedModel = \nn\t3::Obj( $prevModel )->merge( $data );``

| ``@return mixed``

| :ref:`➜ Go to source code of Convert::toModel() <Convert-toModel>`

\\nn\\t3::Convert()->toObjectStorage(``$obj = NULL, $childType = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts something into an ObjectStorage

.. code-block:: php

	\nn\t3::Convert($something)->toObjectStorage()
	\nn\t3::Convert($something)->toObjectStorage( \My\Child\Type::class )
	
	\nn\t3::Convert()->toObjectStorage([['uid'=>1], ['uid'=>2], ...], \My\Child\Type::class )
	\nn\t3::Convert()->toObjectStorage([1, 2, ...], \My\Child\Type::class )

| ``@return ObjectStorage``

| :ref:`➜ Go to source code of Convert::toObjectStorage() <Convert-toObjectStorage>`

\\nn\\t3::Convert()->toRGB();
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a color value to another number format

.. code-block:: php

	\nn\t3::Convert('#ff6600')->toRGB(); // -> 255,128,0

| ``@return string``

| :ref:`➜ Go to source code of Convert::toRGB() <Convert-toRGB>`

\\nn\\t3::Convert()->toSysCategories();
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a list into an ``ObjectStorage`` with ``SysCategory``

.. code-block:: php

	Not yet implemented!

| ``@return ObjectStorage``

| :ref:`➜ Go to source code of Convert::toSysCategories() <Convert-toSysCategories>`

\\nn\\t3::Convert()->toUTF8();
"""""""""""""""""""""""""""""""""""""""""""""""

Converts (normalizes) a string to UTF-8

.. code-block:: php

	\nn\t3::Convert('ÃÃÃ')->toUTF8();

| ``@return string``

| :ref:`➜ Go to source code of Convert::toUTF8() <Convert-toUTF8>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
