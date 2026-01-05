
.. include:: ../../../../Includes.txt

.. _Settings-parseTypoScriptForPage:

==============================================
Settings::parseTypoScriptForPage()
==============================================

\\nn\\t3::Settings()->parseTypoScriptForPage(``$pageUid = 0, $request = NULL``);
----------------------------------------------

TypoScript für bestimmte pageUid parsen.

Gibt die Notation mit Punkten zurück. Das kann per
| ``\nn\t3::TypoScript()->convertToPlainArray()`` in ein
normales Array umgewandelt werden.

.. code-block:: php

	// TypoScript für aktuelle pageUid holen
	\nn\t3::Settings()->parseTypoScriptForPage();
	
	// TypoScript für bestimmte pageUid holen
	\nn\t3::Settings()->parseTypoScriptForPage(123);

| ``@param int $pid`` PageUid
| ``@param ServerRequestInterface $request``
| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function parseTypoScriptForPage($pageUid = 0, $request = null): array
   {
   	if (!$pageUid) {
   		$pageUid = \nn\t3::Page()->getPid();
   	}
   	$helper = \nn\t3::injectClass( \Nng\Nnhelpers\Helpers\TypoScriptHelper::class );
   	$result = $helper->getTypoScript( $pageUid );
   	return $result;
   }
   

