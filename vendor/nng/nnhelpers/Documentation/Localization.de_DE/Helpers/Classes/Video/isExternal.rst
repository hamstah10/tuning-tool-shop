
.. include:: ../../../../Includes.txt

.. _Video-isExternal:

==============================================
Video::isExternal()
==============================================

\\nn\\t3::Video()->isExternal(``$url = NULL``);
----------------------------------------------

Prüft, ob es sich bei der URL um ein externes Video auf YouTube oder Vimeo handelt.
Gibt ein Array mit Daten zum Einbetten zurück.

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
   

