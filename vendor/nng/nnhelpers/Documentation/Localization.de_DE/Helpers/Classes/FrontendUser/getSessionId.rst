
.. include:: ../../../../Includes.txt

.. _FrontendUser-getSessionId:

==============================================
FrontendUser::getSessionId()
==============================================

\\nn\\t3::FrontendUser()->getSessionId();
----------------------------------------------

Session-ID des aktuellen Frontend-Users holen

.. code-block:: php

	$sessionId = \nn\t3::FrontendUser()->getSessionId();

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getSessionId()
   {
   	if ($session = $this->getSession()) {
   		if ($sessionId = $session->getIdentifier()) {
   			return $sessionId;
   		}
   	}
   	return $_COOKIE[$this->getCookieName()] ?? null;
   }
   

