
.. include:: ../../../../Includes.txt

.. _File-isExternalVideo:

==============================================
File::isExternalVideo()
==============================================

\\nn\\t3::File()->isExternalVideo(``$url = NULL``);
----------------------------------------------

Gibt an, ob es ein Video auf YouTube / Vimeo ist.
Falls ja, wird ein Array mit Angaben zum Einbetten zurückgegeben.

.. code-block:: php

	\nn\t3::File()->isExternalVideo('http://...');

| ``@return array|boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isExternalVideo($url = null)
   {
   	return \nn\t3::Video()->getExternalType($url);
   }
   

