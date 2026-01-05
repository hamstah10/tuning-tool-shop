
.. include:: ../../../../Includes.txt

.. _Slug-create:

==============================================
Slug::create()
==============================================

\\nn\\t3::Slug()->create(``$model``);
----------------------------------------------

Generates a slug (URL path) for a model.
Automatically determines the TCA field for the slug.

.. code-block:: php

	\nn\t3::Slug()->create( $model );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function create( $model )
   {
   	if (!$model) return false;
   	\nn\t3::Db()->persistAll();
   	$uid = $model->getUid();
   	if (!$uid) return false;
   	$tableName = \nn\t3::Db()->getTableNameForModel( $model );
   	$record = \nn\t3::Db()->findByUid( $tableName, $uid, true);
   	$slugField = array_shift(\nn\t3::Db()->getColumnsByType( $tableName, 'slug' ));
   	$slugFieldName = $slugField['fieldName'] ?? false;
   	if (!$slugFieldName) return;
   	$fieldConfig = $slugField['config'];
   	$evalInfo = GeneralUtility::trimExplode(',', $fieldConfig['eval'], true);
   	$slugHelper = GeneralUtility::makeInstance( SlugHelper::class, $tableName, $slugFieldName, $fieldConfig );
   	$slug = $slugHelper->generate($record, $record['pid']);
   	$state = RecordStateFactory::forName($tableName)
   		->fromArray($record, $record['pid'], $record['uid']);
   	if (in_array('uniqueInSite', $evalInfo)) {
   		$slug = $slugHelper->buildSlugForUniqueInSite($slug, $state);
   	} else if (in_array('uniqueInPid', $evalInfo)) {
   		$slug = $slugHelper->buildSlugForUniqueInPid($slug, $state);
   	} else if (in_array('unique', $evalInfo)) {
   		$slug = $slugHelper->buildSlugForUniqueInTable($slug, $state);
   	}
   	\nn\t3::Obj()->set( $model, $slugFieldName, $slug );
   	\nn\t3::Db()->update( $tableName, [$slugFieldName=>$slug], $uid);
   	return $model;
   }
   

