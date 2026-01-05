
.. include:: ../../../../Includes.txt

.. _Template-removeControllerPath:

==============================================
Template::removeControllerPath()
==============================================

\\nn\\t3::Template()->removeControllerPath(``$view``);
----------------------------------------------

Entfernt den Pfad des Controller-Names z.B. /Main/...
aus der Suche nach Templates.

.. code-block:: php

	\nn\t3::Template()->removeControllerPath( $this->view );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function removeControllerPath( &$view ) {
   	$view->getRenderingContext()->setControllerName('');
   }
   

