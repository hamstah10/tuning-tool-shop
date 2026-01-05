
.. include:: ../../../../Includes.txt

.. _Db-getRepositoryForModel:

==============================================
Db::getRepositoryForModel()
==============================================

\\nn\\t3::Db()->getRepositoryForModel(``$className = NULL``);
----------------------------------------------

Get an instance of the repository for a model (or a model class name).

.. code-block:: php

	\nn\t3::Db()->getRepositoryForModel( \My\Domain\Model\Name::class );
	\nn\t3::Db()->getRepositoryForModel( $myModel );

| ``@param mixed $className``
| ``@return \TYPO3\CMS\Extbase\Persistence\Repository``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getRepositoryForModel( $className = null )
   {
   	if (!is_string($className)) $className = get_class($className);
   	$repositoryName = \TYPO3\CMS\Core\Utility\ClassNamingUtility::translateModelNameToRepositoryName( $className );
   	return \nn\t3::injectClass( $repositoryName );
   }
   

