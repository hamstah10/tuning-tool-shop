
.. include:: ../../../../Includes.txt

.. _Convert-toUTF8:

==============================================
Convert::toUTF8()
==============================================

\\nn\\t3::Convert()->toUTF8();
----------------------------------------------

Converts (normalizes) a string to UTF-8

.. code-block:: php

	\nn\t3::Convert('ÃÃÃ')->toUTF8();

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function toUTF8() {
   	$input = $this->initialArgument;
   	$input = html_entity_decode($input);
   	if (function_exists('iconv')) {
   		$input = iconv('ISO-8859-1', 'UTF-8', $input);
   	}
   	return $input;
   }
   

