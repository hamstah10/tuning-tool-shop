
.. include:: ../../../../Includes.txt

.. _Obj-getClassSchema:

==============================================
Obj::getClassSchema()
==============================================

\\nn\\t3::Obj()->getClassSchema(``$modelClassName = NULL``);
----------------------------------------------

Infos zum classSchema eines Models holen

.. code-block:: php

	\nn\t3::Obj()->getClassSchema( \My\Model\Name::class );
	\nn\t3::Obj()->getClassSchema( $myModel );

return DataMap

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getClassSchema( $modelClassName = null )
   {
   	if (is_object($modelClassName)) {
   		$modelClassName = get_class( $modelClassName );
   	}
   	if ($cache = \nn\t3::Cache()->get($modelClassName, true)) {
   		return $cache;
   	}
   	$reflectionService = GeneralUtility::makeInstance( ReflectionService::class);
   	$schema = $reflectionService->getClassSchema($modelClassName);
   	return \nn\t3::Cache()->set( $modelClassName, $schema, true );
   }
   

