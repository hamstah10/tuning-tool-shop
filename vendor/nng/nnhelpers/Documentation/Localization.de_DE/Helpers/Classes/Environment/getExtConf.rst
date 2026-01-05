
.. include:: ../../../../Includes.txt

.. _Environment-getExtConf:

==============================================
Environment::getExtConf()
==============================================

\\nn\\t3::Environment()->getExtConf(``$ext = 'nnhelpers', $param = ''``);
----------------------------------------------

Configuration aus ``ext_conf_template.txt`` holen (Backend, Extension Configuration)

.. code-block:: php

	\nn\t3::Environment()->getExtConf('nnhelpers', 'varname');

Existiert auch als ViewHelper:

.. code-block:: php

	{nnt3:ts.extConf(path:'nnhelper')}
	{nnt3:ts.extConf(path:'nnhelper.varname')}
	{nnt3:ts.extConf(path:'nnhelper', key:'varname')}

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getExtConf ( $ext = 'nnhelpers', $param = '' ) {
   	$extConfig = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][$ext] ?? [];
   	return $param ? ($extConfig[$param] ?? '') : $extConfig;
   }
   

