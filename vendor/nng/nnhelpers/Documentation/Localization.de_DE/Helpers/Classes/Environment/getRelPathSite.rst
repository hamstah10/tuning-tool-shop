
.. include:: ../../../../Includes.txt

.. _Environment-getRelPathSite:

==============================================
Environment::getRelPathSite()
==============================================

\\nn\\t3::Environment()->getRelPathSite();
----------------------------------------------

Relativen Pfad zum Typo3-Root-Verzeichnis holen. z.B. ``../``

.. code-block:: php

	\nn\t3::Environment()->getRelPathSite()

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getRelPathSite () {
   	return \nn\t3::File()->relPath();
   }
   

