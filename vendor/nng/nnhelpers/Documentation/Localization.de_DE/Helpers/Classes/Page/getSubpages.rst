
.. include:: ../../../../Includes.txt

.. _Page-getSubpages:

==============================================
Page::getSubpages()
==============================================

\\nn\\t3::Page()->getSubpages(``$pid = NULL, $includeHidden = false, $includeAllTypes = false``);
----------------------------------------------

Menü für gegebene PID holen

.. code-block:: php

	\nn\t3::Page()->getSubpages();
	\nn\t3::Page()->getSubpages( $pid );
	\nn\t3::Page()->getSubpages( $pid, true );   // Auch versteckte Seiten holen
	\nn\t3::Page()->getSubpages( $pid, false, true );    // Alle Seiten-Typen holen
	\nn\t3::Page()->getSubpages( $pid, false, [PageRepository::DOKTYPE_SYSFOLDER] ); // Bestimmte Seiten-Typen holen

| ``@param int $pid``
| ``@param bool $includeHidden``
| ``@param bool|array $includeAllTypes``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getSubpages( $pid = null, $includeHidden = false, $includeAllTypes = false ) {
   	if (!$pid) $pid = $this->getPid();
   	if (!$pid) return [];
   	$page = GeneralUtility::makeInstance( PageRepository::class );
   	$hideTypes = [
   		$page::DOKTYPE_SPACER,
   		$page::DOKTYPE_BE_USER_SECTION,
   		$page::DOKTYPE_SYSFOLDER
   	];
   	if ($includeAllTypes === true) {
   		$hideTypes = [];
   	} else if ($includeAllTypes !== false) {
   		if (!is_array($includeAllTypes)) {
   			$includeAllTypes = [$includeAllTypes];
   		}
   		$hideTypes = array_diff($hideTypes, $includeAllTypes);
   	}
   	$constraints = [];
   	$constraints[] = 'hidden = 0';
   	$constraints[] = 'doktype NOT IN (' . join(',', $hideTypes) . ')';
   	if (!$includeHidden) {
   		$constraints[] = 'nav_hide = 0';
   	}
   	return $page->getMenu( $pid, '*', 'sorting', join(' AND ', $constraints) );
   }
   

