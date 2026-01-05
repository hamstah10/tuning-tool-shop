
.. include:: ../../../../Includes.txt

.. _Db-orderBy:

==============================================
Db::orderBy()
==============================================

\\nn\\t3::Db()->orderBy(``$queryOrRepository, $ordering = []``);
----------------------------------------------

Sortierung für ein Repository oder einen Query setzen.

.. code-block:: php

	$ordering = ['title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING];
	\nn\t3::Db()->orderBy( $queryOrRepository, $ordering );
	
	// asc und desc können als synonym verwendet werden
	$ordering = ['title' => 'asc'];
	$ordering = ['title' => 'desc'];
	\nn\t3::Db()->orderBy( $queryOrRepository, $ordering );

Kann auch zum Sortieren nach einer Liste von Werten (z.B. ``uids``) verwendet werden.
Dazu wird ein Array für den Wert des einzelnen orderings übergeben:

.. code-block:: php

	$ordering = ['uid' => [3,7,2,1]];
	\nn\t3::Db()->orderBy( $queryOrRepository, $ordering );

| ``@param mixed $queryOrRepository``
| ``@param array $ordering``
| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function orderBy( $queryOrRepository, $ordering = [] )
   {
   	$isQueryObject = get_class( $queryOrRepository ) == Query::class;
   	$isQueryBuilderObject = get_class( $queryOrRepository) == QueryBuilder::class;
   	if ($isQueryObject) {
   		// ToDo!
   	} else if ($isQueryBuilderObject) {
   		foreach ($ordering as $colName => $ascDesc) {
   			if (is_array($ascDesc)) {
   				foreach ($ascDesc as &$v) {
   					$v = $queryOrRepository->createNamedParameter( $v );
   				}
   				$queryOrRepository->add('orderBy', "FIELD({$colName}," . implode(',', $ascDesc) . ')', true );
   			} else {
   				// 'asc' und 'desc' können als Synonym verwendet werden
   				if (strtolower($ascDesc) == 'asc') {
   					$ascDesc = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING;
   				}
   				if (strtolower($ascDesc) == 'desc') {
   					$ascDesc = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING;
   				}
   				$queryOrRepository->addOrderBy( $colName, $ascDesc );
   			}
   		}
   	} else {
   		$queryOrRepository->setDefaultOrderings( $ordering );
   	}
   	return $queryOrRepository;
   }
   

