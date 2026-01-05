
.. include:: ../../../../Includes.txt

.. _FrontendUser-setSessionData:

==============================================
FrontendUser::setSessionData()
==============================================

\\nn\\t3::FrontendUser()->setSessionData(``$key = NULL, $val = NULL, $merge = true``);
----------------------------------------------

Set session data for FE user

.. code-block:: php

	// Merge session data for `shop` with new data (existing keys in `shop` are not deleted)
	\nn\t3::FrontendUser()->setSessionData('store', ['a'=>1]);
	
	// Overwrite session data for `shop` (`a` from the example above is deleted)
	\nn\t3::FrontendUser()->setSessionData('store', ['b'=>1], false);

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
   

