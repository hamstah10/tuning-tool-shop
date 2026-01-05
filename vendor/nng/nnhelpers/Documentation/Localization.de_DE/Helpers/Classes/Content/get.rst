
.. include:: ../../../../Includes.txt

.. _Content-get:

==============================================
Content::get()
==============================================

\\nn\\t3::Content()->get(``$ttContentUid = NULL, $getRelations = false, $localize = true, $field = 'uid'``);
----------------------------------------------

Lädt die Daten eines tt_content-Element als einfaches Array:

.. code-block:: php

	\nn\t3::Content()->get( 1201 );

Laden von Relationen (``media``, ``assets``, ...)

.. code-block:: php

	\nn\t3::Content()->get( 1201, true );

Übersetzungen / Localization:

Element NICHT automatisch übersetzen, falls eine andere Sprache eingestellt wurde

.. code-block:: php

	\nn\t3::Content()->get( 1201, false, false );

Element in einer ANDEREN Sprache holen, als im Frontend eingestellt wurde.
Berücksichtigt die Fallback-Chain der Sprache, die in der Site-Config eingestellt wurde

.. code-block:: php

	\nn\t3::Content()->get( 1201, false, 2 );

Element mit eigener Fallback-Chain holen. Ignoriert dabei vollständig die Chain,
die in der Site-Config definiert wurde.

.. code-block:: php

	\nn\t3::Content()->get( 1201, false, [2,3,0] );

Eigenes Feld zur Erkennung verwenden

.. code-block:: php

	\nn\t3::Content()->get( 'footer', true, true, 'content_uuid' );

| ``@param int|string $ttContentUid`` Content-Uid in der Tabelle tt_content (oder string mit einem key)
| ``@param bool $getRelations`` Auch Relationen / FAL holen?
| ``@param bool $localize`` Übersetzen des Eintrages?
| ``@param string $localize`` Übersetzen des Eintrages?
| ``@param string $field`` Falls anderes Feld als ``uid`` verwendet werden soll
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
   

