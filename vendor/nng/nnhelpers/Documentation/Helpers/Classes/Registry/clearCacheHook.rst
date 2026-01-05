
.. include:: ../../../../Includes.txt

.. _Registry-clearCacheHook:

==============================================
Registry::clearCacheHook()
==============================================

\\nn\\t3::Registry()->clearCacheHook(``$classMethodPath = ''``);
----------------------------------------------

Inserts a hook that is executed when you click on "Clear cache".
The following script is added to the ``ext_localconf.php`` of your extension:

.. code-block:: php

	\nn\t3::Registry()->clearCacheHook( \My\Ext\Path::class . '->myMethod' );

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function clearCacheHook( $classMethodPath = '' )
   {
   	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] = $classMethodPath;
   }
   

