
.. include:: ../../../../Includes.txt

.. _Fal-getFileObjectFromCombinedIdentifier:

==============================================
Fal::getFileObjectFromCombinedIdentifier()
==============================================

\\nn\\t3::Fal()->getFileObjectFromCombinedIdentifier(``$file = ''``);
----------------------------------------------

Retrieves a SysFile from the CombinedIdentifier notation ('1:/uploads/example.txt').
If file does not exist, FALSE is returned.

.. code-block:: php

	\nn\t3::Fal()->getFileObjectFromCombinedIdentifier( '1:/uploads/example.txt' );

| ``@param string $file`` Combined Identifier ('1:/uploads/example.txt')
| ``@return File|boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getFileObjectFromCombinedIdentifier( $file = '' )
   {
   	$resourceFactory = GeneralUtility::makeInstance( ResourceFactory::class );
   	$parts = \nn\t3::Arrays($file)->trimExplode(':');
   	$storageUid = (int) ($parts[0] ?? 0);
   	$filePath = $parts[1] ?? '';
   	
   	if (!$storageUid || !$filePath) {
   		return false;
   	}
   	
   	try {
   		$storage = $resourceFactory->getStorageObject($storageUid);
   		if ($storage && $storage->hasFile($filePath)) {
   			return $resourceFactory->getFileObjectFromCombinedIdentifier($file);
   		}
   	} catch (\Exception $e) {
   		return false;
   	}
   	
   	return false;
   }
   

