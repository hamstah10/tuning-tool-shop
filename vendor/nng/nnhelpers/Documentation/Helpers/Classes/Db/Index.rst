
.. include:: ../../../Includes.txt

.. _Db:

==============================================
Db
==============================================

\\nn\\t3::Db()
----------------------------------------------

Simplify access to the most frequently used database operations for writing, reading and deleting.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Db()->debug(``$query = NULL, $return = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Debug of the ``QueryBuilder statement``.

Outputs the complete, compiled query as a readable string, as it is later executed in the database
executed later in the database e.g. ``SELECT FROM fe_users WHERE ...``

.. code-block:: php

	// Output statement directly in the browser
	\nn\t3::Db()->debug( $query );
	
	// Return statement as a string, do not output automatically
	echo \nn\t3::Db()->debug( $query, true );

| ``@param mixed $query``
| ``@param boolean $return``
| ``@return string``

| :ref:`➜ Go to source code of Db::debug() <Db-debug>`

\\nn\\t3::Db()->delete(``$table = '', $constraint = [], $reallyDelete = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Delete database entry. Small and fine.
Either a table name and the UID can be transferred - or a model.

Delete a data record by table name and uid or any constraint:

.. code-block:: php

	// Deletion based on the uid
	\nn\t3::Db()->delete('table', $uid);
	
	// Delete using a custom field
	\nn\t3::Db()->delete('table', ['uid_local'=>$uid]);
	
	// Delete entry completely and irrevocably (do not just remove via flag deleted = 1)
	\nn\t3::Db()->delete('table', $uid, true);
	

Delete a data record per model:

.. code-block:: php

	\nn\t3::Db()->delete( $model );

| ``@param mixed $table``
| ``@param array $constraint``
| ``@param boolean $reallyDelete``
| ``@return mixed``

| :ref:`➜ Go to source code of Db::delete() <Db-delete>`

\\nn\\t3::Db()->deleteWithAllFiles(``$model``);
"""""""""""""""""""""""""""""""""""""""""""""""

The GDPR version of deletion.

Radical removal of all traces of a data set including the physical SysFiles,
linked to the model. To be used with caution, as no relations
are checked for the model to be deleted.

.. code-block:: php

	\nn\t3::deleteWithAllFiles( $model );

| ``@param \TYPO3\CMS\Extbase\DomainObject\AbstractEntity $model``
| ``@return void``

| :ref:`➜ Go to source code of Db::deleteWithAllFiles() <Db-deleteWithAllFiles>`

\\nn\\t3::Db()->filterDataForTable(``$data = [], $table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Only keep elements in key/val array whose keys also
exist in TCA for certain table

| ``@param array $data``
| ``@param string $table``
| ``@return array``

| :ref:`➜ Go to source code of Db::filterDataForTable() <Db-filterDataForTable>`

\\nn\\t3::Db()->findAll(``$table = '', $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Retrieves ALL entries from a database table.

The data is returned as an array - this is (unfortunately) still the absolute
most performant way to fetch many data records from a table, since no ``DataMapper``
has to parse the individual rows.

.. code-block:: php

	// Get all data records. "hidden" is taken into account.
	\nn\t3::Db()->findAll('fe_users');
	
	// Also fetch data records that are "hidden"
	\nn\t3::Db()->findAll('fe_users', true);

| ``@param string $table``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

| :ref:`➜ Go to source code of Db::findAll() <Db-findAll>`

\\nn\\t3::Db()->findByUid(``$table = '', $uid = NULL, $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Finds an entry based on the UID.
Also works if the frontend has not yet been initialized,
e.g. while AuthentificationService is running or in the scheduler.

.. code-block:: php

	\nn\t3::Db()->findByUid('fe_user', 12);
	\nn\t3::Db()->findByUid('fe_user', 12, true);

| ``@param string $table``
| ``@param int $uid``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

| :ref:`➜ Go to source code of Db::findByUid() <Db-findByUid>`

\\nn\\t3::Db()->findByUids(``$table = '', $uids = NULL, $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Finds entries using multiple UIDs.

.. code-block:: php

	\nn\t3::Db()->findByUids('fe_user', [12,13]);
	\nn\t3::Db()->findByUids('fe_user', [12,13], true);

| ``@param string $table``
| ``@param int|array $uids``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

| :ref:`➜ Go to source code of Db::findByUids() <Db-findByUids>`

\\nn\\t3::Db()->findByValues(``$table = NULL, $where = [], $useLogicalOr = false, $ignoreEnableFields = false, $fieldsToGet = [], $additionalQueryParams = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Finds ALL entries based on a desired field value.
Also works if the frontend has not yet been initialized.

.. code-block:: php

	// SELECT FROM fe_users WHERE email = 'david@99grad.de'
	\nn\t3::Db()->findByValues('fe_users', ['email'=>'david@99grad.de']);
	
	// SELECT FROM fe_users WHERE uid IN (1,2,3)
	\nn\t3::Db()->findByValues('fe_users', ['uid'=>[1,2,3]]);
	
	// SELECT uid, username FROM fe_users WHERE name = 'test'
	\nn\t3::Db()->findByValues('fe_users', ['name'=>'test'], false, false, ['uid', 'username']);
	
	// SELECT FROM fe_users WHERE name = 'test' LIMIT 1
	\nn\t3::Db()->findByValues('fe_users', ['name'=>'test'], false, false, false, ['limit'=>1]);
	
	// SELECT FROM fe_users WHERE name = 'test' LIMIT 2 OFFSET 3
	\nn\t3::Db()->findByValues('fe_users', ['name'=>'test'], false, false, false, ['limit'=>2, 'offset'=>3]);

| ``@param string $table``
| ``@param array $whereArr``
| ``@param boolean $useLogicalOr``
| ``@param boolean $ignoreEnableFields``
| ``@param array|boolean $fieldsToGet``
| ``@param array $additionalQueryParams``
| ``@return array``

| :ref:`➜ Go to source code of Db::findByValues() <Db-findByValues>`

\\nn\\t3::Db()->findIn(``$table = '', $column = '', $values = [], $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Finds ALL entries that contain a value from the ``$values`` array in the ``$column`` column.
Also works if the frontend has not yet been initialized.
Alias to ``\nn\t3::Db()->findByValues()``

.. code-block:: php

	// SELECT FROM fe_users WHERE uid IN (1,2,3)
	\nn\t3::Db()->findIn('fe_users', 'uid', [1,2,3]);
	
	// SELECT FROM fe_users WHERE username IN ('david', 'martin')
	\nn\t3::Db()->findIn('fe_users', 'username', ['david', 'martin']);

| ``@param string $table``
| ``@param string $column``
| ``@param array $values``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

| :ref:`➜ Go to source code of Db::findIn() <Db-findIn>`

\\nn\\t3::Db()->findNotIn(``$table = '', $colName = '', $values = [], $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Reversal of ``\nn\t3::Db()->findIn()``:

Finds ALL entries that do NOT contain a value from the ``$values`` array in the ``$column`` column.
Also works if the frontend has not yet been initialized.

.. code-block:: php

	// SELECT FROM fe_users WHERE uid NOT IN (1,2,3)
	\nn\t3::Db()->findNotIn('fe_users', 'uid', [1,2,3]);
	
	// SELECT FROM fe_users WHERE username NOT IN ('david', 'martin')
	\nn\t3::Db()->findNotIn('fe_users', 'username', ['david', 'martin']);

| ``@param string $table``
| ``@param string $colName``
| ``@param array $values``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

| :ref:`➜ Go to source code of Db::findNotIn() <Db-findNotIn>`

\\nn\\t3::Db()->findOneByValues(``$table = NULL, $whereArr = [], $useLogicalOr = false, $ignoreEnableFields = false, $fieldsToGet = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Finds ONE entry based on desired field values.

.. code-block:: php

	// SELECT FROM fe_users WHERE email = 'david@99grad.de'
	\nn\t3::Db()->findOneByValues('fe_users', ['email'=>'david@99grad.de']);
	
	// SELECT FROM fe_users WHERE firstname = 'david' AND username = 'john'
	\nn\t3::Db()->findOneByValues('fe_users', ['firstname'=>'david', 'username'=>'john']);
	
	// SELECT FROM fe_users WHERE firstname = 'david' OR username = 'john'
	\nn\t3::Db()->findOneByValues('fe_users', ['firstname'=>'david', 'username'=>'john'], true);
	
	// SELECT uid, name FROM fe_users WHERE firstname = 'david' OR username = 'john'
	\nn\t3::Db()->findOneByValues('fe_users', ['firstname'=>'david', 'username'=>'john'], true, false, ['uid', 'name']);

| ``@param string $table``
| ``@param array $whereArr``
| ``@param boolean $useLogicalOr``
| ``@param boolean $ignoreEnableFields``
| ``@param array $fieldsToGet``
| ``@return array``

| :ref:`➜ Go to source code of Db::findOneByValues() <Db-findOneByValues>`

\\nn\\t3::Db()->fixFileReferencesForModel(``$model``);
"""""""""""""""""""""""""""""""""""""""""""""""

"Repairs" the SysFileReferences for models that have a property
that only ``reference``a ``FileReference``instead of an ``ObjectStorage`` 
instead of a FileReference. At the moment, it is unclear why TYPO3 has included these
persists them in the table ``sys_file_reference``, but empties the field ``tablenames``
field Ã¢ or does not set ``uid_foreign``. With an ``ObjectStorage
the problem does not occur.``

.. code-block:: php

	// must happen directly after persisting the model
	\nn\t3::Db()->fixFileReferencesForModel( $model );

| :ref:`➜ Go to source code of Db::fixFileReferencesForModel() <Db-fixFileReferencesForModel>`

\\nn\\t3::Db()->get(``$uid, $modelType = '', $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get one or more domain models/entities using a ``uid``
A single ``$uid`` or a list of ``$uids`` can be passed.

Returns the "real" model/object including all relations,
analogous to a query via the repository.

.. code-block:: php

	// Get a single model by its uid
	$model = \nn\t3::Db()->get( 1, \Nng\MyExt\Domain\Model\Name::class );
	
	// Get an array of models based on their uids
	$modelArray = \nn\t3::Db()->get( [1,2,3], \Nng\MyExt\Domain\Model\Model\Name::class );
	
	// Also returns hidden models
	$modelArrayWithHidden = \nn\t3::Db()->get( [1,2,3], \Nng\MyExt\Domain\Model\Name::class, true );

| ``@param int $uid``
| ``@param string $modelType``
| ``@param boolean $ignoreEnableFields``
| ``@return Object``

| :ref:`➜ Go to source code of Db::get() <Db-get>`

\\nn\\t3::Db()->getColumn(``$table = '', $colName = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get a table column (TCA) for a specific table

.. code-block:: php

	\nn\t3::Db()->getColumn( 'tablename', 'fieldname' );

| ``@param string $table``
| ``@param string $colName``
| ``@param boolean $useSchemaManager``
| ``@return array``

| :ref:`➜ Go to source code of Db::getColumn() <Db-getColumn>`

\\nn\\t3::Db()->getColumnLabel(``$column = '', $table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get localized label of a specific TCA field

| ``@param string $column``
| ``@param string $table``
| ``@return string``

| :ref:`➜ Go to source code of Db::getColumnLabel() <Db-getColumnLabel>`

\\nn\\t3::Db()->getColumns(``$table = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get all table columns (TCA) for specific table

.. code-block:: php

	// Get fields based on the TCA array
	\nn\t3::Db()->getColumns( 'tablename' );
	
	// Determine fields via the SchemaManager
	\nn\t3::Db()->getColumns( 'tablename', true );

| ``@param string $table``
| ``@param boolean $useSchemaManager``
| ``@return array``

| :ref:`➜ Go to source code of Db::getColumns() <Db-getColumns>`

\\nn\\t3::Db()->getColumnsByType(``$table = '', $colType = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get fields of a table by a specific type

.. code-block:: php

	\nn\t3::Db()->getColumnsByType( 'tx_news_domain_model_news', 'slug' );

| ``@param string $table``
| ``@param string $colType``
| ``@param boolean $useSchemaManager``
| ``@return array``

| :ref:`➜ Go to source code of Db::getColumnsByType() <Db-getColumnsByType>`

\\nn\\t3::Db()->getConnection();
"""""""""""""""""""""""""""""""""""""""""""""""

Get a "raw" connection to the database.
Only useful in really exceptional cases.

.. code-block:: php

	$connection = \nn\t3::Db()->getConnection();
	$connection->fetchAll( 'SELECT FROM tt_news WHERE 1;' );

| ``@return \TYPO3\CMS\Core\Database\Connection``

| :ref:`➜ Go to source code of Db::getConnection() <Db-getConnection>`

\\nn\\t3::Db()->getDeleteColumn(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get delete column for specific table.

This column is used as a flag for deleted data records.
Normally: ``deleted`` = 1

| ``@param string $table``
| ``@return string``

| :ref:`➜ Go to source code of Db::getDeleteColumn() <Db-getDeleteColumn>`

\\nn\\t3::Db()->getQueryBuilder(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get QueryBuilder for a table

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( 'fe_users' );

Example:

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( 'fe_users' );
	$queryBuilder->select('name')->from( 'fe_users' );
	$queryBuilder->andWhere( $queryBuilder->expr()->eq( 'uid', $queryBuilder->createNamedParameter(12) ));
	$rows = $queryBuilder->executeStatement()->fetchAllAssociative();

| ``@param string $table``
| ``@return QueryBuilder``

| :ref:`➜ Go to source code of Db::getQueryBuilder() <Db-getQueryBuilder>`

\\nn\\t3::Db()->getRepositoryForModel(``$className = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get an instance of the repository for a model (or a model class name).

.. code-block:: php

	\nn\t3::Db()->getRepositoryForModel( \My\Domain\Model\Name::class );
	\nn\t3::Db()->getRepositoryForModel( $myModel );

| ``@param mixed $className``
| ``@return \TYPO3\CMS\Extbase\Persistence\Repository``

| :ref:`➜ Go to source code of Db::getRepositoryForModel() <Db-getRepositoryForModel>`

\\nn\\t3::Db()->getTableNameForModel(``$className = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get table name for a model (or a model class name).
Alias to ``\nn\t3::Obj()->getTableName()``

.. code-block:: php

	// tx_myext_domain_model_entry
	\nn\t3::Db()->getTableNameForModel( $myModel );
	
	// tx_myext_domain_model_entry
	\nn\t3::Db()->getTableNameForModel( \My\Domain\Model\Name::class );

| ``@param mixed $className``
| ``@return string``

| :ref:`➜ Go to source code of Db::getTableNameForModel() <Db-getTableNameForModel>`

\\nn\\t3::Db()->ignoreEnableFields(``$queryOrRepository, $ignoreStoragePid = true, $ignoreHidden = false, $ignoreDeleted = false, $ignoreStartEnd = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Removes default constraints for StoragePID, hidden and/or deleted
for a query or repository.

.. code-block:: php

	\nn\t3::Db()->ignoreEnableFields( $entryRepository );
	\nn\t3::Db()->ignoreEnableFields( $query );

Example for a custom query:

.. code-block:: php

	$table = 'tx_myext_domain_model_entry';
	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	$queryBuilder->select('uid','title','hidden')->from( $table );
	\nn\t3::Db()->ignoreEnableFields( $queryBuilder, true, true );
	$rows = $queryBuilder->executeQuery()->fetchAllAssociative();

If this is not enough or too complicated, see:

.. code-block:: php

	\nn\t3::Db()->statement();

| ``@param mixed $queryOrRepository``
| ``@param boolean $ignoreStoragePid``
| ``@param boolean $ignoreHidden``
| ``@param boolean $ignoreDeleted``
| ``@param boolean $ignoreStartEnd``
| ``@return mixed``

| :ref:`➜ Go to source code of Db::ignoreEnableFields() <Db-ignoreEnableFields>`

\\nn\\t3::Db()->insert(``$tableNameOrModel = '', $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Insert database entry. Simple and foolproof.
Either the table name and an array can be transferred - or a domain model.

Inserting a new data set via table name and data array:

.. code-block:: php

	$insertArr = \nn\t3::Db()->insert('table', ['bodytext'=>'...']);

Insert a new model. The repository is determined automatically.
The model is persisted directly.

.. code-block:: php

	$model = new \My\Nice\Model();
	$persistedModel = \nn\t3::Db()->insert( $model );

| ``@param mixed $tableNameOrModel``
| ``@param array $data``
| ``@return mixed``

| :ref:`➜ Go to source code of Db::insert() <Db-insert>`

\\nn\\t3::Db()->insertMultiple(``$tableName = '', $rows = [], $colOrder = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Insert several lines into database.

.. code-block:: php

	use TYPO3\CMS\Core\Database\Connection;
	
	$data = [
	    ['title' => 'One', 'tstamp'=>123],
	    ['title' => 'Two', 'tstamp'=>123],
	];
	$colOrder = [
	    'tstamp' => Connection::PARAM_INT,
	    'title' => Connection::PARAM_STR,
	];
	
	\nn\t3::Db()->insertMultiple('table', $data, $colOrder);

| ``@param string $tableName``
| ``@param array $rows``
| ``@param array $colOrder``
| ``@return boolean``

| :ref:`➜ Go to source code of Db::insertMultiple() <Db-insertMultiple>`

\\nn\\t3::Db()->insertOrUpdate(``$tableName, $whereArr = [], $model = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Store an item in the database, but keep it unique by $whereArr = []

.. code-block:: php

	$data = [ profileUid: "", entityType: "", entityUid: "", ... ];
	\nn\un::Interaction()->insertOrUpdate( $data );

| ``@param int $feUserId``
| ``@param array $data``
| ``@return array $model``

| :ref:`➜ Go to source code of Db::insertOrUpdate() <Db-insertOrUpdate>`

\\nn\\t3::Db()->orderBy(``$queryOrRepository, $ordering = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

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

| :ref:`➜ Go to source code of Db::orderBy() <Db-orderBy>`

\\nn\\t3::Db()->persistAll();
"""""""""""""""""""""""""""""""""""""""""""""""

Persist all.

.. code-block:: php

	\nn\t3::Db()->persistAll();

| ``@return void``

| :ref:`➜ Go to source code of Db::persistAll() <Db-persistAll>`

\\nn\\t3::Db()->quote(``$value = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

A replacement for the ``mysqli_real_escape_string()`` method.

Should only be used in an emergency for low-level queries.
It is better to use ``preparedStatements``.

Only works with SQL, not with DQL.

.. code-block:: php

	$sword = \nn\t3::Db()->quote('test'); // => 'test'
	$sword = \nn\t3::Db()->quote("test';SET"); // => 'test\';SET'
	$sword = \nn\t3::Db()->quote([1, 'test', '2']); // => [1, "'test'", '2']
	$sword = \nn\t3::Db()->quote('"; DROP TABLE fe_user;#');

| ``@param string|array $value``
| ``@return string|array``

| :ref:`➜ Go to source code of Db::quote() <Db-quote>`

\\nn\\t3::Db()->save(``$tableNameOrModel = '', $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Create database entry OR update an existing data record.

Decides independently whether the entry should be added to the database via ``UPDATE`` or ``INSERT`` 
or whether an existing data record needs to be updated. The data is
persisted directly!

Example for transferring a table name and an array:

.. code-block:: php

	// no uid transferred? Then INSERT a new data set
	\nn\t3::Db()->save('table', ['bodytext'=>'...']);
	
	// pass uid? Then UPDATE existing data
	\nn\t3::Db()->save('table', ['uid'=>123, 'bodytext'=>'...']);

Example for transferring a domain model:

.. code-block:: php

	// new model? Is inserted via $repo->add()
	$model = new \My\Nice\Model();
	$model->setBodytext('...');
	$persistedModel = \nn\t3::Db()->save( $model );
	
	// existing model? Is updated via $repo->update()
	$model = $myRepo->findByUid(123);
	$model->setBodytext('...');
	$persistedModel = \nn\t3::Db()->save( $model );

| ``@param mixed $tableNameOrModel``
| ``@param array $data``
| ``@return mixed``

| :ref:`➜ Go to source code of Db::save() <Db-save>`

\\nn\\t3::Db()->setFalConstraint(``$queryBuilder = NULL, $tableName = '', $falFieldName = '', $numFal = true, $operator = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Add constraint for sys_file_reference to a QueryBuilder.
Restricts the results to whether there is a FAL relation.

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	
	// Only fetch datasets that have at least one SysFileReference for falfield
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield' );
	
	// ... that do NOT have a SysFileReference for falfield
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', false );
	
	// ... which have EXACTLY 2 SysFileReferences
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', 2 );
	
	// ... that have 2 or less (less than or equal) SysFileReferences
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', 2, 'lte' );

| ``@param \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder``
| ``@param string $tableName``
| ``@param string $falFieldName``
| ``@param boolean $numFal``
| ``@param boolean $operator``
| ``@return \TYPO3\CMS\Core\Database\Query\QueryBuilder``

| :ref:`➜ Go to source code of Db::setFalConstraint() <Db-setFalConstraint>`

\\nn\\t3::Db()->setNotInSysCategoryConstraint(``$queryBuilder = NULL, $sysCategoryUids = [], $tableName = '', $categoryFieldName = 'categories'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Restrict constraint to records that are NOT in one of the specified categories.
Opposite and alias to ``\nn\t3::Db()->setSysCategoryConstraint()``

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	\nn\t3::Db()->setNotInSysCategoryConstraint( $queryBuilder, [1,3,4], 'tx_myext_tablename', 'categories' );

| ``@param \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder``
| ``@param array $sysCategoryUids``
| ``@param string $tableName``
| ``@param string $categoryFieldName``
| ``@return \TYPO3\CMS\Core\Database\Query\QueryBuilder``

| :ref:`➜ Go to source code of Db::setNotInSysCategoryConstraint() <Db-setNotInSysCategoryConstraint>`

\\nn\\t3::Db()->setSysCategoryConstraint(``$queryBuilder = NULL, $sysCategoryUids = [], $tableName = '', $categoryFieldName = 'categories', $useNotIn = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Add constraint for sys_category / sys_category_record_mm to a QueryBuilder.
Restricts the results to the specified sys_categories UIDs.

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	\nn\t3::Db()->setSysCategoryConstraint( $queryBuilder, [1,3,4], 'tx_myext_tablename', 'categories' );

| ``@param \TYPO3\CMS\Core\Database\Query\QueryBuilder $querybuilder``
| ``@param array $sysCategoryUids``
| ``@param string $tableName``
| ``@param string $categoryFieldName``
| ``@param boolean $useNotIn``
| ``@return \TYPO3\CMS\Core\Database\Query\QueryBuilder``

| :ref:`➜ Go to source code of Db::setSysCategoryConstraint() <Db-setSysCategoryConstraint>`

\\nn\\t3::Db()->sortBy(``$objectArray, $fieldName = 'uid', $uidList = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sorts the results of a query according to an array and a specific field.
Solves the problem that an ``->in()`` query does not return the results
in the order of the passed IDs. Example:
| ``$query->matching($query->in('uid', [3,1,2]));`` does not necessarily come
return in the order ``[3,1,2]``.

.. code-block:: php

	$insertArr = \nn\t3::Db()->sortBy( $storageOrArray, 'uid', [2,1,5]);

| ``@param mixed $objectArray``
| ``@param string $fieldName``
| ``@param array $uidList``
| ``@return array``

| :ref:`➜ Go to source code of Db::sortBy() <Db-sortBy>`

\\nn\\t3::Db()->statement(``$statement = '', $params = [], $types = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Send a "raw" query to the database.
Closer to the database is not possible. You are responsible for everything yourself.
Injections are only opposed by your (hopefully sufficient :) intelligence.

Helps, for example, with queries of tables that are not part of the Typo3 installation and
therefore could not be reached via the normal QueryBuilder.

.. code-block:: php

	// ALWAYS escape variables via!
	$keyword = \nn\t3::Db()->quote('search term');
	$rows = \nn\t3::Db()->statement( "SELECT FROM tt_news WHERE bodytext LIKE '%{$keyword}%'");
	
	// or better use prepared statements:
	$rows = \nn\t3::Db()->statement( 'SELECT FROM tt_news WHERE bodytext LIKE :str', ['str'=>"%{$keyword}%"] );
	
	// Types can be passed (this is determined automatically for arrays)
	$rows = \nn\t3::Db()->statement( 'SELECT FROM tt_news WHERE uid IN (:uids)', ['uids'=>[1,2,3]], ['uids'=>Connection::PARAM_INT_ARRAY] );

With a ``SELECT`` statement, the rows from the database are returned as an array.
For all other statements (e.g. ``UPDATE`` or ``DELETE``), the number of affected rows is returned.

| ``@param string $statement``
| ``@param array $params``
| ``@param array $types``
| ``@return mixed``

| :ref:`➜ Go to source code of Db::statement() <Db-statement>`

\\nn\\t3::Db()->tableExists(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Does a specific DB table exist?

.. code-block:: php

	$exists = \nn\t3::Db()->tableExists('table');

| ``@return boolean``

| :ref:`➜ Go to source code of Db::tableExists() <Db-tableExists>`

\\nn\\t3::Db()->truncate(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Empty database table.
Deletes all entries in the specified table and resets the auto-increment value to ``0``.

.. code-block:: php

	\nn\t3::Db()->truncate('table');

| ``@param string $table``
| ``@return boolean``

| :ref:`➜ Go to source code of Db::truncate() <Db-truncate>`

\\nn\\t3::Db()->undelete(``$table = '', $constraint = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Restore deleted database entry.
To do this, the flag for "``deleted``" is set to ``0`` again.

.. code-block:: php

	\nn\t3::Db()->undelete('table', $uid);
	\nn\t3::Db()->undelete('table', ['uid_local'=>$uid]);

| ``@param string $table``
| ``@param array $constraint``
| ``@return boolean``

| :ref:`➜ Go to source code of Db::undelete() <Db-undelete>`

\\nn\\t3::Db()->update(``$tableNameOrModel = '', $data = [], $uid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Update database entry. Quick and easy.
The update can be done either by table name and data array.
Or you can pass a model.

Examples:

.. code-block:: php

	// UPDATES table SET title='new' WHERE uid=1
	\nn\t3::Db()->update('table', ['title'=>'new'], 1);
	
	// UPDATES table SET title='new' WHERE uid IN (1,2,3)
	\nn\t3::Db()->update('table', ['title'=>'new'], ['uid'=>[1,2,3]);
	
	// UPDATE table SET title='new' WHERE email='david@99grad.de' AND pid=12
	\nn\t3::Db()->update('table', ['title'=>'new'], ['email'=>'david@99grad.de', 'pid'=>12, ...]);

With ``true`` instead of a ``$uid`` ALL records of the table are updated.

.. code-block:: php

	// UPDATE table SET test='1' WHERE 1
	\nn\t3::Db()->update('table', ['test'=>1], true);

Instead of a table name, a simple model can also be passed.
The repository is determined automatically and the model is persisted directly.

.. code-block:: php

	$model = $myRepo->findByUid(1);
	\nn\t3::Db()->update( $model );

| ``@param mixed $tableNameOrModel``
| ``@param array $data``
| ``@param int $uid``
| ``@return mixed``

| :ref:`➜ Go to source code of Db::update() <Db-update>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
