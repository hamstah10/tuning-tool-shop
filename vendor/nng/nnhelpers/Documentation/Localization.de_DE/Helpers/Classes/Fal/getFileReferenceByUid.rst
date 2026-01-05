
.. include:: ../../../../Includes.txt

.. _Fal-getFileReferenceByUid:

==============================================
Fal::getFileReferenceByUid()
==============================================

\\nn\\t3::Fal()->getFileReferenceByUid(``$uid = NULL``);
----------------------------------------------

Holt eine SysFileReference anhand der uid
Alias zu ``\nn\t3::Convert( $uid )->toFileReference()``;

.. code-block:: php

	\nn\t3::Fal()->getFileReferenceByUid( 123 );

| ``@param $uid``
| ``@return \TYPO3\CMS\Extbase\Domain\Model\FileReference``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getFileReferenceByUid( $uid = null )
   {
   	return \nn\t3::Convert( $uid )->toFileReference();
   }
   

