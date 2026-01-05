
.. include:: ../../../../Includes.txt

.. _Registry-icon:

==============================================
Registry::icon()
==============================================

\\nn\\t3::Registry()->icon(``$identifier = '', $path = ''``);
----------------------------------------------

Ein Icon registrieren. Klassischerweise in ext_tables.php genutzt.

.. code-block:: php

	\nn\t3::Registry()->icon('nncalendar-plugin', 'EXT:myextname/Resources/Public/Icons/wizicon.svg');

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function icon ( $identifier = '', $path = '' )
   {
   	$iconRegistry = GeneralUtility::makeInstance( \TYPO3\CMS\Core\Imaging\IconRegistry::class );
   	$suffix = strtolower(pathinfo( $path, PATHINFO_EXTENSION ));
   	if ($suffix != 'svg') {
   		$suffix = 'bitmap';
   	}
   	$provider = 'TYPO3\\CMS\\Core\\Imaging\\IconProvider\\' . ucfirst($suffix) . 'IconProvider';
   	$iconRegistry->registerIcon(
   		$identifier,
   		$provider,
   		['source' => $path]
   	);
   }
   

