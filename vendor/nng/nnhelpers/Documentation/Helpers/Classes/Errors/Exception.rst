
.. include:: ../../../../Includes.txt

.. _Errors-Exception:

==============================================
Errors::Exception()
==============================================

\\nn\\t3::Errors()->Exception(``$message, $code = NULL``);
----------------------------------------------

Throw a Typo3 exception with backtrace

.. code-block:: php

	\nn\t3::Errors()->Exception('Damn', 1234);

Is an alias to:

.. code-block:: php

	\nn\t3::Exception('Damn', 1234);

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function Exception ( $message, $code = null ) {
   	if (!$code) $code = time();
   	throw new Exception( $message, $code );
   }
   

