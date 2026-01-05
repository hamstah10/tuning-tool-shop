
.. include:: ../../../Includes.txt

.. _File:

==============================================
File
==============================================

\\nn\\t3::File()
----------------------------------------------

Methods relating to the file system:
Reading, writing, copying, moving and cleaning up files.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::File()->absPath(``$file = NULL, $resolveSymLinks = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Absolute path to a file on the server.

Returns the complete path from the server root, e.g. from ``/var/www/....``
If the path was already absolute, it is returned unchanged.

.. code-block:: php

	\nn\t3::File()->absPath('fileadmin/image.jpg'); // => /var/www/website/fileadmin/image.jpg
	\nn\t3::File()->absPath('/var/www/website/fileadmin/image.jpg'); // => /var/www/website/fileadmin/image.jpg
	\nn\t3::File()->absPath('EXT:nnhelpers'); // => /var/www/website/typo3conf/ext/nnhelpers/

In addition to the file path as a string, all conceivable objects can also be transferred:

.. code-block:: php

	// \TYPO3\CMS\Core\Resource\Folder
	\nn\t3::File()->absPath( $folderObject ); => /var/www/website/fileadmin/image.jpg
	
	// \TYPO3\CMS\Core\Resource\File
	\nn\t3::File()->absPath( $fileObject ); => /var/www/website/fileadmin/image.jpg
	
	// \TYPO3\CMS\Extbase\Domain\Model\FileReference
	\nn\t3::File()->absPath( $fileReference ); => /var/www/website/fileadmin/image.jpg

Also exists as ViewHelper:

.. code-block:: php

	{nnt3:file.absPath(file:'path/to/image.jpg')}

| ``@return boolean``

| :ref:`➜ Go to source code of File::absPath() <File-absPath>`

\\nn\\t3::File()->absUrl(``$file = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Generate absolute URL to a file.
Returns the complete path to the file including ``https://.../``.

.. code-block:: php

	// => https://www.myweb.de/fileadmin/bild.jpg
	\nn\t3::File()->absUrl( 'fileadmin/image.jpg' );
	\nn\t3::File()->absUrl( 'https://www.myweb.de/fileadmin/bild.jpg' );
	\nn\t3::File()->absUrl( $sysFileReference );
	\nn\t3::File()->absUrl( $falFile );

| ``@param string|\TYPO3\CMS\Core\Resource\FileReference|\TYPO3\CMS\Core\Resource\File $file``
| ``@return string``

| :ref:`➜ Go to source code of File::absUrl() <File-absUrl>`

\\nn\\t3::File()->addPathSite(``$file``);
"""""""""""""""""""""""""""""""""""""""""""""""

Specifies path to file / folder WITH absolute path

Example:

.. code-block:: php

	\nn\t3::File()->addPathSite('fileadmin/test.jpg');
	 // ==> returns var/www/website/fileadmin/test.jpg

| ``@return string``

| :ref:`➜ Go to source code of File::addPathSite() <File-addPathSite>`

\\nn\\t3::File()->addSuffix(``$filename = NULL, $newSuffix = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Replaces the suffix for a file name.

.. code-block:: php

	\nn\t3::File()->addSuffix('image', 'jpg'); // => image.jpg
	\nn\t3::File()->addSuffix('image.png', 'jpg'); // => image.jpg
	\nn\t3::File()->addSuffix('path/to/image.png', 'jpg'); // => path/to/image.jpg

| ``@return string``

| :ref:`➜ Go to source code of File::addSuffix() <File-addSuffix>`

\\nn\\t3::File()->cleanFilename(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Cleans a file name

.. code-block:: php

	$clean = \nn\t3::File()->cleanFilename('fileadmin/noe_so_not.jpg'); // 'fileadmin/noe_so_not.jpg'

| ``@return string``

| :ref:`➜ Go to source code of File::cleanFilename() <File-cleanFilename>`

\\nn\\t3::File()->copy(``$src = NULL, $dest = NULL, $renameIfFileExists = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Copies a file.
Returns ``false`` if the file could not be copied.
Returns (new) file name if copying was successful.

.. code-block:: php

	$filename = \nn\t3::File()->copy('fileadmin/image.jpg', 'fileadmin/image-copy.jpg');

| ``@param string $src`` Path to the source file
| ``@param string $dest`` Path to the destination file
| ``@param boolean $renameIfFileExists`` Rename file if a file with the same name already exists at the destination location
| ``@return string|boolean``

| :ref:`➜ Go to source code of File::copy() <File-copy>`

\\nn\\t3::File()->createFolder(``$path = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Create a folder in ``fileadmin/``
To create a folder outside the ``fileadmin``, use the method ``\nn\t3::File()->mkdir()``.

.. code-block:: php

	\nn\t3::File()->createFolder('tests');

| ``@return boolean``

| :ref:`➜ Go to source code of File::createFolder() <File-createFolder>`

\\nn\\t3::File()->download(``$files = NULL, $filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Download a single file or a zipped archive.

Download as ZIP requires the PHP extension ``gmp``. If extension is not available,
the ``.tar variant`` is used. On Mac, the function is always used due to
security warnings from the Finder, the function always uses ``tar``

.. code-block:: php

	\nn\t3::File()->download( 'fileadmin/test.pdf' );
	\nn\t3::File()->download( $fileReference );
	\nn\t3::File()->download( $sysFile );
	\nn\t3::File()->download( 'fileadmin/test.pdf', 'download.pdf' );

If an array is passed, a tar/zip download is started.
By passing an associative array with file name as key and path in the archive as value
the file and folder structure in the zip archive can be determined.

.. code-block:: php

	\nn\t3::File()->download( ['fileadmin/test-1.pdf', 'fileadmin/test-2.pdf'], 'archive.zip' );
	\nn\t3::File()->download( ['fileadmin/test-1.pdf'=>'one.pdf', 'fileadmin/test-2.pdf'=>'two.pdf'], 'archive.zip' );
	\nn\t3::File()->download( ['fileadmin/test-1.pdf'=>'zip-folder-1/one.pdf', 'fileadmin/test-2.pdf'=>'zip-folder-2/two.pdf'], 'archive.zip' );

| ``@param mixed $files`` String or array of the files to be loaded
| ``@param mixed $filename`` Optional: Overwrite file name during download
| ``@return void``

| :ref:`➜ Go to source code of File::download() <File-download>`

\\nn\\t3::File()->exists(``$src = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Checks whether a file exists.
Returns the absolute path to the file.

.. code-block:: php

	\nn\t3::File()->exists('fileadmin/image.jpg');

Also exists as ViewHelper:

.. code-block:: php

	{nnt3:file.exists(file:'path/to/image.jpg')}

| ``@return string|boolean``

| :ref:`➜ Go to source code of File::exists() <File-exists>`

\\nn\\t3::File()->extractExifData(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Save EXIF data for file in JSON.

.. code-block:: php

	\nn\t3::File()->extractExifData( 'yellowstone.jpg' );

| ``@return array``

| :ref:`➜ Go to source code of File::extractExifData() <File-extractExifData>`

\\nn\\t3::File()->getData(``$file = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get image info + EXIF data for file.
Also searches for JSON file that may have been generated after processImage()

| ``@return array``

| :ref:`➜ Go to source code of File::getData() <File-getData>`

\\nn\\t3::File()->getExifData(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get ALL EXIF data for file.

.. code-block:: php

	\nn\t3::File()->getExif( 'yellowstone.jpg' );

| ``@return array``

| :ref:`➜ Go to source code of File::getExifData() <File-getExifData>`

\\nn\\t3::File()->getFolder(``$file``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the folder to a file

Example:

.. code-block:: php

	\nn\t3::File()->getFolder('fileadmin/test/example.txt');
	// ==> returns 'fileadmin/test/'

| ``@return string``

| :ref:`➜ Go to source code of File::getFolder() <File-getFolder>`

\\nn\\t3::File()->getImageData(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get EXIF image data for file.

.. code-block:: php

	\nn\t3::File()->getImageData( 'yellowstone.jpg' );

| ``@return array``

| :ref:`➜ Go to source code of File::getImageData() <File-getImageData>`

\\nn\\t3::File()->getImageSize(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

get imagesize for file.

.. code-block:: php

	\nn\t3::File()->getImageSize( 'yellowstone.jpg' );

| ``@return array``

| :ref:`➜ Go to source code of File::getImageSize() <File-getImageSize>`

\\nn\\t3::File()->getLocationData(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get EXIF GEO data for file.
Address data is determined automatically if possible

.. code-block:: php

	\nn\t3::File()->getLocationData( 'yellowstone.jpg' );

| ``@return array``

| :ref:`➜ Go to source code of File::getLocationData() <File-getLocationData>`

\\nn\\t3::File()->getPath(``$file, $storage = NULL, $absolute = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the path of a file using a file name and the storage.
Example:

.. code-block:: php

	\nn\t3::File()->getPath('media/image.jpg', $storage);
	// ==> returns '/var/www/.../fileadmin/media/image.jpg'
	\nn\t3::File()->getPath('fileadmin/media/image.jpg');
	// ==> returns '/var/www/.../fileadmin/media/image.jpg'

| ``@return string``

| :ref:`➜ Go to source code of File::getPath() <File-getPath>`

\\nn\\t3::File()->getPublicUrl(``$obj = NULL, $absolute = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Gets path to the file, relative to the Typo3 installation directory (PATH_site).
Can handle all types of objects.

.. code-block:: php

	\nn\t3::File()->getPublicUrl( $falFile ); // \TYPO3\CMS\Core\Resource\FileReference
	\nn\t3::File()->getPublicUrl( $fileReference ); // \TYPO3\CMS\Extbase\Domain\Model\FileReference
	\nn\t3::File()->getPublicUrl( $folder ); // \TYPO3\CMS\Core\Resource\Folder
	\nn\t3::File()->getPublicUrl( $folder, true ); // https://.../fileadmin/bild.jpg

| ``@return string``

| :ref:`➜ Go to source code of File::getPublicUrl() <File-getPublicUrl>`

\\nn\\t3::File()->getRelativePathInStorage(``$file, $storage = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the relative path of a file to the specified storage.

Example:

.. code-block:: php

	\nn\t3::File()->getRelativePathInStorage('fileadmin/media/image.jpg', $storage);
	// ==> returns 'media/image.jpg'

| ``@return string``

| :ref:`➜ Go to source code of File::getRelativePathInStorage() <File-getRelativePathInStorage>`

\\nn\\t3::File()->getStorage(``$file, $createIfNotExists = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Finds a matching sys_file_storage for a file or folder path.
To do this, searches through all sys_file_storage entries and compares
whether the basePath of the storage matches the path of the file.

.. code-block:: php

	\nn\t3::File()->getStorage('fileadmin/test/example.txt');
	\nn\t3::File()->getStorage( $falFile );
	\nn\t3::File()->getStorage( $sysFileReference );
	// returns ResourceStorage with basePath "fileadmin/"

| ``@return ResourceStorage``

| :ref:`➜ Go to source code of File::getStorage() <File-getStorage>`

\\nn\\t3::File()->isAllowed(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Specifies whether the file type is allowed

.. code-block:: php

	\nn\t3::File()->isForbidden('image.jpg'); => returns 'true'
	\nn\t3::File()->isForbidden('hack.php'); => returns 'false'

| ``@return boolean``

| :ref:`➜ Go to source code of File::isAllowed() <File-isAllowed>`

\\nn\\t3::File()->isConvertableToImage(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Specifies whether the file can be converted to an image

.. code-block:: php

	\nn\t3::File()->isConvertableToImage('image.jpg'); => returns true
	\nn\t3::File()->isConvertableToImage('text.ppt'); => returns false

| ``@return boolean``

| :ref:`➜ Go to source code of File::isConvertableToImage() <File-isConvertableToImage>`

\\nn\\t3::File()->isExternalVideo(``$url = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Indicates whether it is a video on YouTube / Vimeo.
If yes, an array with embedding information is returned.

.. code-block:: php

	\nn\t3::File()->isExternalVideo('http://...');

| ``@return array|boolean``

| :ref:`➜ Go to source code of File::isExternalVideo() <File-isExternalVideo>`

\\nn\\t3::File()->isFolder(``$file``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns whether the specified path is a folder

Example:

.. code-block:: php

	\nn\t3::File()->isFolder('fileadmin'); // => returns true

| ``@return boolean``

| :ref:`➜ Go to source code of File::isFolder() <File-isFolder>`

\\nn\\t3::File()->isForbidden(``$filename = NULL, $allowed = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Indicates whether the file type is prohibited

.. code-block:: php

	\nn\t3::File()->isForbidden('image.jpg'); => returns 'false'
	\nn\t3::File()->isForbidden('image.xyz', ['xyz']); => returns 'false'
	\nn\t3::File()->isForbidden('hack.php'); => returns 'true'
	\nn\t3::File()->isForbidden('.htaccess'); => returns 'true'

| ``@param string $filename``
| ``@param array $allowed``
| ``@return boolean``

| :ref:`➜ Go to source code of File::isForbidden() <File-isForbidden>`

\\nn\\t3::File()->isImage(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Indicates whether the file is in an image

.. code-block:: php

	\nn\t3::File()->isImage('image.jpg'); => returns true
	\nn\t3::File()->isImage('text.ppt'); => returns false

| ``@return boolean``

| :ref:`➜ Go to source code of File::isImage() <File-isImage>`

\\nn\\t3::File()->isVideo(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Indicates whether the file is a video

.. code-block:: php

	\nn\t3::File()->isVideo('path/to/video.mp4'); => returns true

| ``@return boolean``

| :ref:`➜ Go to source code of File::isVideo() <File-isVideo>`

\\nn\\t3::File()->mkdir(``$path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Create a folder

.. code-block:: php

	\nn\t3::File()->mkdir( 'fileadmin/my/folder/' );
	\nn\t3::File()->mkdir( '1:/my/folder/' );

| ``@return boolean``

| :ref:`➜ Go to source code of File::mkdir() <File-mkdir>`

\\nn\\t3::File()->move(``$src = NULL, $dest = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Moves a file

.. code-block:: php

	\nn\t3::File()->move('fileadmin/image.jpg', 'fileadmin/image-copy.jpg');

| ``@return boolean``

| :ref:`➜ Go to source code of File::move() <File-move>`

\\nn\\t3::File()->moveUploadedFile(``$src = NULL, $dest = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Move an upload file to the target directory.

Can be the absolute path to the tmp file of the upload Ã¢ or a ``TYPO3\CMS\Core\Http\UploadedFile``,
which can be retrieved in the controller via ``$this->request->getUploadedFiles()``.

.. code-block:: php

	\nn\t3::File()->moveUploadedFile('/tmp/xjauGSaudsha', 'fileadmin/image-copy.jpg');
	\nn\t3::File()->moveUploadedFile( $fileObj, 'fileadmin/image-copy.jpg');

| ``@return string``

| :ref:`➜ Go to source code of File::moveUploadedFile() <File-moveUploadedFile>`

\\nn\\t3::File()->normalizePath(``$path``);
"""""""""""""""""""""""""""""""""""""""""""""""

Resolves ../../ specifications in path.
Works with both existing paths (via realpath) and non-existing paths.
non-existing paths.

.. code-block:: php

	\nn\t3::File()->normalizePath( 'fileadmin/test/../image.jpg' ); => fileadmin/image.jpg

| ``@return string``

| :ref:`➜ Go to source code of File::normalizePath() <File-normalizePath>`

\\nn\\t3::File()->process(``$fileObj = '', $processing = [], $returnProcessedImage = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Calculates an image via ``maxWidth``, ``maxHeight`` etc.
Simple version of ``\nn\t3::File()->processImage()``
Can be used if only the generation of reduced images is required
without taking into account corrections to the camera alignment etc.

As the crop settings are stored in FileReference and not File,
 ``cropVariant`` only works when a ``FileReference`` is passed.

.. code-block:: php

	\nn\t3::File()->process( 'fileadmin/imgs/portrait.jpg', ['maxWidth'=>200] );
	\nn\t3::File()->process( '1:/images/portrait.jpg', ['maxWidth'=>200] );
	\nn\t3::File()->process( $sysFile, ['maxWidth'=>200] );
	\nn\t3::File()->process( $sysFile, ['maxWidth'=>200, 'absolute'=>true] );
	\nn\t3::File()->process( $sysFileReference, ['maxWidth'=>200, 'cropVariant'=>'square'] );

With the parameter ``$returnProcessedImage = true``, not the file path to the new image
but the processedImage object is returned.

.. code-block:: php

	\nn\t3::File()->process( 'fileadmin/imgs/portrait.jpg', ['maxWidth'=>200], true );

| ``@return string``

| :ref:`➜ Go to source code of File::process() <File-process>`

\\nn\\t3::File()->processImage(``$filenameOrSysFile = '', $processing = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Can be called directly after upload_copy_move().
Corrects the orientation of the image, which may have been saved in EXIF data.
Simply use the method ``\nn\t3::File()->process()`` for the ``maxWidth statement``.

Instructions for $processing:

| ``correctOrientation`` => Correct rotation (e.g. because photo was uploaded from smartphone)

| ``@return string``

| :ref:`➜ Go to source code of File::processImage() <File-processImage>`

\\nn\\t3::File()->read(``$src = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Retrieves the content of a file

.. code-block:: php

	\nn\t3::File()->read('fileadmin/text.txt');

| ``@return string|boolean``

| :ref:`➜ Go to source code of File::read() <File-read>`

\\nn\\t3::File()->relPath(``$path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

relative path (from the current script) to a file / directory.
If no path is specified, the Typo3 root directory is returned.

.. code-block:: php

	\nn\t3::File()->relPath( $file ); => ../fileadmin/image.jpg
	\nn\t3::File()->relPath(); => ../

| ``@return string``

| :ref:`➜ Go to source code of File::relPath() <File-relPath>`

\\nn\\t3::File()->resolvePathPrefixes(``$file = NULL, $absolute = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

EXT: Resolve prefix to relative path specification

.. code-block:: php

	\nn\t3::File()->resolvePathPrefixes('EXT:extname'); => /typo3conf/ext/extname/
	\nn\t3::File()->resolvePathPrefixes('EXT:extname/'); => /typo3conf/ext/extname/
	\nn\t3::File()->resolvePathPrefixes('EXT:extname/image.jpg'); => /typo3conf/ext/extname/image.jpg
	\nn\t3::File()->resolvePathPrefixes('1:/uploads/image.jpg', true); => /var/www/website/fileadmin/uploads/image.jpg

| ``@return string``

| :ref:`➜ Go to source code of File::resolvePathPrefixes() <File-resolvePathPrefixes>`

\\nn\\t3::File()->sendDownloadHeader(``$filename = '', $filesize = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Send PHP header for download.
If the file physically exists, the ``filesize`` is determined automatically.

.. code-block:: php

	\nn\t3::File()->sendDownloadHeader( 'download.jpg' );
	\nn\t3::File()->sendDownloadHeader( 'path/to/file/download.jpg' );
	\nn\t3::File()->sendDownloadHeader( 'fakedatei.jpg', 1200 );

| ``@return void``

| :ref:`➜ Go to source code of File::sendDownloadHeader() <File-sendDownloadHeader>`

\\nn\\t3::File()->size(``$src = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the file size of a file in bytes
If file does not exist, 0 is returned.

.. code-block:: php

	\nn\t3::File()->size('fileadmin/image.jpg');

| ``@return integer``

| :ref:`➜ Go to source code of File::size() <File-size>`

\\nn\\t3::File()->stripBaseUrl(``$file``);
"""""""""""""""""""""""""""""""""""""""""""""""

Removes the URL if it corresponds to the current domain

Example:

.. code-block:: php

	\nn\t3::File()->stripBaseUrl('https://www.my-web.de/fileadmin/test.jpg'); ==> fileadmin/test.jpg
	\nn\t3::File()->stripBaseUrl('https://www.other-web.de/example.jpg'); ==> https://www.other-web.de/example.jpg

| ``@return string``

| :ref:`➜ Go to source code of File::stripBaseUrl() <File-stripBaseUrl>`

\\nn\\t3::File()->stripPathSite(``$file, $prefix = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Specifies the path to the file / folder WITHOUT an absolute path.
Optionally, a prefix can be specified.

Example:

.. code-block:: php

	\nn\t3::File()->stripPathSite('var/www/website/fileadmin/test.jpg'); ==> fileadmin/test.jpg
	\nn\t3::File()->stripPathSite('var/www/website/fileadmin/test.jpg', true); ==> var/www/website/fileadmin/test.jpg
	\nn\t3::File()->stripPathSite('fileadmin/test.jpg', true); ==> var/www/website/fileadmin/test.jpg
	\nn\t3::File()->stripPathSite('fileadmin/test.jpg', '../../'); ==> ../../fileadmin/test.jpg

| ``@return string``

| :ref:`➜ Go to source code of File::stripPathSite() <File-stripPathSite>`

\\nn\\t3::File()->suffix(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the suffix of the file

.. code-block:: php

	\nn\t3::File()->suffix('image.jpg'); => returns 'jpg'

| ``@return string``

| :ref:`➜ Go to source code of File::suffix() <File-suffix>`

\\nn\\t3::File()->suffixForMimeType(``$mime = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the suffix for a specific mime type / content type.
Very reduced version - only a few types covered.
Extensive version: https://bit.ly/3B9KrNA

.. code-block:: php

	\nn\t3::File()->suffixForMimeType('image/jpeg'); => returns 'jpg'

| ``@return string``

| :ref:`➜ Go to source code of File::suffixForMimeType() <File-suffixForMimeType>`

\\nn\\t3::File()->type(``$filename = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the type of file based on the file suffix

.. code-block:: php

	\nn\t3::File()->type('image.jpg'); => returns 'image'
	\nn\t3::File()->type('text.doc'); => returns 'document'

| ``@return string``

| :ref:`➜ Go to source code of File::type() <File-type>`

\\nn\\t3::File()->uniqueFilename(``$filename = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Creates a unique file name for the file if there is already
a file with an identical name already exists in the target directory
already exists in the target directory.

.. code-block:: php

	$name = \nn\t3::File()->uniqueFilename('fileadmin/01.jpg'); // 'fileadmin/01-1.jpg'

| ``@return string``

| :ref:`➜ Go to source code of File::uniqueFilename() <File-uniqueFilename>`

\\nn\\t3::File()->unlink(``$file = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes a file completely from the server.
Also deletes all ``sys_file`` and ``sys_file_references`` that refer to the file.
For security reasons, no PHP or HTML files can be deleted.

.. code-block:: php

	\nn\t3::File()->unlink('fileadmin/image.jpg'); // Path to the image
	\nn\t3::File()->unlink('/abs/path/to/file/fileadmin/image.jpg'); // absolute path to the image
	\nn\t3::File()->unlink('1:/my/image.jpg'); // Combined identifier notation
	\nn\t3::File()->unlink( $model->getImage() ); // \TYPO3\CMS\Extbase\Domain\Model\FileReference
	\nn\t3::File()->unlink( $falFile ); // \TYPO3\CMS\Core\Resource\FileReference

| ``@return boolean``

| :ref:`➜ Go to source code of File::unlink() <File-unlink>`

\\nn\\t3::File()->write(``$path = NULL, $content = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Create a folder and/or file.
Also creates the folders if they do not exist.

.. code-block:: php

	\nn\t3::File()->write('fileadmin/some/deep/folder/');
	\nn\t3::File()->write('1:/some/deep/folder/');
	\nn\t3::File()->write('fileadmin/some/deep/folder/file.json', 'TEXT');

| ``@return boolean``

| :ref:`➜ Go to source code of File::write() <File-write>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
