
.. include:: ../../../../Includes.txt

.. _Content-getAll:

==============================================
Content::getAll()
==============================================

\\nn\\t3::Content()->getAll(``$constraints = [], $getRelations = false, $localize = true``);
----------------------------------------------

Mehrere Content-Elemente (aus ``tt_content``) holen.

Die Datensätze werden automatisch lokalisiert – außer ``$localize`` wird auf ``false``
gesetzt. Siehe ``\nn\t3::Content()->get()`` für weitere ``$localize`` Optionen.

Anhand einer Liste von UIDs:

.. code-block:: php

	\nn\t3::Content()->getAll( 1 );
	\nn\t3::Content()->getAll( [1, 2, 7] );

Anhand von Filter-Kriterien:

.. code-block:: php

	\nn\t3::Content()->getAll( ['pid'=>1] );
	\nn\t3::Content()->getAll( ['pid'=>1, 'colPos'=>1] );
	\nn\t3::Content()->getAll( ['pid'=>1, 'CType'=>'mask_section_cards', 'colPos'=>1] );

| ``@param mixed $ttContentUid`` Content-Uids oder Constraints für Abfrage der Daten
| ``@param bool $getRelations`` Auch Relationen / FAL holen?
| ``@param bool $localize`` Übersetzen des Eintrages?
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getAll($constraints = [], $getRelations = false, $localize = true)
   {
   	if (!$constraints) return [];
   	// ist es eine uid-Liste, z.B. [1, 2, 3]?
   	$isUidList = count(array_filter(array_flip($constraints), function ($v) {
   			return !is_numeric($v);
   		})) == 0;
   	$results = [];
   	// ... dann einfach \nn\t3::Content()->get() verwenden
   	if ($isUidList) {
   		foreach ($constraints as $uid) {
   			if ($element = $this->get($uid, $getRelations, $localize)) {
   				$results[] = $element;
   			}
   		}
   		return $results;
   	}
   	// und sonst: eine Query bauen
   	// Datensatz in der Standard-Sprache holen
   	$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   	$query = $queryBuilder
   		->select('*')
   		->from('tt_content')
   		->addOrderBy('sorting', \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING)
   		->andWhere($queryBuilder->expr()->eq('sys_language_uid', 0));
   	if (isset($constraints['pid'])) {
   		$pid = $constraints['pid'];
   		$query->andWhere($queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pid)));
   	}
   	if (isset($constraints['colPos'])) {
   		$colPos = $constraints['colPos'];
   		$query->andWhere($queryBuilder->expr()->eq('colPos', $queryBuilder->createNamedParameter($colPos)));
   	}
   	if ($cType = $constraints['CType'] ?? false) {
   		$query->andWhere($queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter($cType)));
   	}
   	$data = $query->executeQuery()->fetchAllAssociative();
   	if (!$data) return [];
   	foreach ($data as $row) {
   		if ($row = $this->localize('tt_content', $row, $localize)) {
   			if ($getRelations) {
   				$data = $this->addRelations($data);
   			}
   			$results[] = $row;
   		}
   	}
   	return $results;
   }
   

