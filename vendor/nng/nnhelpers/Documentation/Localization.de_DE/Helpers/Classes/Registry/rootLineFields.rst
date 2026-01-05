
.. include:: ../../../../Includes.txt

.. _Registry-rootLineFields:

==============================================
Registry::rootLineFields()
==============================================

\\nn\\t3::Registry()->rootLineFields(``$fields = [], $translate = true``);
----------------------------------------------

Ein Feld in der Tabelle pages registrieren, das auf Unterseiten vererbbar / geslided werden soll.
In der ``ext_localconf.php`` registrieren:

.. code-block:: php

	\nn\t3::Registry()->rootLineFields(['slidefield']);
	\nn\t3::Registry()->rootLineFields('slidefield');

Typoscript-Setup:

.. code-block:: php

	page.10 = FLUIDTEMPLATE
	page.10.variables {
	    footer = TEXT
	    footer {
	        data = levelfield:-1, footerelement, slide
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
   

