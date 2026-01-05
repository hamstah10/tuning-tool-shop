
.. include:: ../../../../Includes.txt

.. _FrontendUser-getCurrentUserUid:

==============================================
FrontendUser::getCurrentUserUid()
==============================================

\\nn\\t3::FrontendUser()->getCurrentUserUid();
----------------------------------------------

Get UID of the current frontend user

.. code-block:: php

	$uid = \nn\t3::FrontendUser()->getCurrentUserUid();

| ``@return int``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getCurrentUserUid()
   {
   	if (!($user = $this->getCurrentUser())) return null;
   	return $user['uid'];
   }
   

