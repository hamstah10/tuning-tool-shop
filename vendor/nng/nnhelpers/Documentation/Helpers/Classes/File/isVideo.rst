
.. include:: ../../../../Includes.txt

.. _File-isVideo:

==============================================
File::isVideo()
==============================================

\\nn\\t3::File()->isVideo(``$filename = NULL``);
----------------------------------------------

Indicates whether the file is a video

.. code-block:: php

	\nn\t3::File()->isVideo('path/to/video.mp4'); => returns true

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isVideo($filename = null)
   {
   	return $this->type($filename) == 'video';
   }
   

