
.. include:: ../../../../Includes.txt

.. _Page-getField:

==============================================
Page::getField()
==============================================

\\nn\\t3::Page()->getField(``$key, $slide = false, $override = ''``);
----------------------------------------------

Get single field from page data.
The value can be inherited from parent pages via ``slide = true``.

(!) Important:
Custom fields must be defined as rootLine in ``ext_localconf.php``!
See also ``\nn\t3::Registry()->rootLineFields(['key', '...']);``

.. code-block:: php

	\nn\t3::Page()->getField('layout');
	\nn\t3::Page()->getField('backend_layout_next_level', true, 'backend_layout');

Also exists as ViewHelper:

.. code-block:: php

	{nnt3:page.data(key:'uid')}
	{nnt3:page.data(key:'media', slide:1)}
	{nnt3:page.data(key:'backend_layout_next_level', slide:1, override:'backend_layout')}

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getField( $key, $slide = false, $override = '' ) {
   	// Rootline holen. Enthält Breadcrumb aller Menüpunkte von aktueller Seite aufwärts
   	$rootline = $this->getRootline();
   	$currentPage = $rootline[0];
   	// Kein Slide? Dann nur aktuelle Seite verwenden
   	if (!$slide) {
   		$rootline = array_slice($rootline, 0, 1, true);
   	}
   	// Override gesetzt und Wert in aktueller Seite vorhanden? Dann verwenden.
   	if ($override && $currentPage[$override]) {
   		$key = $override;
   	}
   	// Infos zum gesuchten Column aus TCA holen
   	$tcaColumn = \nn\t3::TCA()->getColumn( 'pages', $key )['config'] ?? [];
   	foreach ($rootline as $page) {
   		$val = false;
   		if ($page[$key]) $val = $page[$key];
   		if ($val) {
   			// Ist es eine SysFileReference? Dann "echtes" SysFileReference-Object zurückgeben
   			// ToDo: Prüfen, ob Typ besser ermittelt werden kann
   			// evtl. bei \TYPO3\CMS\Core\Utility\RootlineUtility->enrichWithRelationFields() schauen.
   			$isFal = in_array($tcaColumn['type'], ['inline', 'file']);
   			if ($isFal && $tcaColumn['foreign_table'] == 'sys_file_reference') {
   				$fileRepository = GeneralUtility::makeInstance( \TYPO3\CMS\Core\Resource\FileRepository::class );
   				$fileObjects = $fileRepository->findByRelation('pages', $key, $page['uid']);
   				return $fileObjects;
   			}
   			return $val;
   		}
   	}
   	return null;
   }
   

