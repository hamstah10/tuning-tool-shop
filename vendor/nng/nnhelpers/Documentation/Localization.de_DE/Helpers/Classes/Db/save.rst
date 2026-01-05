
.. include:: ../../../../Includes.txt

.. _Db-save:

==============================================
Db::save()
==============================================

\\nn\\t3::Db()->save(``$tableNameOrModel = '', $data = []``);
----------------------------------------------

Datenbank-Eintrag erstellen ODER einen vorhandenen Datensatz updaten.

Entscheidet selbstständig, ob der Eintrag per ``UPDATE`` oder ``INSERT`` in die Datenbank
eingefügt bzw. ein vorhandener Datensatz aktualisiert werden muss. Die Daten werden
direkt persistiert!

Beispiel für Übergabe eines Tabellennamens und eines Arrays:

.. code-block:: php

	// keine uid übergeben? Dann INSERT eines neuen Datensatzes
	\nn\t3::Db()->save('table', ['bodytext'=>'...']);
	
	// uid übergeben? Dann UPDATE vorhandener Daten
	\nn\t3::Db()->save('table', ['uid'=>123, 'bodytext'=>'...']);

Beispiel für Übergabe eines Domain-Models:

.. code-block:: php

	// neues Model? Wird per $repo->add() eingefügt
	$model = new \My\Nice\Model();
	$model->setBodytext('...');
	$persistedModel = \nn\t3::Db()->save( $model );
	
	// vorhandenes Model? Wird per $repo->update() aktualisiert
	$model = $myRepo->findByUid(123);
	$model->setBodytext('...');
	$persistedModel = \nn\t3::Db()->save( $model );

| ``@param mixed $tableNameOrModel``
| ``@param array $data``
| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function save( $tableNameOrModel = '', $data = [] )
   {
   	if (\nn\t3::Obj()->isModel( $tableNameOrModel )) {
   		$uid = \nn\t3::Obj()->get( $tableNameOrModel, 'uid' ) ?: null;
   		$method = $uid ? 'update' : 'insert';
   	} else {
   		$uid = $data['uid'] ?? null;
   		$method = ($uid && $this->findByUid( $tableNameOrModel, $uid )) ? 'update' : 'insert';
   	}
   	return $this->$method( $tableNameOrModel, $data );
   }
   

