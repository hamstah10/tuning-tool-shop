
.. include:: ../../../../Includes.txt

.. _BackendUser-get:

==============================================
BackendUser::get()
==============================================

\\nn\\t3::BackendUser()->get();
----------------------------------------------

Holt den aktuellen Backend-User.
Entspricht ``$GLOBALS['BE_USER']`` in früheren Typo3-Versionen.

.. code-block:: php

	\nn\t3::BackendUser()->get();

| ``@return \TYPO3\CMS\Backend\FrontendBackendUserAuthentication``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function get()
   {
   	return $GLOBALS['BE_USER'] ?? $this->start();
   }
   

