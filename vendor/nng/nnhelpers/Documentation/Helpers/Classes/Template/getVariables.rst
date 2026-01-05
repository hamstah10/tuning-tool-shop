
.. include:: ../../../../Includes.txt

.. _Template-getVariables:

==============================================
Template::getVariables()
==============================================

\\nn\\t3::Template()->getVariables(``$view``);
----------------------------------------------

Retrieves the variables of the current view, i.e:
Everything that was set via assign() and assignMultiple().

In the ViewHelper:

.. code-block:: php

	\nn\t3::Template()->getVariables( $renderingContext );

In the controller:

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
   

