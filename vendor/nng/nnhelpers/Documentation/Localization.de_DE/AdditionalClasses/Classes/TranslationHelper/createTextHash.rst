
.. include:: ../../../../Includes.txt

.. _TranslationHelper-createTextHash:

==============================================
TranslationHelper::createTextHash()
==============================================

\\nn\\t3::TranslationHelper()->createTextHash(``$text = ''``);
----------------------------------------------

Erzeugt einen eindeutigen Hash / Checksum aus dem Text.
Der übergebene Text ist immer die Basis-Sprache. Ändert sich der Text in der Basissprache, gibt die Methode eine andere Checksum zurück.
Dadurch wird erkannt, wann ein Text neu übersetzt werden muss. Reine Änderungen an Whitespaces und Tags werden ignoriert.

.. code-block:: php

	$translationHelper->createKeyHash( '12345' );
	$translationHelper->createKeyHash( ['mein', 'key', 'array'] );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function createTextHash( $text = '' ) {
   	$text = strtolower(preg_replace('/\s+/', '', strip_tags( $text )));
   	return md5($text);
   }
   

