
.. include:: ../../../../Includes.txt

.. _TCA-getRteTCAConfig:

==============================================
TCA::getRteTCAConfig()
==============================================

\\nn\\t3::TCA()->getRteTCAConfig();
----------------------------------------------

RTE Konfiguration für das TCA holen.

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
   

