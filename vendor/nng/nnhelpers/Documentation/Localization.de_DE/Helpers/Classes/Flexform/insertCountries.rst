
.. include:: ../../../../Includes.txt

.. _Flexform-insertCountries:

==============================================
Flexform::insertCountries()
==============================================

\\nn\\t3::Flexform()->insertCountries(``$config, $a = NULL``);
----------------------------------------------

Fügt Optionen aus TypoScript zur Auswahl in ein FlexForm oder TCA ein.

.. code-block:: php

	<config>
	    <type>select</type>
	    <items type="array"></items>
	    <itemsProcFunc>nn\t3\Flexform->insertCountries</itemsProcFunc>
	    <insertEmpty>1</insertEmpty>
	</config>

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function insertCountries ( $config, $a = null )
   {
   	if ($config['config']['insertEmpty'] ?? false) {
   		$config['items'] = array_merge( $config['items'], [['', '0', '']] );
   	}
   	$countriesByShortCode = \nn\t3::Environment()->getCountries() ?: [];
   	if (!$countriesByShortCode) {
   		$countriesByShortCode['DE'] = 'static_info_tables installieren!';
   	}
   	foreach ($countriesByShortCode as $cn => $title) {
   		$config['items'][] = [$title, $cn];
   	}
   	return $config;
   }
   

