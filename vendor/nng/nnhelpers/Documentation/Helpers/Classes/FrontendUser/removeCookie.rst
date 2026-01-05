
.. include:: ../../../../Includes.txt

.. _FrontendUser-removeCookie:

==============================================
FrontendUser::removeCookie()
==============================================

\\nn\\t3::FrontendUser()->removeCookie();
----------------------------------------------

Manually delete the current ``fe_typo_user cookie``

.. code-block:: php

	\nn\t3::FrontendUser()->removeCookie()

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function removeCookie()
   {
   	$cookieName = $this->getCookieName();
   	\nn\t3::Cookies()->add( $cookieName, '', -1 );
   }
   

