
.. include:: ../../../../Includes.txt

.. _File-createFolder:

==============================================
File::createFolder()
==============================================

\\nn\\t3::File()->createFolder(``$path = NULL``);
----------------------------------------------

Create a folder in ``fileadmin/``
To create a folder outside the ``fileadmin``, use the method ``\nn\t3::File()->mkdir()``.

.. code-block:: php

	\nn\t3::File()->createFolder('tests');

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function createFolder($path = null)
   {
   	$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
   	$defaultStorage = $resourceFactory->getDefaultStorage();
   	$basePath = \nn\t3::Environment()->getPathSite() . $defaultStorage->getConfiguration()['basePath'];
   	if (file_exists($basePath . $path)) return true;
   	$defaultStorage->createFolder($path);
   }
   

