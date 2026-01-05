
.. include:: ../../../../Includes.txt

.. _Dom-absPrefix:

==============================================
Dom::absPrefix()
==============================================

\\nn\\t3::Dom()->absPrefix(``$html, $attributes = [], $baseUrl = ''``);
----------------------------------------------

Ersetzt Links und Pfade zu Bildern etc. im Quelltext mit absoluter URL
z.B. für den Versand von Mails
| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function absPrefix( $html, $attributes = [], $baseUrl = '' ) {
   	if (!$baseUrl) $baseUrl = \nn\t3::Environment()->getBaseUrl();
   	if (!$attributes) $attributes = ['href', 'src'];
   	$dom = new \DOMDocument();
   	@$dom->loadHTML($html);
   	$xpath = new \DOMXPath($dom);
   	foreach ($attributes as $attr) {
   		$nodes = $xpath->query('//*[@'.$attr.']');
   		foreach ($nodes as $node) {
   			if ($val = ltrim($node->getAttribute($attr), '/')) {
   				if (strpos($val, ':') === false && $val != '#') {
   					$node->setAttribute($attr, $baseUrl . $val);
   				}
   			}
   		}
   	}
   	return $dom->saveHTML();
   }
   

