
.. include:: ../../../../Includes.txt

.. _Page-getLink:

==============================================
Page::getLink()
==============================================

\\nn\\t3::Page()->getLink(``$pidOrParams = NULL, $params = [], $absolute = false``);
----------------------------------------------

Einen einfachen Link zu einer Seite im Frontend generieren.

Funktioniert in jedem Kontext - sowohl aus einem Backend-Modul oder Scheduler/CLI-Job heraus, als auch im Frontend-Kontext, z.B. im Controller oder einem ViewHelper.
Aus dem Backend-Kontext werden absolute URLs ins Frontend generiert. Die URLs werden als lesbare URLs kodiert - der Slug-Pfad bzw. RealURL werden berücksichtigt.

.. code-block:: php

	\nn\t3::Page()->getLink( $pid );
	\nn\t3::Page()->getLink( $pid, $params );
	\nn\t3::Page()->getLink( $params );
	\nn\t3::Page()->getLink( $pid, true );
	\nn\t3::Page()->getLink( $pid, $params, true );
	\nn\t3::Page()->getLink( 'david@99grad.de' )

Beispiel zum Generieren eines Links an einen Controller:

Tipp: siehe auch ``\nn\t3::Page()->getActionLink()`` für eine Kurzversion!

.. code-block:: php

	$newsDetailPid = 123;
	$newsArticleUid = 45;
	
	$link = \nn\t3::Page()->getLink($newsDetailPid, [
	    'tx_news_pi1' => [
	        'action'      => 'detail',
	        'controller'  => 'News',
	        'news'          => $newsArticleUid,
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
   

