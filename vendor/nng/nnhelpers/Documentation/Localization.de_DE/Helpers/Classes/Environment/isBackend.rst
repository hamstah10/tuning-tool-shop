
.. include:: ../../../../Includes.txt

.. _Environment-isBackend:

==============================================
Environment::isBackend()
==============================================

\\nn\\t3::Environment()->isBackend();
----------------------------------------------

Prüfen, ob wir uns im Backend-Context befinden

.. code-block:: php

	    \nn\t3::Environment()->isBackend();

| ``@return bool``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isBackend () {
   	return !$this->isFrontend();
   }
   

