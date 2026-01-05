
.. include:: ../../../../Includes.txt

.. _Environment-isBackend:

==============================================
Environment::isBackend()
==============================================

\\nn\\t3::Environment()->isBackend();
----------------------------------------------

Check whether we are in the backend context

.. code-block:: php

	    \nn\t3::Environment()->isBackend();

| ``@return bool``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isBackend () {
   	return !$this->isFrontend();
   }
   

