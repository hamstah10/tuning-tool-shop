
.. include:: ../../../../Includes.txt

.. _Log-info:

==============================================
Log::info()
==============================================

\\nn\\t3::Log()->info(``$extName = '', $message = '', $data = []``);
----------------------------------------------

Write an info to the sys_log table.
Abbreviation for \nn\t3::Log()->log(..., 'info');

.. code-block:: php

	    \nn\t3::Log()->error( 'extname', 'text', ['die'=>'data'] );

return void

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function info( $extName = '', $message = '', $data = []) {
   	$this->log( $extName, $message, $data, 'info' );
   }
   

