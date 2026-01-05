
.. include:: ../../../../Includes.txt

.. _FrontendUser-getSessionData:

==============================================
FrontendUser::getSessionData()
==============================================

\\nn\\t3::FrontendUser()->getSessionData(``$key = NULL``);
----------------------------------------------

Get session data for FE users

.. code-block:: php

	\nn\t3::FrontendUser()->getSessionData('store')

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getSessionData( $key = null )
   {
   	$session = $this->getSession();
   	if (!$session) return $key ? '' : [];
   	return $session->get( $key ) ?? [];
   }
   

