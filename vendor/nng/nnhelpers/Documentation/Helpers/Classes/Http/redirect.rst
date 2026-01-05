
.. include:: ../../../../Includes.txt

.. _Http-redirect:

==============================================
Http::redirect()
==============================================

\\nn\\t3::Http()->redirect(``$pidOrUrl = NULL, $vars = [], $varsPrefix = ''``);
----------------------------------------------

Redirect to a page

.. code-block:: php

	\nn\t3::Http()->redirect( 'https://www.99grad.de' );
	\nn\t3::Http()->redirect( 10 ); // => path/to/pageId10
	\nn\t3::Http()->redirect( 10, ['test'=>'123'] ); // => path/to/pageId10&test=123
	\nn\t3::Http()->redirect( 10, ['test'=>'123'], 'tx_myext_plugin' );
| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function redirect ( $pidOrUrl = null, $vars = [], $varsPrefix = '' ) {
   	if (!$varsPrefix) unset($vars['id']);
   	if ($varsPrefix) {
   		$tmp = [$varsPrefix=>[]];
   		foreach ($vars as $k=>$v) $tmp[$varsPrefix][$k] = $v;
   		$vars = $tmp;
   	}
   	$link = $this->buildUri( $pidOrUrl, $vars, true );
   	header('Location: '.$link);
   	exit();
   }
   

