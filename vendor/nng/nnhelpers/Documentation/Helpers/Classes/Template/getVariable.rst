
.. include:: ../../../../Includes.txt

.. _Template-getVariable:

==============================================
Template::getVariable()
==============================================

\\nn\\t3::Template()->getVariable(``$view, $varname = ''``);
----------------------------------------------

Fetches ONE variable of the current view, i.e:
Everything that was set via assign() and assignMultiple().

In the ViewHelper:

.. code-block:: php

	\nn\t3::Template()->getVariable( $renderingContext, 'varname' );

In the controller:

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
   

