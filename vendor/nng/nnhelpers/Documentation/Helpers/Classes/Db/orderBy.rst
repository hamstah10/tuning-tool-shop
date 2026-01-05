
.. include:: ../../../../Includes.txt

.. _Db-orderBy:

==============================================
Db::orderBy()
==============================================

\\nn\\t3::Db()->orderBy(``$queryOrRepository, $ordering = []``);
----------------------------------------------

Set sorting for a repository or a query.

.. code-block:: php

	$ordering = ['title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING];
	\nn\t3::Db()->orderBy( $queryOrRepository, $ordering );
	
	// asc and desc can be used as synonyms
	$ordering = ['title' => 'asc'];
	$ordering = ['title' => 'desc'];
	\nn\t3::Db()->orderBy( $queryOrRepository, $ordering );

Can also be used to sort by a list of values (e.g. ``uids``).
An array is passed for the value of the individual orderings:

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
   

