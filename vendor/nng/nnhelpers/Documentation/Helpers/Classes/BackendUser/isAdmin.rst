
.. include:: ../../../../Includes.txt

.. _BackendUser-isAdmin:

==============================================
BackendUser::isAdmin()
==============================================

\\nn\\t3::BackendUser()->isAdmin();
----------------------------------------------

Checks whether the BE user is an admin.
Earlier: ``$GLOBALS['TSFE']->beUserLogin``

.. code-block:: php

	\nn\t3::BackendUser()->isAdmin();

| ``@return bool``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isAdmin()
   {
   	$context = GeneralUtility::makeInstance(Context::class);
   	return $context->getPropertyFromAspect('backend.user', 'isAdmin');
   }
   

