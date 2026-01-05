
.. include:: ../../../../Includes.txt

.. _File-download:

==============================================
File::download()
==============================================

\\nn\\t3::File()->download(``$files = NULL, $filename = NULL``);
----------------------------------------------

Download einer einzelnen Datei oder eines gezippten Archives.

Download als ZIP erfordert die PHP-Extension ``gmp``. Falls Extension nicht vorhanden ist,
wird auf ``.tar``-Variante ausgewichen. Bei Mac verwendet die Funktion aufgrund von
Sicherheitswarnungen des Finders grundsätzlich ``tar``

.. code-block:: php

	\nn\t3::File()->download( 'fileadmin/test.pdf' );
	\nn\t3::File()->download( $fileReference );
	\nn\t3::File()->download( $sysFile );
	\nn\t3::File()->download( 'fileadmin/test.pdf', 'download.pdf' );

Wird ein Array übergeben, wird ein tar/zip-Download gestartet.
Durch Übergabe eines assoziativen Arrays mit Dateiname als key und Pfad im Archiv als value
Kann die Datei- und Ordnerstruktur im zip-Archiv bestimmt werden.

.. code-block:: php

	\nn\t3::File()->download( ['fileadmin/test-1.pdf', 'fileadmin/test-2.pdf'], 'archive.zip' );
	\nn\t3::File()->download( ['fileadmin/test-1.pdf'=>'eins.pdf', 'fileadmin/test-2.pdf'=>'zwei.pdf'], 'archive.zip' );
	\nn\t3::File()->download( ['fileadmin/test-1.pdf'=>'zip-folder-1/eins.pdf', 'fileadmin/test-2.pdf'=>'zip-folder-2/zwei.pdf'], 'archive.zip' );

| ``@param mixed $files`` String oder Array der Dateien, die geladen werden sollen
| ``@param mixed $filename`` Optional: Dateinamen überschreiben beim Download
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
   

