
.. include:: ../../../../Includes.txt

.. _Log-error:

==============================================
Log::error()
==============================================

\\nn\\t3::Log()->error(``$extName = '', $message = '', $data = []``);
----------------------------------------------

Eine Warnung in die Tabelle sys_log schreiben.
Kurzschreibweise für \nn\t3::Log()->log(..., 'error');

.. code-block:: php

	    \nn\t3::Log()->error( 'extname', 'Text', ['die'=>'daten'] );

return void

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function error( $extName = '', $message = '', $data = []) {
   	$this->log( $extName, $message, $data, 'error' );
   }
   

