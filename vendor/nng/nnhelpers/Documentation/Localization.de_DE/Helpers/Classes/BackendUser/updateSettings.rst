
.. include:: ../../../../Includes.txt

.. _BackendUser-updateSettings:

==============================================
BackendUser::updateSettings()
==============================================

\\nn\\t3::BackendUser()->updateSettings(``$moduleName = 'nnhelpers', $settings = []``);
----------------------------------------------

Speichert userspezifische Einstellungen für den aktuell eingeloggten Backend-User.
Diese Einstellungen sind auch nach Logout/Login wieder für den User verfügbar.
Siehe ``\nn\t3::BackendUser()->getSettings('myext')`` zum Auslesen der Daten.

.. code-block:: php

	\nn\t3::BackendUser()->updateSettings('myext', ['wants'=>['drink'=>'coffee']]);

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function updateSettings( $moduleName = 'nnhelpers', $settings = [] )
   {
   	if ($beUser = $this->get()) {
   		if (!isset($beUser->uc[$moduleName])) {
   			$beUser->uc[$moduleName] = [];
   		}
   		foreach ($settings as $k=>$v) {
   			$beUser->uc[$moduleName][$k] = $v;
   		}
   		$beUser->writeUC();
   		return $beUser->uc[$moduleName];
   	}
   	return [];
   }
   

