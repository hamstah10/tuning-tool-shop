
.. include:: ../../../../Includes.txt

.. _TranslationHelper-createTextHash:

==============================================
TranslationHelper::createTextHash()
==============================================

\\nn\\t3::TranslationHelper()->createTextHash(``$text = ''``);
----------------------------------------------

Generates a unique hash / checksum from the text.
The transferred text is always the base language. If the text in the base language changes, the method returns a different checksum.
This recognizes when a text needs to be retranslated. Pure changes to whitespaces and tags are ignored.

.. code-block:: php

	$translationHelper->createKeyHash( '12345' );
	$translationHelper->createKeyHash( ['my', 'key', 'array'] );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function createTextHash( $text = '' ) {
   	$text = strtolower(preg_replace('/\s+/', '', strip_tags( $text )));
   	return md5($text);
   }
   

