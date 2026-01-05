
.. include:: ../../../../Includes.txt

.. _Message-WARNING:

==============================================
Message::WARNING()
==============================================

\\nn\\t3::Message()->WARNING(``$title = '', $text = ''``);
----------------------------------------------

Outputs a "WARNING" flash message

.. code-block:: php

	\nn\t3::Message()->WARNING('Title', 'Info text');

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function WARNING( $title = '', $text = '' ) {
   	$this->flash( $title, $text, 'WARNING' );
   }
   

