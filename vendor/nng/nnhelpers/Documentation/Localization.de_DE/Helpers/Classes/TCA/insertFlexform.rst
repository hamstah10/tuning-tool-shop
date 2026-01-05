
.. include:: ../../../../Includes.txt

.. _TCA-insertFlexform:

==============================================
TCA::insertFlexform()
==============================================

\\nn\\t3::TCA()->insertFlexform(``$path``);
----------------------------------------------

Fügt ein Flexform in ein TCA ein.

Beispiel im TCA:

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
   

