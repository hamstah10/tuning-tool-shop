
.. include:: ../../../../Includes.txt

.. _Environment-getExtConf:

==============================================
Environment::getExtConf()
==============================================

\\nn\\t3::Environment()->getExtConf(``$ext = 'nnhelpers', $param = ''``);
----------------------------------------------

Get configuration from ``ext_conf_template.txt`` (backend, extension configuration)

.. code-block:: php

	\nn\t3::Environment()->getExtConf('nnhelpers', 'varname');

Also exists as ViewHelper:

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
   

