
.. include:: ../../../../Includes.txt

.. _Content-render:

==============================================
Content::render()
==============================================

\\nn\\t3::Content()->render(``$ttContentUid = NULL, $data = [], $field = NULL``);
----------------------------------------------

Rendert ein ``tt_content``-Element als HTML

.. code-block:: php

	\nn\t3::Content()->render( 1201 );
	\nn\t3::Content()->render( 1201, ['key'=>'value'] );
	\nn\t3::Content()->render( 'footer', ['key'=>'value'], 'content_uuid' );

Auch als ViewHelper vorhanden:

.. code-block:: php

	{nnt3:contentElement(uid:123, data:feUser.data)}
	{nnt3:contentElement(uid:'footer', field:'content_uuid')}

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function render($ttContentUid = null, $data = [], $field = null)
   {
   	if (!$ttContentUid) return '';
   	if ($field && $field !== 'uid') {
   		$row = \nn\t3::Db()->findOneByValues('tt_content', [$field => $ttContentUid]);
   		if (!$row) return '';
   		$ttContentUid = $row['uid'];
   	}
   	$conf = [
   		'tables' => 'tt_content',
   		'source' => $ttContentUid,
   		'dontCheckPid' => 1
   	];
   	\nn\t3::Tsfe()->forceAbsoluteUrls(true);
   	$html = \nn\t3::Tsfe()->cObjGetSingle('RECORDS', $conf);
   	// Wenn data-Array übergeben wurde, Ergebnis erneut über Fluid Standalone-View parsen.
   	if ($data) {
   		$html = \nn\t3::Template()->renderHtml($html, $data);
   	}
   	return $html;
   }
   

