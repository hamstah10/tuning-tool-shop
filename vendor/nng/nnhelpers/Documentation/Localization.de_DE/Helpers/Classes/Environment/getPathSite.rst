
.. include:: ../../../../Includes.txt

.. _Environment-getPathSite:

==============================================
Environment::getPathSite()
==============================================

\\nn\\t3::Environment()->getPathSite();
----------------------------------------------

Absoluten Pfad zum Typo3-Root-Verzeichnis holen. z.B. ``/var/www/website/``

.. code-block:: php

	\nn\t3::Environment()->getPathSite()

früher: ``PATH_site``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getPathSite () {
   	return \TYPO3\CMS\Core\Core\Environment::getPublicPath().'/';
   }
   

