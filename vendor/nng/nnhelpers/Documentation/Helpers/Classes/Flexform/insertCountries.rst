
.. include:: ../../../../Includes.txt

.. _Flexform-insertCountries:

==============================================
Flexform::insertCountries()
==============================================

\\nn\\t3::Flexform()->insertCountries(``$config, $a = NULL``);
----------------------------------------------

Inserts options from TypoScript for selection in a FlexForm or TCA.

.. code-block:: php

	
	    select
	    
	    nn\t3\Flexform->insertCountries
	    1
	

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
   

