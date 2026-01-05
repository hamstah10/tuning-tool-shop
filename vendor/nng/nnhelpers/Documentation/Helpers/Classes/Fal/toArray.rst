
.. include:: ../../../../Includes.txt

.. _Fal-toArray:

==============================================
Fal::toArray()
==============================================

\\nn\\t3::Fal()->toArray(``$fileReference = NULL``);
----------------------------------------------

Convert a FileReference into an array.
Contains publicUrl, title, alternative, crop etc. of the FileReference.
Alias to ``\nn\t3::Obj()->toArray( $fileReference );``

.. code-block:: php

	\nn\t3::Fal()->toArray( $fileReference ); // results in ['publicUrl'=>'fileadmin/...', 'title'=>'...']

| ``@param \TYPO3\CMS\Extbase\Domain\Model\FileReference $falReference``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function toArray(\TYPO3\CMS\Extbase\Domain\Model\FileReference $fileReference = NULL)
   {
   	return \nn\t3::Obj()->toArray( $fileReference );
   }
   

