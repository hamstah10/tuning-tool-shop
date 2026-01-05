
.. include:: ../../../../Includes.txt

.. _Environment-getRequest:

==============================================
Environment::getRequest()
==============================================

\\nn\\t3::Environment()->getRequest();
----------------------------------------------

Fetches the current request.
Workaround for special cases - and in the event that the core team
does not implement this option itself in the future.

.. code-block:: php

	$request = \nn\t3::Environment()->getRequest();

| ``@return \TYPO3\CMS\Core\Http\ServerRequest``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getRequest()
   {
   	$request = $GLOBALS['TYPO3_REQUEST'] ?? null ?: $this->TYPO3_REQUEST;
   	if ($request) return $request;
   	$request = $this->getSyntheticFrontendRequest();
   	return $this->TYPO3_REQUEST = $request;
   }
   

