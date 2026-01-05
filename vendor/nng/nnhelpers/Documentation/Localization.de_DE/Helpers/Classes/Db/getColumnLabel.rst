
.. include:: ../../../../Includes.txt

.. _Db-getColumnLabel:

==============================================
Db::getColumnLabel()
==============================================

\\nn\\t3::Db()->getColumnLabel(``$column = '', $table = ''``);
----------------------------------------------

Lokalisiertes Label eines bestimmten TCA Feldes holen

| ``@param string $column``
| ``@param string $table``
| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getColumnLabel ( $column = '', $table = '' )
   {
   	$tca = $this->getColumns( $table );
   	$label = $tca[$column]['label'] ?? '';
   	if ($label && ($LL = LocalizationUtility::translate($label))) return $LL;
   	return $label;
   }
   

