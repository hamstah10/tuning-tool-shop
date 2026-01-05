
.. include:: ../../../../Includes.txt

.. _Registry-clearCacheHook:

==============================================
Registry::clearCacheHook()
==============================================

\\nn\\t3::Registry()->clearCacheHook(``$classMethodPath = ''``);
----------------------------------------------

Fügt einen Hook ein, der beim Klick auf "Cache löschen" ausgeführt wird.
Folgendes Script kommt in die ``ext_localconf.php`` der eigenen Extension:

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
   

