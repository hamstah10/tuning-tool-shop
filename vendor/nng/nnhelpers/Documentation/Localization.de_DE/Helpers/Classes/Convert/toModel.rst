
.. include:: ../../../../Includes.txt

.. _Convert-toModel:

==============================================
Convert::toModel()
==============================================

\\nn\\t3::Convert()->toModel(``$className = NULL, $parentModel = NULL``);
----------------------------------------------

Konvertiert ein Array in ein Model.

.. code-block:: php

	\nn\t3::Convert($array)->toModel( \Nng\Model\Name::class )       => \Nng\Model\Name

Kann auch automatisch FileReferences erzeugen.
In diesem Bespiel wird ein neues Model des Typs ``\Nng\Model\Name`` erzeugt und
danach in der Datenbank persistiert. Das Feld ``falMedia`` ist eine ObjectStorage
mit ``FileReferences``. Die FileReferences werden automatisch erzeugt!

.. code-block:: php

	$data = [
	    'pid' => 6,
	    'title' => 'Neuer Datensatz',
	    'description' => 'Der Text',
	    'falMedia' => [
	        ['title'=>'Bild 1', 'publicUrl'=>'fileadmin/_tests/5e505e6b6143a.jpg'],
	        ['title'=>'Bild 2', 'publicUrl'=>'fileadmin/_tests/5e505fbf5d3dd.jpg'],
	        ['title'=>'Bild 3', 'publicUrl'=>'fileadmin/_tests/5e505f435061e.jpg'],
	    ]
	];
	$newModel = \nn\t3::Convert( $data )->toModel( \Nng\Model\Name::class );
	$modelRepository->add( $newModel );
	\nn\t3::Db()->persistAll();

Beispiel: Aus einem Array einen News-Model erzeugen:

.. code-block:: php

	$entry = [
	    'pid'             => 12,
	    'title'           => 'News-Titel',
	    'description' => '<p>Meine News</p>',
	    'falMedia'        => [['publicUrl' => 'fileadmin/bild.jpg', 'title'=>'Bild'], ...],
	    'categories'  => [1, 2]
	];
	$model = \nn\t3::Convert( $entry )->toModel( \GeorgRinger\News\Domain\Model\News::class );
	$newsRepository->add( $model );
	\nn\t3::Db()->persistAll();

Hinweis
Um ein bereits existierendes Model mit Daten aus einem Array zu aktualisieren gibt
es die Methode ``$updatedModel = \nn\t3::Obj( $prevModel )->merge( $data );``

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function toModel( $className = null, $parentModel = null ) {
   	$arr = $this->initialArgument;
   	$model = GeneralUtility::makeInstance( $className );
   	return \nn\t3::Obj($model)->merge( $arr );
   	# ToDo: Prüfen, warum der DataMapper hier nicht funktioniert. Model wird nicht persistiert!
   	# $dataMapper = GeneralUtility::makeInstance(DataMapper::class);
   	# return $dataMapper->map($model, [$arr]);
   }
   

