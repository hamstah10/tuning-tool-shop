
.. include:: ../../../../Includes.txt

.. _Page-getActionLink:

==============================================
Page::getActionLink()
==============================================

\\nn\\t3::Page()->getActionLink(``$pid = NULL, $extensionName = '', $pluginName = '', $controllerName = '', $actionName = '', $params = [], $absolute = false``);
----------------------------------------------

Link zu einer Action / Controller holen

.. code-block:: php

	\nn\t3::Page()->getActionLink( $pid, $extName, $pluginName, $controllerName, $actionName, $args );

Beispiel für die News-Extension:

.. code-block:: php

	$newsArticleUid = 45;
	$newsDetailPid = 123;
	\nn\t3::Page()->getActionLink( $newsDetailPid, 'news', 'pi1', 'News', 'detail', ['news'=>$newsArticleUid]);

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getActionLink( $pid = null, $extensionName = '', $pluginName = '', $controllerName = '', $actionName = '', $params = [], $absolute = false ) {
   	$extensionService = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Service\ExtensionService::class);
   	$argumentsPrefix = $extensionService->getPluginNamespace($extensionName, $pluginName);
   	$arguments = [
   		$argumentsPrefix => [
   			'action' => $actionName,
   			'controller' => $controllerName,
   		],
   	];
   	$arguments[$argumentsPrefix] = array_merge($arguments[$argumentsPrefix], $params);
   	return $this->getLink( $pid, $arguments, $absolute );
   }
   

