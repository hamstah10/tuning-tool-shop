
.. include:: ../../../../Includes.txt

.. _TCA-getRteTCAConfig:

==============================================
TCA::getRteTCAConfig()
==============================================

\\nn\\t3::TCA()->getRteTCAConfig();
----------------------------------------------

Get RTE configuration for the TCA.

.. code-block:: php

	'config' => \nn\t3::TCA()->getRteTCAConfig(),

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getRteTCAConfig()
   {
   	return [
   		'type' => 'text',
   		'enableRichtext' => true,
   	];
   }
   

