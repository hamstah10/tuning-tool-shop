
.. include:: ../../../../Includes.txt

.. _Log-error:

==============================================
Log::error()
==============================================

\\nn\\t3::Log()->error(``$extName = '', $message = '', $data = []``);
----------------------------------------------

Write a warning in the sys_log table.
Abbreviation for \nn\t3::Log()->log(..., 'error');

.. code-block:: php

	    \nn\t3::Log()->error( 'extname', 'text', ['die'=>'data'] );

return void

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function error( $extName = '', $message = '', $data = []) {
   	$this->log( $extName, $message, $data, 'error' );
   }
   

