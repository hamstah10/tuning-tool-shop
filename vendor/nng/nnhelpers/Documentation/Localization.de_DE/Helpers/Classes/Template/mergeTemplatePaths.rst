
.. include:: ../../../../Includes.txt

.. _Template-mergeTemplatePaths:

==============================================
Template::mergeTemplatePaths()
==============================================

\\nn\\t3::Template()->mergeTemplatePaths(``$defaultTemplatePaths = [], $additionalTemplatePaths = []``);
----------------------------------------------

Pfade zu Templates, Partials, Layout mergen

.. code-block:: php

	\nn\t3::Template()->mergeTemplatePaths( $defaultTemplatePaths, $additionalTemplatePaths );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function mergeTemplatePaths ( $defaultTemplatePaths = [], $additionalTemplatePaths = [] ) {
   	$pathsToMerge = ['templateRootPaths', 'partialRootPaths', 'layoutRootPaths'];
   	foreach ($pathsToMerge as $field) {
   		if ($paths = $additionalTemplatePaths[$field] ?? false) {
   			if (!isset($defaultTemplatePaths[$field])) {
   				$defaultTemplatePaths[$field] = [];
   			}
   			ArrayUtility::mergeRecursiveWithOverrule($defaultTemplatePaths[$field], $paths);
   		}
   	}
   	if ($path = $additionalTemplatePaths['template'] ?? false) {
   		$defaultTemplatePaths['template'] = $path;
   	}
   	return $defaultTemplatePaths;
   }
   

