
.. include:: ../../../../Includes.txt

.. _File-sendDownloadHeader:

==============================================
File::sendDownloadHeader()
==============================================

\\nn\\t3::File()->sendDownloadHeader(``$filename = '', $filesize = NULL``);
----------------------------------------------

Send PHP header for download.
If the file physically exists, the ``filesize`` is determined automatically.

.. code-block:: php

	\nn\t3::File()->sendDownloadHeader( 'download.jpg' );
	\nn\t3::File()->sendDownloadHeader( 'path/to/file/download.jpg' );
	\nn\t3::File()->sendDownloadHeader( 'fakedatei.jpg', 1200 );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function sendDownloadHeader($filename = '', $filesize = null)
   {
   	ob_end_clean();
   	if (!$filesize && $size = \nn\t3::File()->size($filename)) {
   		$filesize = $size;
   	}
   	$filename = pathinfo($filename, PATHINFO_BASENAME);
   	$type = pathinfo($filename, PATHINFO_EXTENSION);
   	header("Content-Transfer-Encoding: Binary");
   	header("Content-Type: application/{$type}");
   	//header('Content-Type: application/octet-stream');
   	header('Content-Disposition: attachment; filename="' . $filename . '"');
   	if ($filesize) header("Content-Length: " . $filesize);
   }
   

