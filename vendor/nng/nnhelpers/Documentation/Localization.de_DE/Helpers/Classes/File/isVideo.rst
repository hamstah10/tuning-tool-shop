
.. include:: ../../../../Includes.txt

.. _File-isVideo:

==============================================
File::isVideo()
==============================================

\\nn\\t3::File()->isVideo(``$filename = NULL``);
----------------------------------------------

Gibt an, ob die Datei ein Video ist

.. code-block:: php

	\nn\t3::File()->isVideo('pfad/zum/video.mp4');     => gibt true zurück

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isVideo($filename = null)
   {
   	return $this->type($filename) == 'video';
   }
   

