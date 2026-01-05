
.. include:: ../../../../Includes.txt

.. _Log-info:

==============================================
Log::info()
==============================================

\\nn\\t3::Log()->info(``$extName = '', $message = '', $data = []``);
----------------------------------------------

Eine Info in die Tabelle sys_log schreiben.
Kurzschreibweise für \nn\t3::Log()->log(..., 'info');

.. code-block:: php

	    \nn\t3::Log()->error( 'extname', 'Text', ['die'=>'daten'] );

return void

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function info( $extName = '', $message = '', $data = []) {
   	$this->log( $extName, $message, $data, 'info' );
   }
   

