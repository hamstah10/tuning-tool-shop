
.. include:: ../../../../Includes.txt

.. _Environment-getVarPath:

==============================================
Environment::getVarPath()
==============================================

\\nn\\t3::Environment()->getVarPath();
----------------------------------------------

Get the absolute path to the ``/var directory`` of Typo3.

This directory stores temporary cache files.
Depending on the version of Typo3 and installation type (Composer or Non-Composer mode)
this directory can be found in different locations.

.. code-block:: php

	// /full/path/to/typo3temp/var/
	$path = \nn\t3::Environment()->getVarPath();

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getVarPath() {
   	return rtrim(\TYPO3\CMS\Core\Core\Environment::getVarPath(), '/').'/';
   }
   

