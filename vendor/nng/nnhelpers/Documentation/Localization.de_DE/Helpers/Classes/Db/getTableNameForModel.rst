
.. include:: ../../../../Includes.txt

.. _Db-getTableNameForModel:

==============================================
Db::getTableNameForModel()
==============================================

\\nn\\t3::Db()->getTableNameForModel(``$className = NULL``);
----------------------------------------------

Tabellen-Name für ein Model (oder einen Model-Klassennamen) holen.
Alias zu ``\nn\t3::Obj()->getTableName()``

.. code-block:: php

	// tx_myext_domain_model_entry
	\nn\t3::Db()->getTableNameForModel( $myModel );
	
	// tx_myext_domain_model_entry
	\nn\t3::Db()->getTableNameForModel( \My\Domain\Model\Name::class );

| ``@param mixed $className``
| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getTableNameForModel( $className = null )
   {
   	return \nn\t3::Obj()->getTableName( $className );
   }
   

