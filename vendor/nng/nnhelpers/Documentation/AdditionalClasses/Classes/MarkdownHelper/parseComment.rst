
.. include:: ../../../../Includes.txt

.. _MarkdownHelper-parseComment:

==============================================
MarkdownHelper::parseComment()
==============================================

\\nn\\t3::MarkdownHelper()->parseComment(``$comment = '', $encode = true``);
----------------------------------------------

Convert comment string to readable HTML string
Comments can use Markdown.
Removes '' and '' etc.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\MarkdownHelper::parseComment( '...' );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public static function parseComment ( $comment = '', $encode = true ) {
   	$comment = self::removeAsterisks( $comment );
   	if (!$encode) return $comment;
   	$comment = htmlspecialchars( $comment );
   	return self::toHTML( $comment );
   }
   

