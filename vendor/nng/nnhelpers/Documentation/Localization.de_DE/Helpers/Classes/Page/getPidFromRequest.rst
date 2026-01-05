
.. include:: ../../../../Includes.txt

.. _Page-getPidFromRequest:

==============================================
Page::getPidFromRequest()
==============================================

\\nn\\t3::Page()->getPidFromRequest();
----------------------------------------------

PID aus Request-String holen, z.B. in Backend Modulen.
Hacky. ToDo: Prüfen, ob es eine bessere Methode gibt.

.. code-block:: php

	\nn\t3::Page()->getPidFromRequest();

| ``@return int``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getPidFromRequest ()
   {
   	if (\TYPO3\CMS\Core\Core\Environment::isCli()) {
   		return 0;
   	}
   	if ($request = \nn\t3::Environment()->getRequest()) {
   		$params = $request->getQueryParams();
   		$pageUid = array_key_first($params['edit']['pages'] ?? []);
   		if ($pageUid) return $pageUid;
   	}
   	$pageUid = $_REQUEST['popViewId'] ?? false;
   	if (!$pageUid) $pageUid = preg_replace( '/(.*)(id=)([0-9]*)(.*)/i', '\\3', $_REQUEST['returnUrl'] ?? '' );
   	if (!$pageUid) $pageUid = preg_replace( '/(.*)(id=)([0-9]*)(.*)/i', '\\3', $_POST['returnUrl'] ?? '' );
   	if (!$pageUid) $pageUid = preg_replace( '/(.*)(id=)([0-9]*)(.*)/i', '\\3', $_GET['returnUrl'] ?? '' );
   	if (!$pageUid && ($_GET['edit']['pages'] ?? false)) $pageUid = array_keys($_GET['edit']['pages'])[0] ?? 0;
   	if (!$pageUid) $pageUid = $_GET['id'] ?? 0;
   	return (int) $pageUid;
   }
   

