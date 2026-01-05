
.. include:: ../../../../Includes.txt

.. _File-download:

==============================================
File::download()
==============================================

\\nn\\t3::File()->download(``$files = NULL, $filename = NULL``);
----------------------------------------------

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

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function download($files = null, $filename = null)
   {
   	\nn\t3::autoload();
   	ob_end_clean();
   	if (!is_array($files)) $files = [$files];
   	// FE.compressionLevel in der LocalConfiguration angegeben? Dann hier deaktivieren!
   	if ($GLOBALS['TYPO3_CONF_VARS']['FE']['compressionLevel']) {
   		header('Content-Encoding: none');
   		if (function_exists('apache_setenv')) {
   			apache_setenv('no-gzip', '1');
   		}
   		if (extension_loaded('zlib')) {
   			@ini_set('zlib.output_compression', 'off');
   			@ini_set('zlib.output_compression_level', '0');
   		}
   	}
   	// Nur eine Datei angegeben, dann einfacher Download
   	if (count($files) == 1) {
   		$k = key($files);
   		if (!is_numeric($k)) {
   			// ['pfad/zur/datei.pdf' => 'downloadname.pdf']
   			$path = $this->absPath($k);
   			$filenameForDownload = $files[$k];
   		} else {
   			// ['pfad/zur/datei.pdf']
   			$path = $this->absPath($files[$k]);
   			$filenameForDownload = pathinfo($path, PATHINFO_BASENAME);
   		}
   		if (!$path) {
   			die('Could not resolve absolute file path for download.');
   		}
   		\nn\t3::File()->sendDownloadHeader($filenameForDownload);
   		readfile($path);
   		die();
   	}
   	$archiveFilename = $filename ?: 'download-' . date('Y-m-d');
   	$stream = fopen('php://output', 'w');
   	$opt = [];
   	// gmp_init ist auf dem Server erforderlich für zip-Stream. Falls nicht vorhanden, auf .tar ausweichen
   	if (function_exists('gmp_init')) {
   		$zipStream = \Barracuda\ArchiveStream\Archive::instance_by_useragent($archiveFilename, $opt, $stream);
   	} else {
   		$zipStream = new \Barracuda\ArchiveStream\TarArchive($archiveFilename . '.tar', $opt, null, $stream);
   	}
   	$filesInArchive = [];
   	foreach ($files as $k => $file) {
   		$filenameInArchive = basename($file);
   		// ['fileadmin/test.pdf' => 'ordername_im_archiv/beispiel.pdf'] wurde übergeben
   		if (!is_numeric($k)) {
   			$filenameInArchive = $file;
   			$file = $k;
   		}
   		$file = $this->absPath($file);
   		if ($filesize = $this->size($file)) {
   			// Gleicher Dateiname bereits im Archiv vorhanden? Dann "-cnt" anhängen
   			if ($filesInArchive[$filenameInArchive]) {
   				$cnt = $filesInArchive[$filenameInArchive]++;
   				$filenameInArchive = pathinfo($filenameInArchive, PATHINFO_FILENAME) . '-' . $cnt . '.' . pathinfo($filenameInArchive, PATHINFO_EXTENSION);
   			} else {
   				$filesInArchive[$filenameInArchive] = 1;
   			}
   			$zipStream->init_file_stream_transfer($filenameInArchive, $filesize);
   			$fileStream = fopen($file, 'r');
   			while ($buffer = fread($fileStream, 256000)) {
   				$zipStream->stream_file_part($buffer);
   			}
   			fclose($fileStream);
   			$zipStream->complete_file_stream();
   		}
   	}
   	$zipStream->finish();
   	die();
   }
   

