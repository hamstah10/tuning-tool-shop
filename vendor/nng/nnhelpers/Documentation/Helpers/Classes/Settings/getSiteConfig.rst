
.. include:: ../../../../Includes.txt

.. _Settings-getSiteConfig:

==============================================
Settings::getSiteConfig()
==============================================

\\nn\\t3::Settings()->getSiteConfig(``$request = NULL``);
----------------------------------------------

Get site configuration.
This is the configuration that has been defined in the YAML files in the ``/sites`` folder since TYPO3 9.
Some of the settings can also be set via the "Sites" page module.

In the context of a MiddleWare, the ``site`` may not yet be parsed / loaded.
In this case, the ``$request`` from the MiddleWare can be passed to determine the site.

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
   

