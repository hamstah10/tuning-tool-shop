
.. include:: ../../../../Includes.txt

.. _Page-getPid:

==============================================
Page::getPid()
==============================================

\\nn\\t3::Page()->getPid(``$fallback = NULL``);
----------------------------------------------

PID der aktuellen Seite holen.
Im Frontend: Die aktuelle ``TSFE->id``
Im Backend: Die Seite, die im Seitenbaum ausgewählt wurde
Ohne Context: Die pid der site-Root

.. code-block:: php

	\nn\t3::Page()->getPid();
	\nn\t3::Page()->getPid( $fallbackPid );

| ``@return int``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getPid ( $fallback = null ) {
   	// Normaler Frontend-Content: Alles beim alten
   	if (\nn\t3::Environment()->isFrontend()) {
   		if (($GLOBALS['TSFE'] ?? false) && $pid = $GLOBALS['TSFE']->id) {
   			return $pid;
   		}
   		$request = \nn\t3::Environment()->getRequest();
   		$pageArguments = $request->getAttribute('routing');
   		if ($pid = $pageArguments['pageId'] ?? null) {
   			return $pid;
   		}
   		$siteRoot = $this->getSiteRoot();
   		if ($siteRoot && ($pid = $siteRoot['uid'] ?? false)) {
   			return $pid;
   		}
   		return $pid;
   	}
   	// Versuch, PID über den Request zu bekommen
   	if ($pid = $this->getPidFromRequest()) return $pid;
   	// PID über site-configuration (yaml) ermitteln
   	$site = \nn\t3::Environment()->getSite();
   	if ($site && ($pid = $site->getConfiguration()['rootPageId'] ?? false)) return $pid;
   	// Context nicht klar, dann PID der Site-Root holen
   	if ($siteRoot = $this->getSiteRoot()) return $siteRoot['uid'];
   	// Letzte Chance: Fallback angegeben?
   	if ($fallback) return $fallback;
   	// Keine Chance
   	if (\nn\t3::Environment()->isFrontend()) {
   		\nn\t3::Errors()->Exception('\nn\t3::Page()->getPid() could not determine pid');
   	}
   }
   

