
.. include:: ../../../../Includes.txt

.. _Settings-getSiteConfig:

==============================================
Settings::getSiteConfig()
==============================================

\\nn\\t3::Settings()->getSiteConfig(``$request = NULL``);
----------------------------------------------

Site-Konfiguration holen.
Das ist die Konfiguration, die ab TYPO3 9 in den YAML-Dateien im Ordner ``/sites`` definiert wurden.
Einige der Einstellungen sind auch über das Seitenmodul "Sites" einstellbar.

Im Kontext einer MiddleWare ist evtl. die ``site`` noch nicht geparsed / geladen.
In diesem Fall kann der ``$request`` aus der MiddleWare übergeben werden, um die Site zu ermitteln.

.. code-block:: php

	$config = \nn\t3::Settings()->getSiteConfig();
	$config = \nn\t3::Settings()->getSiteConfig( $request );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getSiteConfig( $request = null )
   {
   	$site = \nn\t3::Environment()->getSite();
   	if (!$site) return [];
   	if (!is_a($site, \TYPO3\CMS\Core\Site\Entity\NullSite::class)) {
   		return $site->getConfiguration() ?? [];
   	}
   	return [];
   }
   

