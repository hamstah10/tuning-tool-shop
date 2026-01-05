
.. include:: ../../../../Includes.txt

.. _Db-ignoreEnableFields:

==============================================
Db::ignoreEnableFields()
==============================================

\\nn\\t3::Db()->ignoreEnableFields(``$queryOrRepository, $ignoreStoragePid = true, $ignoreHidden = false, $ignoreDeleted = false, $ignoreStartEnd = false``);
----------------------------------------------

Entfernt Default-Constraints zur StoragePID, hidden und/oder deleted
zu einer Query oder Repository.

.. code-block:: php

	\nn\t3::Db()->ignoreEnableFields( $entryRepository );
	\nn\t3::Db()->ignoreEnableFields( $query );

Beispiel für eine Custom Query:

.. code-block:: php

	$table = 'tx_myext_domain_model_entry';
	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	$queryBuilder->select('uid','title','hidden')->from( $table );
	\nn\t3::Db()->ignoreEnableFields( $queryBuilder, true, true );
	$rows = $queryBuilder->executeQuery()->fetchAllAssociative();

Sollte das nicht reichen oder zu kompliziert werden, siehe:

.. code-block:: php

	\nn\t3::Db()->statement();

| ``@param mixed $queryOrRepository``
| ``@param boolean $ignoreStoragePid``
| ``@param boolean $ignoreHidden``
| ``@param boolean $ignoreDeleted``
| ``@param boolean $ignoreStartEnd``
| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function ignoreEnableFields ( $queryOrRepository, $ignoreStoragePid = true, $ignoreHidden = false, $ignoreDeleted = false, $ignoreStartEnd = false )
   {
   	$isQueryObject = get_class( $queryOrRepository ) == Query::class;
   	$isQueryBuilderObject = get_class( $queryOrRepository) == QueryBuilder::class;
   	if ($isQueryObject) {
   		$query = $queryOrRepository;
   	} else if ($isQueryBuilderObject) {
   		// s. https://bit.ly/3fFvM18
   		$restrictions = $queryOrRepository->getRestrictions();
   		if ($ignoreStartEnd) {
   			$restrictions->removeByType( \TYPO3\CMS\Core\Database\Query\Restriction\StartTimeRestriction::class );
   			$restrictions->removeByType( \TYPO3\CMS\Core\Database\Query\Restriction\EndTimeRestriction::class );
   		}
   		if ($ignoreHidden) {
   			$hiddenRestrictionClass = \nn\t3::injectClass( \TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction::class );
   			$restrictions->removeByType( get_class( $hiddenRestrictionClass ) );
   		}
   		if ($ignoreDeleted) {
   			$deletedRestrictionClass = \nn\t3::injectClass( \TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction::class );
   			$restrictions->removeByType( get_class($deletedRestrictionClass) );
   		}
   		return $queryOrRepository;
   	} else {
   		$query = $queryOrRepository->createQuery();
   	}
   	$querySettings = $query->getQuerySettings();
   	$ignoreHidden = $ignoreHidden === true ? true : $querySettings->getIgnoreEnableFields();
   	$ignoreDeleted = $ignoreDeleted === true ? true : $querySettings->getIncludeDeleted();
   	$querySettings->setRespectStoragePage( !$ignoreStoragePid );
   	$querySettings->setIgnoreEnableFields( $ignoreHidden );
   	$querySettings->setIncludeDeleted( $ignoreDeleted );
   	if (!$isQueryObject) {
   		$queryOrRepository->setDefaultQuerySettings( $querySettings );
   	}
   	return $query;
   }
   

