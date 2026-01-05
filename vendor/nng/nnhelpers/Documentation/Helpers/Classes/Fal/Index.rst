
.. include:: ../../../Includes.txt

.. _Fal:

==============================================
Fal
==============================================

\\nn\\t3::Fal()
----------------------------------------------

Methods for creating sysFile and sysFileReference entries.

Cheat sheet:

.. code-block:: php

	\TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage
	 |
	 Ã¢Ã¢ \TYPO3\CMS\Extbase\Domain\Model\FileReference
	        ... getOriginalResource()
	                |
	                Ã¢Ã¢ \TYPO3\CMS\Core\Resource\FileReference
	                    ... getOriginalFile()
	                            |
	                            Ã¢Ã¢ \TYPO3\CMS\Core\Resource\File

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Fal()->attach(``$model, $field, $itemData = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert a file to a FileReference object and
to the Property or ObjectStorage of a model.
See also: ``\nn\t3::Fal()->setInModel( $member, 'falslideshow', $imagesToSet );`` with the
array of multiple images can be attached to an ObjectStorage.

.. code-block:: php

	\nn\t3::Fal()->attach( $model, $fieldName, $filePath );
	\nn\t3::Fal()->attach( $model, 'image', 'fileadmin/user_uploads/image.jpg' );
	\nn\t3::Fal()->attach( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg'] );
	\nn\t3::Fal()->attach( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg', 'title'=>'Title...'] );

| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference|array``

| :ref:`➜ Go to source code of Fal::attach() <Fal-attach>`

\\nn\\t3::Fal()->clearCache(``$filenameOrSysFile = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes the cache for the image sizes of a FAL including the converted images
If, for example, the f:image-ViewHelper is used, all calculated image sizes are
are saved in the sys_file_processedfile table. If the original image changes,
an image from the cache may still be accessed.

.. code-block:: php

	\nn\t3::Fal()->clearCache( 'fileadmin/file.jpg' );
	\nn\t3::Fal()->clearCache( $fileReference );
	\nn\t3::Fal()->clearCache( $falFile );

| ``@param $filenameOrSysFile`` FAL or path (string) to the file
| ``@return void``

| :ref:`➜ Go to source code of Fal::clearCache() <Fal-clearCache>`

\\nn\\t3::Fal()->createFalFile(``$storageConfig, $srcFile, $keepSrcFile = false, $forceCreateNew = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Creates a \File (FAL) object (sys_file)

\nn\t3::Fal()->createFalFile( $storageConfig, $srcFile, $keepSrcFile, $forceCreateNew );

| ``@param string $storageConfig`` Path/folder in which the FAL file is to be saved (e.g. 'fileadmin/projectdata/')
| ``@param string $srcFile`` Source file to be converted to FAL (e.g. 'uploads/tx_nnfesubmit/example.jpg')
Can also be URL to YouTube/Vimeo video (e.g. https://www. youtube.com/watch?v=7Bb5jXhwnRY)
| ``@param boolean $keepSrcFile`` Copy source file only, do not move?
| ``@param boolean $forceCreateNew`` Should a new file always be created? If not, it may return an existing file object

| ``@return \Nng\Nnhelpers\Domain\Model\File|\TYPO3\CMS\Core\Resource\File|boolean``

| :ref:`➜ Go to source code of Fal::createFalFile() <Fal-createFalFile>`

\\nn\\t3::Fal()->createForModel(``$model, $field, $itemData = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert a file to a FileReference object and prepare it for ``attach()`` to an existing
model and field / property. The FileReference is not automatically
attached to the model. To set the FAL directly in the model, the helper
| ``\nn\t3::Fal()->attach( $model, $field, $itemData )`` can be used.

.. code-block:: php

	\nn\t3::Fal()->createForModel( $model, $fieldName, $filePath );
	\nn\t3::Fal()->createForModel( $model, 'image', 'fileadmin/user_uploads/image.jpg' );
	\nn\t3::Fal()->createForModel( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg'] );
	\nn\t3::Fal()->createForModel( $model, 'image', ['publicUrl'=>'fileadmin/user_uploads/image.jpg', 'title'=>'Title...'] );

| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``

| :ref:`➜ Go to source code of Fal::createForModel() <Fal-createForModel>`

\\nn\\t3::Fal()->createSysFile(``$file, $autoCreateStorage = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Creates new entry in ``sys_file``
Searches all ``sys_file_storage entries`` to see whether the path to the $file already exists as storage.
If not, a new storage is created.

.. code-block:: php

	\nn\t3::Fal()->createSysFile( 'fileadmin/image.jpg' );
	\nn\t3::Fal()->createSysFile( '/var/www/mysite/fileadmin/image.jpg' );

| ``@return false|\TYPO3\CMS\Core\Resource\File``

| :ref:`➜ Go to source code of Fal::createSysFile() <Fal-createSysFile>`

\\nn\\t3::Fal()->deleteForModel(``$model, $field = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes the physical files for a model (or a single field of the
field of the model) from the server.

.. code-block:: php

	// Delete ALL files of the entire model
	\nn\t3::Fal()->deleteForModel( $model );
	
	// Delete ALL files from the "images" field
	\nn\t3::Fal()->deleteForModel( $model, 'images' );

| ``@param \TYPO3\CMS\Extbase\DomainObject\AbstractEntity $model``
| ``@param string $field``
| ``@return void``

| :ref:`➜ Go to source code of Fal::deleteForModel() <Fal-deleteForModel>`

\\nn\\t3::Fal()->deleteProcessedImages(``$sysFile = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes all physical thumbnail files that were generated for an image incl.
the data records in the ``sys_file_processedfile`` table.

The original image, which was passed as the ``$path`` argument, is not deleted.
The whole process forces the thumbnails for an image to be regenerated if, for example, the
source image has changed but the file name has remained the same.

Another use case: Cleaning up files on the server, e.g. because sensitive, personal data is to be
data including all generated thumbnails should be deleted.

.. code-block:: php

	\nn\t3::Fal()->deleteProcessedImages( 'fileadmin/path/example.jpg' );
	\nn\t3::Fal()->deleteProcessedImages( $sysFileReference );
	\nn\t3::Fal()->deleteProcessedImages( $sysFile );

| ``@return mixed``

| :ref:`➜ Go to source code of Fal::deleteProcessedImages() <Fal-deleteProcessedImages>`

\\nn\\t3::Fal()->deleteSysFile(``$uidOrObject = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes a SysFile (data record from table ``sys_file``) and all associated SysFileReferences.
A radical way to completely remove an image from the Typo3 indexing.

The physical file is not deleted from the server!
See ``\nn\t3::File()->unlink()`` to delete the physical file.
See ``\nn\t3::Fal()->detach( $model, $field );`` to delete from a model.

.. code-block:: php

	\nn\t3::Fal()->deleteSysFile( 1201 );
	\nn\t3::Fal()->deleteSysFile( 'fileadmin/path/to/image.jpg' );
	\nn\t3::Fal()->deleteSysFile( \TYPO3\CMS\Core\Resource\File );
	\nn\t3::Fal()->deleteSysFile( \TYPO3\CMS\Core\Resource\FileReference );

| ``@param $uidOrObject``

| ``@return integer``

| :ref:`➜ Go to source code of Fal::deleteSysFile() <Fal-deleteSysFile>`

\\nn\\t3::Fal()->deleteSysFileReference(``$uidOrFileReference = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes a SysFileReference.
See also ``\nn\t3::Fal()->detach( $model, $field );`` for deleting from a model.

.. code-block:: php

	\nn\t3::Fal()->deleteSysFileReference( 112 );
	\nn\t3::Fal()->deleteSysFileReference( \TYPO3\CMS\Extbase\Domain\Model\FileReference );

| ``@param $uidOrFileReference``

| ``@return mixed``

| :ref:`➜ Go to source code of Fal::deleteSysFileReference() <Fal-deleteSysFileReference>`

\\nn\\t3::Fal()->detach(``$model, $field, $obj = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Empties an ObjectStorage in a model or removes a single
individual object from the model or an ObjectStorage.
In the example, ``image`` can be an ObjectStorage or a single ``FileReference``:

.. code-block:: php

	\nn\t3::Fal()->detach( $model, 'image' );
	\nn\t3::Fal()->detach( $model, 'image', $singleObjToRemove );

| ``@return void``

| :ref:`➜ Go to source code of Fal::detach() <Fal-detach>`

\\nn\\t3::Fal()->fileReferenceExists(``$sysFile = NULL, $params = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Checks whether a SysFileReference to the same SysFile already exists for a data record

.. code-block:: php

	\nn\t3::Fal()->fileReferenceExists( $sysFile, ['uid_foreign'=>123, 'tablenames'=>'tt_content', 'field'=>'media'] );

| ``@param $sysFile``
| ``@param array $params`` => uid_foreign, tablenames, fieldname
| ``@return FileReference|false``

| :ref:`➜ Go to source code of Fal::fileReferenceExists() <Fal-fileReferenceExists>`

\\nn\\t3::Fal()->fromFalFile(``$sysFile = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Creates a sys_file_reference from a sys_file

.. code-block:: php

	$sysFileRef = \nn\t3::Fal()->fromFalFile( $sysFile );

| ``@param \TYPO3\CMS\Core\Resource\File $sysFile``
| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``

| :ref:`➜ Go to source code of Fal::fromFalFile() <Fal-fromFalFile>`

\\nn\\t3::Fal()->fromFile(``$params = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

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

| :ref:`➜ Go to source code of Fal::fromFile() <Fal-fromFile>`

\\nn\\t3::Fal()->getFalFile(``$srcFile``);
"""""""""""""""""""""""""""""""""""""""""""""""

Retrieves a \File (FAL) object``(sys_file``)

.. code-block:: php

	\nn\t3::Fal()->getFalFile( 'fileadmin/image.jpg' );

| ``@param string $srcFile``
| ``@return \TYPO3\CMS\Core\Resource\File|boolean``

| :ref:`➜ Go to source code of Fal::getFalFile() <Fal-getFalFile>`

\\nn\\t3::Fal()->getFileObjectFromCombinedIdentifier(``$file = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Retrieves a SysFile from the CombinedIdentifier notation ('1:/uploads/example.txt').
If file does not exist, FALSE is returned.

.. code-block:: php

	\nn\t3::Fal()->getFileObjectFromCombinedIdentifier( '1:/uploads/example.txt' );

| ``@param string $file`` Combined Identifier ('1:/uploads/example.txt')
| ``@return File|boolean``

| :ref:`➜ Go to source code of Fal::getFileObjectFromCombinedIdentifier() <Fal-getFileObjectFromCombinedIdentifier>`

\\nn\\t3::Fal()->getFilePath(``$falReference``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the URL to a FileReference or a FalFile.
Alias to ``\nn\t3::File()->getPublicUrl()``.

.. code-block:: php

	\nn\t3::Fal()->getFilePath( $fileReference ); // results in e.g. 'fileadmin/bilder/01.jpg'

| ``@param \TYPO3\CMS\Extbase\Domain\Model\FileReference|\TYPO3\CMS\Core\Resource\FileReference $falReference``
| ``@return string``

| :ref:`➜ Go to source code of Fal::getFilePath() <Fal-getFilePath>`

\\nn\\t3::Fal()->getFileReferenceByUid(``$uid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Retrieves a SysFileReference based on the uid
Alias to ``\nn\t3::Convert( $uid )->toFileReference()``;

.. code-block:: php

	\nn\t3::Fal()->getFileReferenceByUid( 123 );

| ``@param $uid``
| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``

| :ref:`➜ Go to source code of Fal::getFileReferenceByUid() <Fal-getFileReferenceByUid>`

\\nn\\t3::Fal()->getImage(``$src = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Retrieves / converts to a \TYPO3\CMS\Core\Resource\FileReference object (sys_file_reference)
"Smart" variant of ``\TYPO3\CMS\Extbase\Service\ImageService->getImage()``

.. code-block:: php

	\nn\t3::Fal()->getImage( 1 );
	\nn\t3::Fal()->getImage( 'path/to/image.jpg' );
	\nn\t3::Fal()->getImage( $fileReference );

| ``@param string|\TYPO3\CMS\Extbase\Domain\Model\FileReference $src``
| ``@return \TYPO3\CMS\Core\Resource\FileReference|boolean``

| :ref:`➜ Go to source code of Fal::getImage() <Fal-getImage>`

\\nn\\t3::Fal()->process(``$fileObj = '', $processing = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Calculates an image via ``maxWidth``, ``maxHeight``, ``cropVariant`` etc.
Returns URI to the image as a string. Helpful for calculating thumbnails in the backend.
Alias to ``\nn\t3::File()->process()``

.. code-block:: php

	\nn\t3::File()->process( 'fileadmin/images/portrait.jpg', ['maxWidth'=>200] );
	\nn\t3::File()->process( '1:/images/portrait.jpg', ['maxWidth'=>200] );
	\nn\t3::File()->process( $sysFile, ['maxWidth'=>200] );
	\nn\t3::File()->process( $sysFileReference, ['maxWidth'=>200, 'cropVariant'=>'square'] );

| ``@return string``

| :ref:`➜ Go to source code of Fal::process() <Fal-process>`

\\nn\\t3::Fal()->setInModel(``$model, $fieldName = '', $imagesToAdd = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Replaces a ``FileReference`` or ``ObjectStorage`` in a model with images.
Typical use case: A FAL image is to be changed via an upload form in the frontend.
be able to be changed.

For each image, the system checks whether a ``FileReference`` already exists in the model.
Existing FileReferences are not overwritten, otherwise any
captions or cropping instructions would be lost!

Attention! The model is automatically persisted!

.. code-block:: php

	$newModel = new \My\Extension\Domain\Model\Example();
	\nn\t3::Fal()->setInModel( $newModel, 'falslideshow', 'path/to/file.jpg' );
	echo $newModel->getUid(); // Model has been persisted!

Example with a simple FileReference in the model:

.. code-block:: php

	$imageToSet = 'fileadmin/images/portrait.jpg';
	\nn\t3::Fal()->setInModel( $member, 'falprofileimage', $imageToSet );
	
	\nn\t3::Fal()->setInModel( $member, 'falprofileimage', ['publicUrl'=>'01.jpg', 'title'=>'Title', 'description'=>'...'] );

Example with a single SysFile:

.. code-block:: php

	$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
	$file = $resourceFactory->getFileObjectFromCombinedIdentifier('1:/foo.jpg');
	\nn\t3::Fal()->setInModel( $member, 'image', $file );

Example with a single SysFile that is to be stored in an ObjectStorage:

.. code-block:: php

	$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
	$file = $resourceFactory->getFileObjectFromCombinedIdentifier('1:/foo.jpg');
	\nn\t3::Fal()->setInModel( $member, 'images', [$file] );

Example with an ObjectStorage in the model:

.. code-block:: php

	$imagesToSet = ['fileadmin/images/01.jpg', 'fileadmin/images/02.jpg', ...];
	\nn\t3::Fal()->setInModel( $member, 'falslideshow', $imagesToSet );
	
	\nn\t3::Fal()->setInModel( $member, 'falslideshow', [['publicUrl'=>'01.jpg'], ['publicUrl'=>'02.jpg']] );
	\nn\t3::Fal()->setInModel( $member, 'falvideos', [['publicUrl'=>'https://youtube.com/?watch=zagd61231'], ...] );

Example with videos:

.. code-block:: php

	$videosToSet = ['https://www.youtube.com/watch?v=GwlU_wsT20Q', ...];
	\nn\t3::Fal()->setInModel( $member, 'videos', $videosToSet );

| ``@param mixed $model`` The model that is to be changed
| ``@param string $fieldName`` Property (field name) of the ObjectStorage or FileReference
| ``@param mixed $imagesToAdd`` String / array with images

| ``@return mixed``

| :ref:`➜ Go to source code of Fal::setInModel() <Fal-setInModel>`

\\nn\\t3::Fal()->toArray(``$fileReference = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Convert a FileReference into an array.
Contains publicUrl, title, alternative, crop etc. of the FileReference.
Alias to ``\nn\t3::Obj()->toArray( $fileReference );``

.. code-block:: php

	\nn\t3::Fal()->toArray( $fileReference ); // results in ['publicUrl'=>'fileadmin/...', 'title'=>'...']

| ``@param \TYPO3\CMS\Extbase\Domain\Model\FileReference $falReference``
| ``@return array``

| :ref:`➜ Go to source code of Fal::toArray() <Fal-toArray>`

\\nn\\t3::Fal()->unlink(``$uidOrObject = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes a SysFile and all associated SysFileReferences.
Alias to ``\nn\t3::Fal()->deleteSysFile()``

| ``@return integer``

| :ref:`➜ Go to source code of Fal::unlink() <Fal-unlink>`

\\nn\\t3::Fal()->updateMetaData(``$filenameOrSysFile = '', $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Update the information in ``sys_file_metadata`` and ``sys_file``

.. code-block:: php

	\nn\t3::Fal()->updateMetaData( 'fileadmin/file.jpg' );
	\nn\t3::Fal()->updateMetaData( $fileReference );
	\nn\t3::Fal()->updateMetaData( $falFile );

| ``@param $filenameOrSysFile`` FAL or path (string) to the file
| ``@param $data`` Array with data to be updated.
If empty, image data is read automatically
| ``@return void``

| :ref:`➜ Go to source code of Fal::updateMetaData() <Fal-updateMetaData>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
