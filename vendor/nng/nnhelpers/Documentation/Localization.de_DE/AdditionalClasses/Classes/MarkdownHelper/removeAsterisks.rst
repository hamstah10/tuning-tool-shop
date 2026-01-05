
.. include:: ../../../../Includes.txt

.. _MarkdownHelper-removeAsterisks:

==============================================
MarkdownHelper::removeAsterisks()
==============================================

\\nn\\t3::MarkdownHelper()->removeAsterisks(``$comment = ''``);
----------------------------------------------

Entfernt die Kommentar-Sternchen in einem Text.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\MarkdownHelper::removeAsterisks( '...' );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public static function removeAsterisks( $comment = '' ) {
   	// Öffnenden und schließenden Kommentar löschen
   	$comment = trim(str_replace(['/**', '/*', '*/'], '', $comment));
   	// in Zeilen-Array konvertieren
   	$lines = \nn\t3::Arrays($comment)->trimExplode("\n");
   	$isCode = false;
   	foreach ($lines as $k=>$line) {
   		// \nn\t3...; immer als Code formatieren
   		//$line = preg_replace("/((.*)(t3:)(.*)(;))/", '`\1`', $line);
   		$line = preg_replace("/((.*)(@param)([^\$]*)([\$a-zA-Z]*))(.*)/", '`\1`\6', $line);
   		$line = preg_replace("/((.*)(@return)(.*))/", '`\1`', $line);
   		// Leerzeichen nach '* ' entfernen
   		$line = preg_replace("/(\*)(\s)(.*)/", '\3', $line);
   		$line = preg_replace("/`([\s]*)/", '`', $line, 1);
   		$line = str_replace('*', '', $line);
   		if (!$isCode) {
   			$line = trim($line);
   		}
   		if (strpos($line, '```') !== false) $isCode = !$isCode;
   		$lines[$k] = $line;
   	}
   	$comment = trim(join("\n", $lines));
   	return $comment;
   }
   

