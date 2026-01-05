
.. include:: ../../../../Includes.txt

.. _BackendUser-getSettings:

==============================================
BackendUser::getSettings()
==============================================

\\nn\\t3::BackendUser()->getSettings(``$moduleName = 'nnhelpers', $path = NULL``);
----------------------------------------------

Holt userspezifische Einstellungen für den aktuell eingeloggten Backend-User.
Siehe ``\nn\t3::BackendUser()->updateSettings()`` zum Speichern der Daten.

.. code-block:: php

	\nn\t3::BackendUser()->getSettings('myext');                   // => ['wants'=>['drink'=>'coffee']]
	\nn\t3::BackendUser()->getSettings('myext', 'wants');        // => ['drink'=>'coffee']
	\nn\t3::BackendUser()->getSettings('myext', 'wants.drink');  // => 'coffee'

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getSettings( $moduleName = 'nnhelpers', $path = null )
   {
   	$data = $this->get()->uc[$moduleName] ?? [];
   	if (!$path) return $data;
   	return \nn\t3::Settings()->getFromPath( $path, $data );
   }
   

