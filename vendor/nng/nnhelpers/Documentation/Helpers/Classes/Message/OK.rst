
.. include:: ../../../../Includes.txt

.. _Message-OK:

==============================================
Message::OK()
==============================================

\\nn\\t3::Message()->OK(``$title = '', $text = ''``);
----------------------------------------------

Outputs an "OK" flash message

.. code-block:: php

	\nn\t3::Message()->OK('Title', 'Info text');

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function OK( $title = '', $text = '' ) {
   	$this->flash( $title, $text );
   }
   

