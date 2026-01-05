
.. include:: ../../../../Includes.txt

.. _Environment-getRequest:

==============================================
Environment::getRequest()
==============================================

\\nn\\t3::Environment()->getRequest();
----------------------------------------------

Holt den aktuellen Request.
Workaround für Sonderfälle – und den Fall, dass das Core-Team
diese Option nicht in Zukunft selbst implementiert.

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
   

