
.. include:: ../../../../Includes.txt

.. _Content-columnData:

==============================================
Content::columnData()
==============================================

\\nn\\t3::Content()->columnData(``$colPos, $addRelations = false, $pageUid = NULL``);
----------------------------------------------

Lädt die "rohen" ``tt_content`` Daten einer bestimmten Spalte (``colPos``).

.. code-block:: php

	\nn\t3::Content()->columnData( 110 );
	\nn\t3::Content()->columnData( 110, true );
	\nn\t3::Content()->columnData( 110, true, 99 );

Auch als ViewHelper vorhanden.
| ``relations`` steht im ViewHelper als default auf ``TRUE``

.. code-block:: php

	{nnt3:content.columnData(colPos:110)}
	{nnt3:content.columnData(colPos:110, pid:99, relations:0)}

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function columnData($colPos, $addRelations = false, $pageUid = null)
   {
   	if (!$pageUid) $pageUid = \nn\t3::Page()->getPid();
   	$queryBuilder = \nn\t3::Db()->getQueryBuilder('tt_content');
   	$data = $queryBuilder
   		->select('*')
   		->from('tt_content')
   		->andWhere($queryBuilder->expr()->eq('colPos', $queryBuilder->createNamedParameter($colPos)))
   		->andWhere($queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pageUid)))
   		->orderBy('sorting')
   		->executeQuery()
   		->fetchAllAssociative();
   	if (!$data) return [];
   	if ($addRelations) {
   		foreach ($data as $n => $row) {
   			$data[$n] = $this->addRelations($row);
   		}
   	}
   	return $data;
   }
   

