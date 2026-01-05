
.. include:: ../../../../Includes.txt

.. _Environment-getPathSite:

==============================================
Environment::getPathSite()
==============================================

\\nn\\t3::Environment()->getPathSite();
----------------------------------------------

Get the absolute path to the Typo3 root directory. e.g. ``/var/www/website/``

.. code-block:: php

	\nn\t3::Environment()->getPathSite()

Formerly: ``PATH_site``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getPathSite () {
   	return \TYPO3\CMS\Core\Core\Environment::getPublicPath().'/';
   }
   

