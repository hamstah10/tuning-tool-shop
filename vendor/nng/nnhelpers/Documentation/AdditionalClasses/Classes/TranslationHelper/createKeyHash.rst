
.. include:: ../../../../Includes.txt

.. _TranslationHelper-createKeyHash:

==============================================
TranslationHelper::createKeyHash()
==============================================

\\nn\\t3::TranslationHelper()->createKeyHash(``$param = ''``);
----------------------------------------------

Generates a unique hash from the key that is required to identify a text.
Each text has the same key in all languages.

.. code-block:: php

	$translationHelper->createKeyHash( '12345' );
	$translationHelper->createKeyHash( ['my', 'key', 'array'] );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function createKeyHash( $param = '' ) {
   	return md5(json_encode(['_'=>$param]));
   }
   

