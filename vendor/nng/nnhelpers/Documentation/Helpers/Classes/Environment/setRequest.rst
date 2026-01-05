
.. include:: ../../../../Includes.txt

.. _Environment-setRequest:

==============================================
Environment::setRequest()
==============================================

\\nn\\t3::Environment()->setRequest(``$request``);
----------------------------------------------

Sets the current request.
Is set in the ``RequestParser middleware``

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
   

