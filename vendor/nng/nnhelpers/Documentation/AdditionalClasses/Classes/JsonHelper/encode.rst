
.. include:: ../../../../Includes.txt

.. _JsonHelper-encode:

==============================================
JsonHelper::encode()
==============================================

\\nn\\t3::JsonHelper()->encode(``$var``);
----------------------------------------------

Converts a variable into JSON format.
Relic of the original class, probably from a time when ``json_encode()`` did not yet exist.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\JsonHelper::encode(['a'=>1, 'b'=>2]);

| ``@return string;``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public static function encode($var) {
   	return json_encode( $var );
   }
   

