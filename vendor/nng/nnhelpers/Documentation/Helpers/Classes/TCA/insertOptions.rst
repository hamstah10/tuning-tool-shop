
.. include:: ../../../../Includes.txt

.. _TCA-insertOptions:

==============================================
TCA::insertOptions()
==============================================

\\nn\\t3::TCA()->insertOptions(``$config, $a = NULL``);
----------------------------------------------

Inserts options from TypoScript into a TCA for selection.
Alias to \nn\t3::Flexform->insertOptions( $config, $a = null );
Description and further examples there.

Example in the TCA:

.. code-block:: php

	'config' => [
	    'type' => 'select',
	    'itemsProcFunc' => 'nn\t3\Flexform->insertOptions',
	    'typoscriptPath' => 'plugin.tx_nnnewsroom.settings.templates',
	    //'pageconfigPath' => 'tx_nnnewsroom.colors',
	]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function insertOptions ( $config, $a = null )
   {
   	return \nn\t3::Flexform()->insertOptions( $config, $a );
   }
   

