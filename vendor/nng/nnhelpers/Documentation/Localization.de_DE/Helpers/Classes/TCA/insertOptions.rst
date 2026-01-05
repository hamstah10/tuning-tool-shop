
.. include:: ../../../../Includes.txt

.. _TCA-insertOptions:

==============================================
TCA::insertOptions()
==============================================

\\nn\\t3::TCA()->insertOptions(``$config, $a = NULL``);
----------------------------------------------

Fügt Optionen aus TypoScript zur Auswahl in ein TCA ein.
Alias zu \nn\t3::Flexform->insertOptions( $config, $a = null );
Beschreibung und weitere Beispiele dort.

Beispiel im TCA:

.. code-block:: php

	'config' => [
	    'type' => 'select',
	    'itemsProcFunc' => 'nn\t3\Flexform->insertOptions',
	    'typoscriptPath' => 'plugin.tx_nnnewsroom.settings.templates',
	    //'pageconfigPath' => 'tx_nnnewsroom.colors',
	]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function insertOptions ( $config, $a = null )
   {
   	return \nn\t3::Flexform()->insertOptions( $config, $a );
   }
   

