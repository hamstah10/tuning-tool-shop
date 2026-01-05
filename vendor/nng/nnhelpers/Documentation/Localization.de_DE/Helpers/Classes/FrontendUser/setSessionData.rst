
.. include:: ../../../../Includes.txt

.. _FrontendUser-setSessionData:

==============================================
FrontendUser::setSessionData()
==============================================

\\nn\\t3::FrontendUser()->setSessionData(``$key = NULL, $val = NULL, $merge = true``);
----------------------------------------------

Session-Data für FE-User setzen

.. code-block:: php

	// Session-data für `shop` mit neuen Daten mergen (bereits existierende keys in `shop` werden nicht gelöscht)
	\nn\t3::FrontendUser()->setSessionData('shop', ['a'=>1]);
	
	// Session-data für `shop` überschreiben (`a` aus dem Beispiel oben wird gelöscht)
	\nn\t3::FrontendUser()->setSessionData('shop', ['b'=>1], false);

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setSessionData( $key = null, $val = null, $merge = true )
   {
   	$session = $this->getSession();
   	$sessionData = $merge ? $this->getSessionData( $key ) : [];
   	if (is_array($val)) {
   		ArrayUtility::mergeRecursiveWithOverrule( $sessionData, $val );
   	} else {
   		$sessionData = $val;
   	}
   	$session->set( $key, $sessionData );
   	$this->getFrontendUser()->storeSessionData();
   	return $sessionData;
   }
   

