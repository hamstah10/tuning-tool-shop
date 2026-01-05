
.. include:: ../../../../Includes.txt

.. _Page-getLink:

==============================================
Page::getLink()
==============================================

\\nn\\t3::Page()->getLink(``$pidOrParams = NULL, $params = [], $absolute = false``);
----------------------------------------------

Generate a simple link to a page in the frontend.

Works in any context - both from a backend module or scheduler/CLI job, as well as in the frontend context, e.g. in the controller or a ViewHelper.
Absolute URLs are generated from the backend context into the frontend. The URLs are encoded as readable URLs - the slug path or RealURL are taken into account.

.. code-block:: php

	\nn\t3::Page()->getLink( $pid );
	\nn\t3::Page()->getLink( $pid, $params );
	\nn\t3::Page()->getLink( $params );
	\nn\t3::Page()->getLink( $pid, true );
	\nn\t3::Page()->getLink( $pid, $params, true );
	\nn\t3::Page()->getLink( 'david@99grad.de' )

Example for generating a link to a controller:

Tip: see also ``\nn\t3::Page()->getActionLink()`` for a short version!

.. code-block:: php

	$newsDetailPid = 123;
	$newsArticleUid = 45;
	
	$link = \nn\t3::Page()->getLink($newsDetailPid, [
	    'tx_news_pi1' => [
	        'action' => 'detail',
	        'controller' => 'news',
	        'news' => $newsArticleUid,
	    ]
	]);

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getLink ( $pidOrParams = null, $params = [], $absolute = false ) {
   	$pid = is_array($pidOrParams) ? $this->getPid() : $pidOrParams;
   	$params = is_array($pidOrParams) ? $pidOrParams : $params;
   	if ($params === true) {
   		$params = [];
   		$absolute = true;
   	}
   	$request = \nn\t3::Environment()->getRequest();
   	$cObj = GeneralUtility::makeInstance( \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class );
   	$cObj->setRequest( $request );
   	$uri = $cObj->typolink_URL([
   		'parameter' => $pid,
   		'forceAbsoluteUrl' => ($absolute == true),
   		'additionalParams' => GeneralUtility::implodeArrayForUrl('', $params),
   	]);
   	return $uri;
   }
   

