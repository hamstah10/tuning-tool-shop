
.. include:: ../../../../Includes.txt

.. _Message-OK:

==============================================
Message::OK()
==============================================

\\nn\\t3::Message()->OK(``$title = '', $text = ''``);
----------------------------------------------

Gibt eine "OK" Flash-Message aus

.. code-block:: php

	\nn\t3::Message()->OK('Titel', 'Infotext');

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function OK( $title = '', $text = '' ) {
   	$this->flash( $title, $text );
   }
   

