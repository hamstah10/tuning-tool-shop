
.. include:: ../../../../Includes.txt

.. _Template-removeControllerPath:

==============================================
Template::removeControllerPath()
==============================================

\\nn\\t3::Template()->removeControllerPath(``$view``);
----------------------------------------------

Removes the path of the controller name, e.g. /Main/...
from the search for templates.

.. code-block:: php

	\nn\t3::Template()->removeControllerPath( $this->view );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function removeControllerPath( &$view ) {
   	$view->getRenderingContext()->setControllerName('');
   }
   

