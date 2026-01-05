
.. include:: ../../../Includes.txt

.. _SysCategory:

==============================================
SysCategory
==============================================

\\nn\\t3::SysCategory()
----------------------------------------------

Simplifies the work and access to the ``sys_category`` of Typo3

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::SysCategory()->findAll(``$branchUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get list of all sys_categories

.. code-block:: php

	\nn\t3::SysCategory()->findAll();

| ``@return array``

| :ref:`➜ Go to source code of SysCategory::findAll() <SysCategory-findAll>`

\\nn\\t3::SysCategory()->findAllByUid(``$branchUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get list of all sys_categories, return ``uid`` as key

.. code-block:: php

	\nn\t3::SysCategory()->findAllByUid();

| ``@return array``

| :ref:`➜ Go to source code of SysCategory::findAllByUid() <SysCategory-findAllByUid>`

\\nn\\t3::SysCategory()->findByUid(``$uidList = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get sys_categories by uid(s).

.. code-block:: php

	\nn\t3::SysCategory()->findByUid( 12 );
	\nn\t3::SysCategory()->findByUid( '12,11,5' );
	\nn\t3::SysCategory()->findByUid( [12, 11, 5] );

| ``@return array|\TYPO3\CMS\Extbase\Domain\Model\Category``

| :ref:`➜ Go to source code of SysCategory::findByUid() <SysCategory-findByUid>`

\\nn\\t3::SysCategory()->getTree(``$branchUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the entire SysCategory tree (as an array).
Each node has the attributes 'parent' and 'children' in order to
recursively iterate through the tree.

.. code-block:: php

	// Get the entire tree
	\nn\t3::SysCategory()->getTree();
	
	// Get a specific branch of the tree
	\nn\t3::SysCategory()->getTree( $uid );
	
	// Get all branches of the tree, key is the UID of the SysCategory
	\nn\t3::SysCategory()->getTree( true );

ToDo: Check whether caching makes sense

| ``@return array``

| :ref:`➜ Go to source code of SysCategory::getTree() <SysCategory-getTree>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
