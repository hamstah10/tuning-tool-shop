
.. include:: ../../../../Includes.txt

.. _FrontendUser-get:

==============================================
FrontendUser::get()
==============================================

\\nn\\t3::FrontendUser()->get();
----------------------------------------------

Get the current FE user.
Alias to ``\nn\t3::FrontendUser()->getCurrentUser();``

.. code-block:: php

	\nn\t3::FrontendUser()->get();

Also exists as ViewHelper:

.. code-block:: php

	{nnt3:frontendUser.get(key:'first_name')}
	{nnt3:frontendUser.get()->f:variable.set(name:'feUser')}

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function get()
   {
   	return $this->getCurrentUser();
   }
   

