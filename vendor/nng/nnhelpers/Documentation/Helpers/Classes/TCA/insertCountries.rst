
.. include:: ../../../../Includes.txt

.. _TCA-insertCountries:

==============================================
TCA::insertCountries()
==============================================

\\nn\\t3::TCA()->insertCountries(``$config, $a = NULL``);
----------------------------------------------

Inserts list of countries into a TCA.
Alias to \nn\t3::Flexform->insertCountries( $config, $a = null );
Description and further examples there.

Example in the TCA:

.. code-block:: php

	'config' => [
	    'type' => 'select',
	    'itemsProcFunc' => 'nn\t3\Flexform->insertCountries',
	    'insertEmpty' => true,
	]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function insertCountries( $config, $a = null )
   {
   	return \nn\t3::Flexform()->insertCountries( $config, $a );
   }
   

