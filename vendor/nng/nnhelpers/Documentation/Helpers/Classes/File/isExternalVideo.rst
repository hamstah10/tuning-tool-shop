
.. include:: ../../../../Includes.txt

.. _File-isExternalVideo:

==============================================
File::isExternalVideo()
==============================================

\\nn\\t3::File()->isExternalVideo(``$url = NULL``);
----------------------------------------------

Indicates whether it is a video on YouTube / Vimeo.
If yes, an array with embedding information is returned.

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
   

