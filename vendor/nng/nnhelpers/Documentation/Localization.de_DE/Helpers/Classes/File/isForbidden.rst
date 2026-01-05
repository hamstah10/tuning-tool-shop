
.. include:: ../../../../Includes.txt

.. _File-isForbidden:

==============================================
File::isForbidden()
==============================================

\\nn\\t3::File()->isForbidden(``$filename = NULL, $allowed = []``);
----------------------------------------------

Gibt an, ob der Dateityp verboten ist

.. code-block:: php

	\nn\t3::File()->isForbidden('bild.jpg');                   => gibt 'false' zurück
	\nn\t3::File()->isForbidden('bild.xyz', ['xyz']);        => gibt 'false' zurück
	\nn\t3::File()->isForbidden('hack.php');                   => gibt 'true' zurück
	\nn\t3::File()->isForbidden('.htaccess');              => gibt 'true' zurück

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
   

