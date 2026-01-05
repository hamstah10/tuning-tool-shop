
.. include:: ../../../../Includes.txt

.. _Fal-toArray:

==============================================
Fal::toArray()
==============================================

\\nn\\t3::Fal()->toArray(``$fileReference = NULL``);
----------------------------------------------

Eine FileReference in ein Array konvertieren.
Enthält publicUrl, title, alternative, crop etc. der FileReference.
Alias zu ``\nn\t3::Obj()->toArray( $fileReference );``

.. code-block:: php

	\nn\t3::Fal()->toArray( $fileReference );    // ergibt ['publicUrl'=>'fileadmin/...', 'title'=>'...']

| ``@param \TYPO3\CMS\Extbase\Domain\Model\FileReference $falReference``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function toArray(\TYPO3\CMS\Extbase\Domain\Model\FileReference $fileReference = NULL)
   {
   	return \nn\t3::Obj()->toArray( $fileReference );
   }
   

