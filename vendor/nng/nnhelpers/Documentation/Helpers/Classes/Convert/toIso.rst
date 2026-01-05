
.. include:: ../../../../Includes.txt

.. _Convert-toIso:

==============================================
Convert::toIso()
==============================================

\\nn\\t3::Convert()->toIso();
----------------------------------------------

Converts (normalizes) a string to ISO-8859-1

.. code-block:: php

	\nn\t3::Convert('ÃÃÃ')->toIso();

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function toIso() {
   	$input = $this->initialArgument;
   	$input = html_entity_decode($input);
   	if (function_exists('iconv')) {
   		$input = iconv('UTF-8', 'ISO-8859-1', $input);
   	}
   	return $input;
   }
   

