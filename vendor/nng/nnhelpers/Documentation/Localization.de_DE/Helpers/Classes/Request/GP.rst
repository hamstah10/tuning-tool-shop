
.. include:: ../../../../Includes.txt

.. _Request-GP:

==============================================
Request::GP()
==============================================

\\nn\\t3::Request()->GP(``$varName = NULL``);
----------------------------------------------

Merge aus $_GET und $_POST-Variablen

.. code-block:: php

	\nn\t3::Request()->GP();

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function GP ( $varName = null )
   {
   	$gp = [];
   	if ($request = $GLOBALS['TYPO3_REQUEST'] ?? null) {
   		ArrayUtility::mergeRecursiveWithOverrule($gp, $request->getQueryParams() ?: []);
   		ArrayUtility::mergeRecursiveWithOverrule($gp, $request->getParsedBody() ?: []);
   	} else {
   		ArrayUtility::mergeRecursiveWithOverrule($gp, $_GET ?: []);
   		ArrayUtility::mergeRecursiveWithOverrule($gp, $_POST ?: []);
   	}
   	if ($varName) {
   		$val = \nn\t3::Settings()->getFromPath( $varName, $gp );
   		return $val ?? null;
   	}
   	return $gp;
   }
   

