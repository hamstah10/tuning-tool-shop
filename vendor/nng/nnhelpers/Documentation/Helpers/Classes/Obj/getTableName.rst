
.. include:: ../../../../Includes.txt

.. _Obj-getTableName:

==============================================
Obj::getTableName()
==============================================

\\nn\\t3::Obj()->getTableName(``$modelClassName = NULL``);
----------------------------------------------

Returns the DB table name for a model

.. code-block:: php

	$model = new \Nng\MyExt\Domain\Model\Test;
	\nn\t3::Obj()->getTableName( $model ); // 'tx_myext_domain_model_test'
	\nn\t3::Obj()->getTableName( Test::class ); // 'tx_myext_domain_model_test'

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getTableName ( $modelClassName = null )
   {
   	if (is_object($modelClassName)) {
   		$modelClassName = get_class( $modelClassName );
   	}
   	$tableName = '';
   	$dataMapper = GeneralUtility::makeInstance( DataMapper::class );
   	try {
   		$tableName = $dataMapper->getDataMap($modelClassName)->getTableName();
   	} catch ( \Exception $e ) {
   	} catch ( \Error $e ) {
   		// silent
   	}
   	return $tableName;
   }
   

