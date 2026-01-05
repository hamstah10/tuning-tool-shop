
.. include:: ../../../../Includes.txt

.. _Template-getVariables:

==============================================
Template::getVariables()
==============================================

\\nn\\t3::Template()->getVariables(``$view``);
----------------------------------------------

Holt die Variables des aktuellen Views, sprich:
Alles, was per assign() und assignMultiple() gesetzt wurde.

Im ViewHelper:

.. code-block:: php

	\nn\t3::Template()->getVariables( $renderingContext );

Im Controller:

.. code-block:: php

	\nn\t3::Template()->getVariables( $this->view );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getVariables( &$view )
   {
   	$context = $view;
   	if (method_exists($context, 'getRenderingContext')) {
   		$context = $view->getRenderingContext();
   	}
   	return $context->getVariableProvider()->getSource() ?: [];
   }
   

