
.. include:: ../../../../Includes.txt

.. _Convert-toBytes:

==============================================
Convert::toBytes()
==============================================

\\nn\\t3::Convert()->toBytes();
----------------------------------------------

Konvertiert eine für Menschen lesbare Angabe von Bytes/Megabytes in einen Byte-Integer.
Extrem tolerant, was Leerzeichen, Groß/Klein-Schreibung und Kommas statt Punkten angeht.

.. code-block:: php

	\nn\t3::Convert('1M')->toBytes();  // -> 1048576
	\nn\t3::Convert('1 MB')->toBytes();    // -> 1048576
	\nn\t3::Convert('1kb')->toBytes(); // -> 1024
	\nn\t3::Convert('1,5kb')->toBytes();   // -> 1024
	\nn\t3::Convert('1.5Gb')->toBytes();   // -> 1610612736

Für den umgekehrten Weg (Bytes zu menschenlesbarer Schreibweise wie 1024 -> 1kb) gibt
es einen praktischen Fluid ViewHelper im Core:

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
   

