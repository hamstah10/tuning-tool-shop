
.. include:: ../../../../Includes.txt

.. _File-isAllowed:

==============================================
File::isAllowed()
==============================================

\\nn\\t3::File()->isAllowed(``$filename = NULL``);
----------------------------------------------

Specifies whether the file type is allowed

.. code-block:: php

	\nn\t3::File()->isForbidden('image.jpg'); => returns 'true'
	\nn\t3::File()->isForbidden('hack.php'); => returns 'false'

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isAllowed($filename = null)
   {
   	return !$this->isForbidden($filename);
   }
   

