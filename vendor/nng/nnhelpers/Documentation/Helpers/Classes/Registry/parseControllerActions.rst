
.. include:: ../../../../Includes.txt

.. _Registry-parseControllerActions:

==============================================
Registry::parseControllerActions()
==============================================

\\nn\\t3::Registry()->parseControllerActions(``$controllerActionList = []``);
----------------------------------------------

Parse list with ``'ControllerName' => 'action,list,show'``
Always specify the full class path in the ``::class`` notation.
Take into account that before Typo3 10 only the simple class name (e.g. ``Main``)
is used as the key.

.. code-block:: php

	\nn\t3::Registry()->parseControllerActions(
	    [\Nng\ExtName\Controller\MainController::class => 'index,list'],
	);

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function parseControllerActions( $controllerActionList = [] )
   {
   	return $controllerActionList;
   }
   

