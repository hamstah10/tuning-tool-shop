
.. include:: ../../../../Includes.txt

.. _Page-getSiteRoot:

==============================================
Page::getSiteRoot()
==============================================

\\nn\\t3::Page()->getSiteRoot(``$returnAll = false``);
----------------------------------------------

PID der Site-Root(s) holen.
Entspricht der Seite im Backend, die die "Weltkugel" als Symbol hat
(in den Seiteneigenschaften "als Anfang der Webseite nutzen")

.. code-block:: php

	\nn\t3::Page()->getSiteRoot();

| ``@return int``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getSiteRoot( $returnAll = false ) {
   	$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
   	$queryBuilder
   		->select('*')
   		->from('pages')
   		->andWhere($queryBuilder->expr()->eq('is_siteroot', '1'));
   	if ($returnAll) return $queryBuilder->executeQuery()->fetchAllAssociative();
   	return $queryBuilder->executeQuery()->fetchAssociative();
   }
   

