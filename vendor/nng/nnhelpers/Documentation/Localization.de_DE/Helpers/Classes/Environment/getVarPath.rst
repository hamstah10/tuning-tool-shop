
.. include:: ../../../../Includes.txt

.. _Environment-getVarPath:

==============================================
Environment::getVarPath()
==============================================

\\nn\\t3::Environment()->getVarPath();
----------------------------------------------

Absoluten Pfad zu dem ``/var``-Verzeichnis von Typo3 holen.

Dieses Verzeichnis speichert temporäre Cache-Dateien.
Je nach Version von Typo3 und Installationstyp (Composer oder Non-Composer mode)
ist dieses Verzeichnis an unterschiedlichen Orten zu finden.

.. code-block:: php

	// /full/path/to/typo3temp/var/
	$path = \nn\t3::Environment()->getVarPath();

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getVarPath() {
   	return rtrim(\TYPO3\CMS\Core\Core\Environment::getVarPath(), '/').'/';
   }
   

