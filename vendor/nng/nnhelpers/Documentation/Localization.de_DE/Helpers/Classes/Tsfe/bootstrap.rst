
.. include:: ../../../../Includes.txt

.. _Tsfe-bootstrap:

==============================================
Tsfe::bootstrap()
==============================================

\\nn\\t3::Tsfe()->bootstrap(``$conf = []``);
----------------------------------------------

Bootstrap Typo3

.. code-block:: php

	\nn\t3::Tsfe()->bootstrap();
	\nn\t3::Tsfe()->bootstrap( ['vendorName'=>'Nng', 'extensionName'=>'Nnhelpers', 'pluginName'=>'Foo'] );

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function bootstrap ( $conf = [] )
   {
   	$bootstrap = new \TYPO3\CMS\Extbase\Core\Bootstrap();
   	if (!$conf) {
   		$conf = [
   			'vendorName'	=> 'Nng',
   			'extensionName'	=> 'Nnhelpers',
   			'pluginName'	=> 'Foo',
   		];
   	}
   	$bootstrap->initialize($conf);
   }
   

