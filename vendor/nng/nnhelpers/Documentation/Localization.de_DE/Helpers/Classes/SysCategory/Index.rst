
.. include:: ../../../Includes.txt

.. _SysCategory:

==============================================
SysCategory
==============================================

\\nn\\t3::SysCategory()
----------------------------------------------

Vereinfacht die Arbeit und den Zugriff auf die ``sys_category`` von Typo3

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::SysCategory()->findAll(``$branchUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Liste aller sys_categories holen

.. code-block:: php

	\nn\t3::SysCategory()->findAll();

| ``@return array``

| :ref:`➜ Go to source code of SysCategory::findAll() <SysCategory-findAll>`

\\nn\\t3::SysCategory()->findAllByUid(``$branchUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Liste aller sys_categories holen, ``uid`` als Key zurückgeben

.. code-block:: php

	\nn\t3::SysCategory()->findAllByUid();

| ``@return array``

| :ref:`➜ Go to source code of SysCategory::findAllByUid() <SysCategory-findAllByUid>`

\\nn\\t3::SysCategory()->findByUid(``$uidList = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

sys_categories anhand von uid(s) holen.

.. code-block:: php

	\nn\t3::SysCategory()->findByUid( 12 );
	\nn\t3::SysCategory()->findByUid( '12,11,5' );
	\nn\t3::SysCategory()->findByUid( [12, 11, 5] );

| ``@return array|\TYPO3\CMS\Extbase\Domain\Model\Category``

| :ref:`➜ Go to source code of SysCategory::findByUid() <SysCategory-findByUid>`

\\nn\\t3::SysCategory()->getTree(``$branchUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Den gesamten SysCategory-Baum (als Array) holen.
Jeder Knotenpunkt hat die Attribute 'parent' und 'children', um
rekursiv durch Baum iterieren zu können.

.. code-block:: php

	// Gesamten Baum holen
	\nn\t3::SysCategory()->getTree();
	
	// Bestimmten Ast des Baums holen
	\nn\t3::SysCategory()->getTree( $uid );
	
	// Alle Äste des Baums holen, key ist die UID der SysCategory
	\nn\t3::SysCategory()->getTree( true );

ToDo: Prüfen, ob Caching sinnvoll ist

| ``@return array``

| :ref:`➜ Go to source code of SysCategory::getTree() <SysCategory-getTree>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
