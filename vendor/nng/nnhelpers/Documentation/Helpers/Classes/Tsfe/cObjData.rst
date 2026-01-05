
.. include:: ../../../../Includes.txt

.. _Tsfe-cObjData:

==============================================
Tsfe::cObjData()
==============================================

\\nn\\t3::Tsfe()->cObjData(``$request = NULL, $var = NULL``);
----------------------------------------------

Get $GLOBALS['TSFE']->cObj->data.

.. code-block:: php

	\nn\t3::Tsfe()->cObjData( $this->request ); => array with DB-row of the current content element
	\nn\t3::Tsfe()->cObjData( $this->request, 'uid' ); => uid of the current content element

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function cObjData( $request = null, $var = null )
   {
   	if (is_string($request)) {
   		$var = $request;
   		$request = null;
   	}
   	if (!$request) {
   		$request = \nn\t3::Environment()->getRequest();
   	}
   	if (!$request) {
   		\nn\t3::Exception('
   			\nn\t3::Tsfe()->cObjData() needs a $request as first parameter.
   			In a Controller-Context use \nn\t3::Tsfe()->cObjData( $this->request ).
   			For other contexts see here: https://bit.ly/3s6dzF0');
   	}
   	$cObj = $this->cObj( $request );
   	if (!$cObj) return false;
   	return $var ? ($cObj->data[$var] ?? null) : ($cObj->data ?? []);
   }
   

