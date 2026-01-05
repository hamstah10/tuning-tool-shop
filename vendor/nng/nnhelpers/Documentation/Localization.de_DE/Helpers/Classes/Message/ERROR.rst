
.. include:: ../../../../Includes.txt

.. _Message-ERROR:

==============================================
Message::ERROR()
==============================================

\\nn\\t3::Message()->ERROR(``$title = '', $text = ''``);
----------------------------------------------

Gibt eine "ERROR" Flash-Message aus

.. code-block:: php

	\nn\t3::Message()->ERROR('Titel', 'Infotext');

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function ERROR( $title = '', $text = '' ) {
   	$this->flash( $title, $text, 'ERROR' );
   }
   

