
.. include:: ../../../../Includes.txt

.. _Request-mergeGetParams:

==============================================
Request::mergeGetParams()
==============================================

\\nn\\t3::Request()->mergeGetParams(``$url = '', $getParams = [], $dontNestArrays = false``);
----------------------------------------------

| ``@param string $url``
| ``@param array $getParams``
| ``@param bool $dontNestArrays``
| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function mergeGetParams( $url = '', $getParams = [], $dontNestArrays = false )
   {
   	$parts = parse_url($url);
   	$getP = [];
   	if ($parts['query'] ?? false) {
   		parse_str($parts['query'], $getP);
   	}
   	ArrayUtility::mergeRecursiveWithOverrule($getP, $getParams, true, true );
   	$uP = explode('?', $url);
   	$params = GeneralUtility::implodeArrayForUrl('', $getP);
   	if ($dontNestArrays) {
   		$params = preg_replace('/\[[0-9]*\]/', '', $params);
   	}
   	$outurl = $uP[0] . ($params ? '?' . substr($params, 1) : '');
   	return $outurl;
   }
   

