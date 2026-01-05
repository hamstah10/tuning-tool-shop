
.. include:: ../../../../Includes.txt

.. _Message-WARNING:

==============================================
Message::WARNING()
==============================================

\\nn\\t3::Message()->WARNING(``$title = '', $text = ''``);
----------------------------------------------

Gibt eine "WARNING" Flash-Message aus

.. code-block:: php

	\nn\t3::Message()->WARNING('Titel', 'Infotext');

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function WARNING( $title = '', $text = '' ) {
   	$this->flash( $title, $text, 'WARNING' );
   }
   

