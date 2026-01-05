
.. include:: ../../../../Includes.txt

.. _Convert-toModel:

==============================================
Convert::toModel()
==============================================

\\nn\\t3::Convert()->toModel(``$className = NULL, $parentModel = NULL``);
----------------------------------------------

Converts an array into a model.

.. code-block:: php

	\nn\t3::Convert($array)->toModel( \Nng\Model\Name::class ) => \Nng\Model\Name

Can also automatically generate FileReferences.
In this example, a new model of the type ``\Nng\Model\Name`` is created and then
then persisted in the database. The ``falMedia`` field is an ObjectStorage
with ``FileReferences``. The FileReferences are created automatically!

.. code-block:: php

	$data = [
	    'pid' => 6,
	    'title' => 'New data record',
	    'description' => 'The text',
	    'falMedia' => [
	        ['title'=>'Image 1', 'publicUrl'=>'fileadmin/_tests/5e505e6b6143a.jpg'],
	        ['title'=>'Image 2', 'publicUrl'=>'fileadmin/_tests/5e505fbf5d3dd.jpg'],
	        ['title'=>'Image 3', 'publicUrl'=>'fileadmin/_tests/5e505f435061e.jpg'],
	    ]
	];
	$newModel = \nn\t3::Convert( $data )->toModel( \Nng\Model\Name::class );
	$modelRepository->add( $newModel );
	\nn\t3::Db()->persistAll();

Example: Create a news model from an array:

.. code-block:: php

	$entry = [
	    'pid' => 12,
	    'title' => 'News title',
	    'description' =>'My news',
	    'falMedia' => [['publicUrl' => 'fileadmin/image.jpg', 'title'=>'Image'], ...],
	    'categories' => [1, 2]
	];
	$model = \nn\t3::Convert( $entry )->toModel( \GeorgRinger\News\Domain\Model\News::class );
	$newsRepository->add( $model );
	\nn\t3::Db()->persistAll();

Hint
To update an existing model with data from an array, there is the method
there is the method ``$updatedModel = \nn\t3::Obj( $prevModel )->merge( $data );``

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
   

