
.. include:: ../../../../Includes.txt

.. _AnnotationHelper-parse:

==============================================
AnnotationHelper::parse()
==============================================

\\nn\\t3::AnnotationHelper()->parse(``$rawAnnotation = '', $namespaces = []``);
----------------------------------------------

Annotations parsen und ein Array mit dem "normalen" Kommentarblock und den
einzelnen Annotations aus einem DocComment zurückgeben.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\AnnotationHelper::parse( '...' );

Nur Annotations holen, die in einem bestimmten Namespace sind.
In diesem Beispiel werden nur Annotations geholt, die mit ``@nn\rest``
beginnen, z.B. ``@nn\rest\access ...``

.. code-block:: php

	\Nng\Nnhelpers\Helpers\AnnotationHelper::parse( '...', 'nn\rest' );
	\Nng\Nnhelpers\Helpers\AnnotationHelper::parse( '...', ['nn\rest', 'whatever'] );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public static function parse ( $rawAnnotation = '', $namespaces = [] ) {
   	if ($namespaces && !is_array($namespaces)) {
   		$namespaces = [$namespaces];
   	}
   	$result = ['@' => []];
   	if (preg_match_all( '/\n\s*\*\s*@([^\s]*)\s*([^\n]*)/im', $rawAnnotation, $annotations )) {
   		foreach ($annotations[1] as $n=>$k) {
   			if ($namespaces) {
   				$found = false;
   				foreach ($namespaces as $namespace) {
   					if (strpos($k, $namespace) !== false) {
   						$found = true;
   						$k = ltrim(str_replace($namespace, '', $k), '\\');
   						break;
   					}
   				}
   				$rawAnnotation = str_replace($annotations[0][$n], '', $rawAnnotation);
   				if (!$found) continue;
   			}
   			$result['@'][$k] = $annotations[2][$n];
   		}
   	}
   	$result['comment'] = MarkdownHelper::parseComment( $rawAnnotation );
   	return $result;
   }
   

