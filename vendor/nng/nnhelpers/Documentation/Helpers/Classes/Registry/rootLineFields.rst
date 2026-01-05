
.. include:: ../../../../Includes.txt

.. _Registry-rootLineFields:

==============================================
Registry::rootLineFields()
==============================================

\\nn\\t3::Registry()->rootLineFields(``$fields = [], $translate = true``);
----------------------------------------------

Register a field in the pages table that is to be inherited / slid to subpages.
Register in ``ext_localconf.php``:

.. code-block:: php

	\nn\t3::Registry()->rootLineFields(['slidefield']);
	\nn\t3::Registry()->rootLineFields('slidefield');

Typoscript setup:

.. code-block:: php

	page.10 = FLUIDTEMPLATE
	page.10.variables {
	    footer = TEXT
	    footer {
	        data = levelfield:-1, footer element, slide
	    }
	}

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function rootLineFields ( $fields = [], $translate = true )
   {
   	if (is_string($fields)) $fields = [$fields];
   	if (!isset($GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'])) {
   		$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] = '';
   	}
   	$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= ($GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] ? ',' : '') . join(',', $fields);
   	if ($translate) {
   		if (!isset($GLOBALS['TYPO3_CONF_VARS']['FE']['pageOverlayFields'])) {
   			$GLOBALS['TYPO3_CONF_VARS']['FE']['pageOverlayFields'] = '';
   		}
   		$GLOBALS['TYPO3_CONF_VARS']['FE']['pageOverlayFields'] .= join(',', $fields);
   	}
   }
   

