
.. include:: ../../../../Includes.txt

.. _BackendUser-updateSettings:

==============================================
BackendUser::updateSettings()
==============================================

\\nn\\t3::BackendUser()->updateSettings(``$moduleName = 'nnhelpers', $settings = []``);
----------------------------------------------

Saves user-specific settings for the currently logged in backend user.
These settings are also available again for the user after logout/login.
See ``\nn\t3::BackendUser()->getSettings('myext')`` to read the data.

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
   

