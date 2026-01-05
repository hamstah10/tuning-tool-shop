
.. include:: ../../../../Includes.txt

.. _Cache-getIdentifier:

==============================================
Cache::getIdentifier()
==============================================

\\nn\\t3::Cache()->getIdentifier(``$identifier = NULL``);
----------------------------------------------

Converts transferred cache identifiers into a usable string.
Can also process an array as identifier.

| ``@param mixed $indentifier``
| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public static function getIdentifier( $identifier = null )
   {
   	if (is_array($identifier)) {
   		$identifier = json_encode($identifier);
   	}
   	return md5($identifier);
   }
   

