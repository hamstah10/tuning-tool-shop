
.. include:: ../../../../Includes.txt

.. _TCA-insertFlexform:

==============================================
TCA::insertFlexform()
==============================================

\\nn\\t3::TCA()->insertFlexform(``$path``);
----------------------------------------------

Inserts a flex form into a TCA.

Example in the TCA:

.. code-block:: php

	'config' => \nn\t3::TCA()->insertFlexform('FILE:EXT:nnsite/Configuration/FlexForm/slickslider_options.xml');

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function insertFlexform( $path )
   {
   	return [
   		'type' 	=> 'flex',
   		'ds' 	=> ['default' => $path],
   	];
   }
   

