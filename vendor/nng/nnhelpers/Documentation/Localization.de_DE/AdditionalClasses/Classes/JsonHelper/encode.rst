
.. include:: ../../../../Includes.txt

.. _JsonHelper-encode:

==============================================
JsonHelper::encode()
==============================================

\\nn\\t3::JsonHelper()->encode(``$var``);
----------------------------------------------

Konvertiert eine Variable ins JSON Format.
Relikt der ursprünglichen Klasse, vermutlich aus einer Zeit als es ``json_encode()`` noch nicht gab.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\JsonHelper::encode(['a'=>1, 'b'=>2]);

| ``@return string;``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public static function encode($var) {
   	return json_encode( $var );
   }
   

