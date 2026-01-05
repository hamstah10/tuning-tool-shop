
.. include:: ../../../../Includes.txt

.. _JsonHelper-removeCommentsAndDecode:

==============================================
JsonHelper::removeCommentsAndDecode()
==============================================

\\nn\\t3::JsonHelper()->removeCommentsAndDecode(``$str, $useArray = true``);
----------------------------------------------

Entfernt Kommentare aus dem Code und parsed den String.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\JsonHelper::removeCommentsAndDecode( "// Kommentar\n{title:'Test', cat:[2,3,4]}" )

| ``@return array|string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public static function removeCommentsAndDecode($str, $useArray=true) {
   	$str = preg_replace('/\'([^\']*)(\/\/)([^\']*)\'/', '\'\1\\/\\/\3\'', $str);
   	$str = preg_replace('/"([^"]*)(\/\/)([^"]*)"/', '"\1\\/\\/\3"', $str);
   	$str = (new \Ahc\Json\Comment)->strip($str);
   	$str = str_replace("\\/\\/", '//', $str);
   	return self::decode( $str, $useArray );
   }
   

