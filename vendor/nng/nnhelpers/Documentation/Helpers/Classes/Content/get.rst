
.. include:: ../../../../Includes.txt

.. _Content-get:

==============================================
Content::get()
==============================================

\\nn\\t3::Content()->get(``$ttContentUid = NULL, $getRelations = false, $localize = true, $field = 'uid'``);
----------------------------------------------

Loads the data of a tt_content element as a simple array:

.. code-block:: php

	\nn\t3::Content()->get( 1201 );

Loading relations``(media``, ``assets``, ...)

.. code-block:: php

	\nn\t3::Content()->get( 1201, true );

Translations / Localization:

Do NOT automatically translate element if a different language has been set

.. code-block:: php

	\nn\t3::Content()->get( 1201, false, false );

Get element in a DIFFERENT language than set in the frontend.
Takes into account the fallback chain of the language that was set in the site config

.. code-block:: php

	\nn\t3::Content()->get( 1201, false, 2 );

Get element with its own fallback chain. Completely ignores the chain,
that was defined in the site config.

.. code-block:: php

	\nn\t3::Content()->get( 1201, false, [2,3,0] );

Use your own field for recognition

.. code-block:: php

	\nn\t3::Content()->get( 'footer', true, true, 'content_uuid' );

| ``@param int|string $ttContentUid`` Content-Uid in the table tt_content (or string with a key)
| ``@param bool $getRelations`` Also get relations / FAL?
| ``@param bool $localize`` Translate the entry?
| ``@param string $localize`` Translate the entry?
| ``@param string $field`` If field other than ``uid`` is to be used
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function get($ttContentUid = null, $getRelations = false, $localize = true, $field = 'uid')
   {
   	if (!$ttContentUid) return [];
   	// Datensatz in der Standard-Sprache holen
   	$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
   	$data = $queryBuilder
   		->select('*')
   		->from('tt_content')
   		->andWhere($queryBuilder->expr()->eq($field, $queryBuilder->createNamedParameter($ttContentUid)))
   		->executeQuery()
   		->fetchAssociative();
   	if (!$data) return [];
   	$data = $this->localize('tt_content', $data, $localize);
   	if ($getRelations) {
   		$data = $this->addRelations($data);
   	}
   	return $data;
   }
   

