
.. include:: ../../../../Includes.txt

.. _File-isAllowed:

==============================================
File::isAllowed()
==============================================

\\nn\\t3::File()->isAllowed(``$filename = NULL``);
----------------------------------------------

Gibt an, ob der Dateityp erlaubt ist

.. code-block:: php

	\nn\t3::File()->isForbidden('bild.jpg');   => gibt 'true' zurück
	\nn\t3::File()->isForbidden('hack.php');   => gibt 'false' zurück

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isAllowed($filename = null)
   {
   	return !$this->isForbidden($filename);
   }
   

