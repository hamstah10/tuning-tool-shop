
.. include:: ../../../../Includes.txt

.. _TranslationHelper-createKeyHash:

==============================================
TranslationHelper::createKeyHash()
==============================================

\\nn\\t3::TranslationHelper()->createKeyHash(``$param = ''``);
----------------------------------------------

Erzeugt einen eindeutigen Hash aus dem Key, der zur Identifizierung eines Textes benötigt wird.
Jeder Text hat in allen Sprachen den gleichen Key.

.. code-block:: php

	$translationHelper->createKeyHash( '12345' );
	$translationHelper->createKeyHash( ['mein', 'key', 'array'] );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function createKeyHash( $param = '' ) {
   	return md5(json_encode(['_'=>$param]));
   }
   

