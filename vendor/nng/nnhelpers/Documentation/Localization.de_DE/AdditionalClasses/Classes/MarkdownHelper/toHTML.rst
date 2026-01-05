
.. include:: ../../../../Includes.txt

.. _MarkdownHelper-toHTML:

==============================================
MarkdownHelper::toHTML()
==============================================

\\nn\\t3::MarkdownHelper()->toHTML(``$str = ''``);
----------------------------------------------

Einen Text, der markdown enthält in HTML umwandeln.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\MarkdownHelper::toHTML( '...' );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public static function toHTML( $str = '' ) {
   	if (!class_exists(\Parsedown::class)) {
   		\nn\t3::autoload();
   	}
   	$parsedown = new \Parsedown();
   	$result = $parsedown->text( $str );
   	$result = str_replace(['&amp;amp;', '&amp;gt;', '&amp;#039;', '&amp;quot;', '&amp;apos;', '&amp;lt;'], ['&amp;', '&gt;', '&apos;', '&quot;', "&apos;", '&lt;'], $result);
   	$result = trim($result);
   	if (!$result) return '';
   	$dom = new \DOMDocument();
   	$dom->loadXML( '<t>' . $result . '</t>', LIBXML_NOENT | LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING );
   	if (!$dom) return $result;
   	if ($pre = $dom->getElementsByTagName('pre'));
   	if (!$pre) return $result;
   	foreach ($pre as $el) {
   		if ($code = $el->getElementsByTagName('code')) {
   			foreach ($code as $codeEl) {
   				$codeEl->setAttribute('class', 'language-php');
   			}
   		}
   	}
   	$html = $dom->saveHTML( $dom->getElementsByTagName('t')->nodeValue ?? null );
   	return trim(str_replace(['<t>', '</t>'], '', $html));
   }
   

