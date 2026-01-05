
.. include:: ../../../../Includes.txt

.. _FrontendUser-getSessionData:

==============================================
FrontendUser::getSessionData()
==============================================

\\nn\\t3::FrontendUser()->getSessionData(``$key = NULL``);
----------------------------------------------

Session-Data für FE-User holen

.. code-block:: php

	\nn\t3::FrontendUser()->getSessionData('shop')

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
   

