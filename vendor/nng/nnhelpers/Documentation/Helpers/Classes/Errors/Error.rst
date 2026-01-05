
.. include:: ../../../../Includes.txt

.. _Errors-Error:

==============================================
Errors::Error()
==============================================

\\nn\\t3::Errors()->Error(``$message, $code = NULL``);
----------------------------------------------

Throw an error with backtrace

.. code-block:: php

	\nn\t3::Errors()->Error('Damn', 1234);

Is an alias to:

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
   

