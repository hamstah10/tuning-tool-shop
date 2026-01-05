
.. include:: ../../../../Includes.txt

.. _TCA-getConfigForType:

==============================================
TCA::getConfigForType()
==============================================

\\nn\\t3::TCA()->getConfigForType(``$type = '', $override = []``);
----------------------------------------------

Get default configuration for various typical ``types`` in the ``TCA``
Serves as a kind of alias to write the most frequently used ``config arrays`` faster and
and to be able to write them more quickly

.. code-block:: php

	\nn\t3::TCA()->getConfigForType( 'pid' ); // => ['type'=>'group', 'allowed'=>'pages', 'maxItems'=>1]
	\nn\t3::TCA()->getConfigForType( 'contentElement' ); // => ['type'=>'group', 'allowed'=>'tt_content', 'maxItems'=>1]
	\nn\t3::TCA()->getConfigForType( 'text' ); // => ['type'=>'text', 'rows'=>2, ...]
	\nn\t3::TCA()->getConfigForType( 'rte' ); // => ['type'=>'text', 'enableRichtext'=>'true', ...]
	\nn\t3::TCA()->getConfigForType( 'color' ); // => ['type'=>'color', ...]
	\nn\t3::TCA()->getConfigForType( 'fal', 'image' ); // => ['type'=>'file', ...]

Default configurations can simply be overwritten / extended:

.. code-block:: php

	\nn\t3::TCA()->getConfigForType( 'text', ['rows'=>5] ); // => ['type'=>'text', 'rows'=>5, ...]

For each type, the most frequently overwritten value in the ``config array`` can also be
by passing a fixed value instead of an ``override array``:

.. code-block:: php

	\nn\t3::TCA()->getConfigForType( 'pid', 3 ); // => ['maxItems'=>3, ...]
	\nn\t3::TCA()->getConfigForType( 'contentElement', 3 ); // => ['maxItems'=>3, ...]
	\nn\t3::TCA()->getConfigForType( 'text', 10 ); // => ['rows'=>10, ...]
	\nn\t3::TCA()->getConfigForType( 'rte', 'myRteConfig' ); // => ['richtextConfiguration'=>'myRteConfig', ...]
	\nn\t3::TCA()->getConfigForType( 'color', '#ff6600' ); // => ['default'=>'#ff6600', ...]
	\nn\t3::TCA()->getConfigForType( 'fal', 'image' ); // => [ config for the field with the key `image` ]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getConfigForType( $type = '', $override = [] )
   {
   	if (is_array($type)) return $type;
   	// Fixer Wert statt Array in `override`? Für welches Key im `config`-Array verwenden?
   	$overrideKey = false;
   	switch ($type) {
   		case 'pid':
   			$config = ['type'=>'group', 'allowed'=>'pages', 'size' => 1, 'maxItems'=>1];
   			$overrideKey = 'maxItems';
   			break;
   		case 'cid':
   		case 'contentElement':
   			$config = ['type'=>'group', 'allowed'=>'tt_content', 'size' => 1, 'maxItems'=>1];
   			$overrideKey = 'maxItems';
   			break;
   		case 'text':
   			$config = ['type'=>'text', 'rows'=>2, 'cols'=>50];
   			$overrideKey = 'rows';
   			break;
   		case 'color':
   			$config = \nn\t3::TCA()->getColorPickerTCAConfig();
   			$overrideKey = 'default';
   			break;
   		case 'rte':
   			$config = \nn\t3::TCA()->getRteTCAConfig();
   			$overrideKey = 'richtextConfiguration';
   			break;
   		case 'fal':
   			if (!$override) \nn\t3::Exception('`field` muss definiert sein!');
   			if (is_string($override)) $override = ['field'=>$override];
   			$config = \nn\t3::TCA()->getFileFieldTCAConfig( $override['field'], $override );
   			break;
   		default:
   			$config = [];
   	}
   	if ($override) {
   		if (!is_array($override) && $overrideKey) {
   			$override = [$overrideKey=>$override];
   		}
   		$config = \nn\t3::Arrays()->merge( $config, $override );
   	}
   	return $config;
   }
   

