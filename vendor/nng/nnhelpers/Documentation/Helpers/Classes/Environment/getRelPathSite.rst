
.. include:: ../../../../Includes.txt

.. _Environment-getRelPathSite:

==============================================
Environment::getRelPathSite()
==============================================

\\nn\\t3::Environment()->getRelPathSite();
----------------------------------------------

Get the relative path to the Typo3 root directory. e.g. ``../``

.. code-block:: php

	\nn\t3::Environment()->getRelPathSite()

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getRelPathSite () {
   	return \nn\t3::File()->relPath();
   }
   

