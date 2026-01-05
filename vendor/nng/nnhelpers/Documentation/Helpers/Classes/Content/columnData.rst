
.. include:: ../../../../Includes.txt

.. _Content-columnData:

==============================================
Content::columnData()
==============================================

\\nn\\t3::Content()->columnData(``$colPos, $addRelations = false, $pageUid = NULL``);
----------------------------------------------

Loads the "raw" ``tt_content`` data of a specific column``(colPos``).

.. code-block:: php

	\nn\t3::Content()->columnData( 110 );
	\nn\t3::Content()->columnData( 110, true );
	\nn\t3::Content()->columnData( 110, true, 99 );

Also available as ViewHelper.
| ``relations`` is set to ``TRUE`` by default in the ViewHelper

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
   

