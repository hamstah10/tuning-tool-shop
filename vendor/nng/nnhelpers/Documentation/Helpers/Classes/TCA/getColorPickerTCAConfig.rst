
.. include:: ../../../../Includes.txt

.. _TCA-getColorPickerTCAConfig:

==============================================
TCA::getColorPickerTCAConfig()
==============================================

\\nn\\t3::TCA()->getColorPickerTCAConfig();
----------------------------------------------

Get color picker configuration for the TCA.

.. code-block:: php

	'config' => \nn\t3::TCA()->getColorPickerTCAConfig(),

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getColorPickerTCAConfig()
   {
   	return [
   		'type' => 'input',
   		'renderType' => 'colorpicker',
   		'size' => 10,
   	];
   }
   

