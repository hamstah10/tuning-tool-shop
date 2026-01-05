
.. include:: ../../../../Includes.txt

.. _Message-ERROR:

==============================================
Message::ERROR()
==============================================

\\nn\\t3::Message()->ERROR(``$title = '', $text = ''``);
----------------------------------------------

Outputs an "ERROR" flash message

.. code-block:: php

	\nn\t3::Message()->ERROR('Title', 'Infotext');

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function ERROR( $title = '', $text = '' ) {
   	$this->flash( $title, $text, 'ERROR' );
   }
   

