
.. include:: ../../../../Includes.txt

.. _Environment-isFrontend:

==============================================
Environment::isFrontend()
==============================================

\\nn\\t3::Environment()->isFrontend();
----------------------------------------------

Check whether we are in the frontend context

.. code-block:: php

	    \nn\t3::Environment()->isFrontend();

| ``@return bool``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isFrontend () {
   	if ($this->_isFrontend !== null) {
   		return $this->_isFrontend;
   	}
   	$request = $this->getRequest();
   	if ($request instanceof ServerRequestInterface) {
   		return $this->_isFrontend = ApplicationType::fromRequest($request)->isFrontend();
   	}
   	return $this->_isFrontend = false;
   }
   

