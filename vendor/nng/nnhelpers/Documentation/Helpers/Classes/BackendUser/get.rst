
.. include:: ../../../../Includes.txt

.. _BackendUser-get:

==============================================
BackendUser::get()
==============================================

\\nn\\t3::BackendUser()->get();
----------------------------------------------

Gets the current backend user.
Corresponds to ``$GLOBALS['BE_USER']`` in previous Typo3 versions.

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
   

