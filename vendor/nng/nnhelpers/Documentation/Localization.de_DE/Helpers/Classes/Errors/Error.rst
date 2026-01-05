
.. include:: ../../../../Includes.txt

.. _Errors-Error:

==============================================
Errors::Error()
==============================================

\\nn\\t3::Errors()->Error(``$message, $code = NULL``);
----------------------------------------------

Einen Error werfen mit Backtrace

.. code-block:: php

	\nn\t3::Errors()->Error('Damn', 1234);

Ist ein Alias zu:

.. code-block:: php

	\nn\t3::Error('Damn', 1234);

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function Error ( $message, $code = null ) {
   	if (!$code) $code = time();
   	throw new \Error( $message, $code );
   }
   

