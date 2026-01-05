
.. include:: ../../../../Includes.txt

.. _Template-getVariable:

==============================================
Template::getVariable()
==============================================

\\nn\\t3::Template()->getVariable(``$view, $varname = ''``);
----------------------------------------------

Holt EINE Variables des aktuellen Views, sprich:
Alles, was per assign() und assignMultiple() gesetzt wurde.

Im ViewHelper:

.. code-block:: php

	\nn\t3::Template()->getVariable( $renderingContext, 'varname' );

Im Controller:

.. code-block:: php

	\nn\t3::Template()->getVariable( $this->view, 'varname' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getVariable( &$view, $varname = '' )
   {
   	$context = $view;
   	if (method_exists($context, 'getRenderingContext')) {
   		$context = $view->getRenderingContext();
   	}
   	return $context->getVariableProvider()->get($varname) ?: '';
   }
   

