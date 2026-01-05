
.. include:: ../../../../Includes.txt

.. _Errors-Exception:

==============================================
Errors::Exception()
==============================================

\\nn\\t3::Errors()->Exception(``$message, $code = NULL``);
----------------------------------------------

Eine Typo3-Exception werfen mit Backtrace

.. code-block:: php

	\nn\t3::Errors()->Exception('Damn', 1234);

Ist ein Alias zu:

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
   

