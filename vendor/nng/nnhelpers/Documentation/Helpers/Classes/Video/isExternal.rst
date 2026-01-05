
.. include:: ../../../../Includes.txt

.. _Video-isExternal:

==============================================
Video::isExternal()
==============================================

\\nn\\t3::Video()->isExternal(``$url = NULL``);
----------------------------------------------

Checks whether the URL is an external video on YouTube or Vimeo.
Returns an array with data for embedding.

.. code-block:: php

	\nn\t3::Video()->isExternal( 'https://www.youtube.com/...' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isExternal ( $url = null )
   {
   	return $this->getExternalType( $url );
   }
   

