
.. include:: ../../../../Includes.txt

.. _Environment-setRequest:

==============================================
Environment::setRequest()
==============================================

\\nn\\t3::Environment()->setRequest(``$request``);
----------------------------------------------

Setzt den aktuellen Request.
Wird in der ``RequestParser``-MiddleWare gesetzt

.. code-block:: php

	\nn\t3::Environment()->setRequest( $request );

| ``@param \TYPO3\CMS\Core\Http\ServerRequest``
| ``@return self``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setRequest(&$request)
   {
   	return $this->TYPO3_REQUEST = $request;
   }
   

