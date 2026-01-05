
.. include:: ../../../../Includes.txt

.. _Page-getSiteRoot:

==============================================
Page::getSiteRoot()
==============================================

\\nn\\t3::Page()->getSiteRoot(``$returnAll = false``);
----------------------------------------------

Get PID of the site root(s).
Corresponds to the page in the backend that has the "globe" as an icon
(in the page properties "use as start of website")

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
   

