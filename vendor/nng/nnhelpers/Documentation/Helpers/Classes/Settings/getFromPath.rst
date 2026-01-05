
.. include:: ../../../../Includes.txt

.. _Settings-getFromPath:

==============================================
Settings::getFromPath()
==============================================

\\nn\\t3::Settings()->getFromPath(``$tsPath = '', $setup = NULL``);
----------------------------------------------

Get setup from a given path, e.g. 'plugin.tx_example.settings'

.. code-block:: php

	\nn\t3::Settings()->getFromPath('plugin.path');
	\nn\t3::Settings()->getFromPath('L', \nn\t3::Request()->GP());
	\nn\t3::Settings()->getFromPath('a.b', ['a'=>['b'=>1]]);

Also exists as ViewHelper:

.. code-block:: php

	{nnt3:ts.setup(path:'path.zur.setup')}

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getFromPath( $tsPath = '', $setup = null )
   {
   	if (is_object($setup)) {
   		$setup = (array) $setup;
   	}
   	$parts = \nn\t3::Arrays($tsPath)->trimExplode('.');
   	$setup = $setup ?: $this->getFullTyposcript();
   	if (!$parts) {
   		return $setup;
   	}
   	$root = array_shift($parts);
   	$plugin = array_shift($parts);
   	$setup = $setup[$root] ?? [];
   	if (!$plugin) return $setup;
   	$setup = $setup[$plugin] ?? [];
   	if (!count($parts)) return $setup;
   	while (count($parts) > 0) {
   		$part = array_shift($parts);
   		if (count($parts) == 0) {
   			return isset($setup[$part]) && is_array($setup[$part]) ? $setup[$part] : ($setup[$part] ?? '');
   		}
   		if (is_array($setup)) {
   			$setup = $setup[$part] ?? '';
   		}
   	}
   	return $setup;
   }
   

