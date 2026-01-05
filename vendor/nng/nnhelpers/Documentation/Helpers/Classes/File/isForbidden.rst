
.. include:: ../../../../Includes.txt

.. _File-isForbidden:

==============================================
File::isForbidden()
==============================================

\\nn\\t3::File()->isForbidden(``$filename = NULL, $allowed = []``);
----------------------------------------------

Indicates whether the file type is prohibited

.. code-block:: php

	\nn\t3::File()->isForbidden('image.jpg'); => returns 'false'
	\nn\t3::File()->isForbidden('image.xyz', ['xyz']); => returns 'false'
	\nn\t3::File()->isForbidden('hack.php'); => returns 'true'
	\nn\t3::File()->isForbidden('.htaccess'); => returns 'true'

| ``@param string $filename``
| ``@param array $allowed``
| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isForbidden($filename = null, $allowed = [])
   {
   	if (!$filename) return false;
   	if (substr($filename, 0, 1) == '.') return true;
   	if (!$allowed) {
   		$types = array_values(self::$TYPES);
   		$allowed = array_merge(...$types);
   	}
   	$suffix = $this->suffix($filename);
   	return !in_array($suffix, $allowed);
   }
   

