
.. include:: ../../../../Includes.txt

.. _Convert-toBytes:

==============================================
Convert::toBytes()
==============================================

\\nn\\t3::Convert()->toBytes();
----------------------------------------------

Converts a human-readable specification of bytes/megabytes into a byte integer.
Extremely tolerant when it comes to spaces, upper/lower case and commas instead of periods.

.. code-block:: php

	\nn\t3::Convert('1M')->toBytes(); // -> 1048576
	\nn\t3::Convert('1 MB')->toBytes(); // -> 1048576
	\nn\t3::Convert('1kb')->toBytes(); // -> 1024
	\nn\t3::Convert('1.5kb')->toBytes(); // -> 1024
	\nn\t3::Convert('1.5Gb')->toBytes(); // -> 1610612736

For the reverse path (bytes to human-readable notation such as 1024 -> 1kb) there is a practical
there is a practical Fluid ViewHelper in the core:

.. code-block:: php

	{fileSize->f:format.bytes()}

| ``@return integer``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function toBytes() {
   	$input = strtoupper($this->initialArgument);
   	$units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
   	$input = str_replace(',', '.', $input);
   	if (substr($input, -1) == 'M') $input .= 'B';
   	$number = substr($input, 0, -2);
   	$suffix = substr($input,-2);
   	if(is_numeric(substr($suffix, 0, 1))) {
   		return preg_replace('/[^\d]/', '', $input);
   	}
   	$exponent = array_flip($units)[$suffix] ?? null;
   	if($exponent === null) {
   		return null;
   	}
   	return $number * (1024 ** $exponent);
   }
   

