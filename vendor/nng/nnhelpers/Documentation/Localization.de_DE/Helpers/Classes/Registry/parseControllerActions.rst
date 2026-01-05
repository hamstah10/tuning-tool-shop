
.. include:: ../../../../Includes.txt

.. _Registry-parseControllerActions:

==============================================
Registry::parseControllerActions()
==============================================

\\nn\\t3::Registry()->parseControllerActions(``$controllerActionList = []``);
----------------------------------------------

Liste mit ``'ControllerName' => 'action,list,show'`` parsen.
Immer den vollen Klassen-Pfad in der ``::class`` Schreibweise angeben.
Berücksichtigt, dass vor Typo3 10 nur der einfache Klassen-Name (z.B. ``Main``)
als Key verwendet wird.

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
   

