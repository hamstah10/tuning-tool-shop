
.. include:: ../../../../Includes.txt

.. _Settings-getCachedTyposcript:

==============================================
Settings::getCachedTyposcript()
==============================================

\\nn\\t3::Settings()->getCachedTyposcript();
----------------------------------------------

High-Peformance-Version für das Initialisieren des TSFE im Backend.
Das komplette TypoScript Setup holen, inkl. '.'-Syntax.

Wird über Filecache gespeichert.

.. code-block:: php

	\nn\t3::Settings()->getCachedTyposcript();

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getCachedTyposcript()
   {
   	if ($cache = \nn\t3::Cache()->read('nnhelpers_fullTsCache')) {
   		return $cache;
   	}
   	$setup = $this->getFullTyposcript();
   	\nn\t3::Cache()->write('nnhelpers_fullTsCache', $setup);
   	return $this->typoscriptFullCache = $setup;
   }
   

