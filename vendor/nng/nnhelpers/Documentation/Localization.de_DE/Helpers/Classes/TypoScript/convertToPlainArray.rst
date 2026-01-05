
.. include:: ../../../../Includes.txt

.. _TypoScript-convertToPlainArray:

==============================================
TypoScript::convertToPlainArray()
==============================================

\\nn\\t3::TypoScript()->convertToPlainArray(``$ts``);
----------------------------------------------

TypoScript 'name.'-Syntax in normales Array umwandeln.
Erleichtert den Zugriff

.. code-block:: php

	\nn\t3::TypoScript()->convertToPlainArray(['example'=>'test', 'example.'=>'here']);

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function convertToPlainArray ($ts) {
   	if (!$ts || !is_array($ts)) return [];
   	$typoscriptService = \nn\t3::injectClass( TypoScriptService::class );
   	return $typoscriptService->convertTypoScriptArrayToPlainArray($ts);
   }
   

