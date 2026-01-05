
.. include:: ../../../../Includes.txt

.. _File-mkdir:

==============================================
File::mkdir()
==============================================

\\nn\\t3::File()->mkdir(``$path = ''``);
----------------------------------------------

Einen Ordner anlegen

.. code-block:: php

	\nn\t3::File()->mkdir( 'fileadmin/mein/ordner/' );
	\nn\t3::File()->mkdir( '1:/mein/ordner/' );

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function mkdir($path = '')
   {
   	if (\nn\t3::File()->exists($path)) return true;
   	$path = \nn\t3::File()->absPath(rtrim($path, '/') . '/');
   	\TYPO3\CMS\Core\Utility\GeneralUtility::mkdir_deep($path);
   	return \nn\t3::File()->exists($path);
   }
   

