
.. include:: ../../../../Includes.txt

.. _Fal-getFilePath:

==============================================
Fal::getFilePath()
==============================================

\\nn\\t3::Fal()->getFilePath(``$falReference``);
----------------------------------------------

Die URL zu einer FileReference oder einem FalFile holen.
Alias zu ``\nn\t3::File()->getPublicUrl()``.

.. code-block:: php

	\nn\t3::Fal()->getFilePath( $fileReference );    // ergibt z.B. 'fileadmin/bilder/01.jpg'

| ``@param \TYPO3\CMS\Extbase\Domain\Model\FileReference|\TYPO3\CMS\Core\Resource\FileReference $falReference``
| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getFilePath($falReference)
   {
   	return \nn\t3::File()->getPublicUrl( $falReference );
   }
   

