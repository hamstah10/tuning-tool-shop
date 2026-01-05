
.. include:: ../../../../Includes.txt

.. _Content-column:

==============================================
Content::column()
==============================================

\\nn\\t3::Content()->column(``$colPos, $pageUid = NULL, $slide = NULL``);
----------------------------------------------

Lädt den Content für eine bestimmte Spalte (``colPos``) und Seite.
Wird keine pageUid angegeben, verwendet er die aktuelle Seite.
Mit ``slide`` werden die Inhaltselement der übergeordnete Seite geholt, falls auf der angegeben Seiten kein Inhaltselement in der Spalte existiert.

Inhalt der ``colPos = 110`` von der aktuellen Seite holen:

.. code-block:: php

	\nn\t3::Content()->column( 110 );

Inhalt der ``colPos = 110`` von der aktuellen Seite holen. Falls auf der aktuellen Seite kein Inhalt in der Spalte ist, den Inhalt aus der übergeordneten Seite verwenden:

.. code-block:: php

	\nn\t3::Content()->column( 110, true );

Inhalt der ``colPos = 110`` von der Seite mit id ``99`` holen:

.. code-block:: php

	\nn\t3::Content()->column( 110, 99 );

Inhalt der ``colPos = 110`` von der Seite mit der id ``99`` holen. Falls auf Seite ``99`` kein Inhalt in der Spalte ist, den Inhalt aus der übergeordneten Seite der Seite ``99`` verwenden:

.. code-block:: php

	\nn\t3::Content()->column( 110, 99, true );

Auch als ViewHelper vorhanden:

.. code-block:: php

	{nnt3:content.column(colPos:110)}
	{nnt3:content.column(colPos:110, slide:1)}
	{nnt3:content.column(colPos:110, pid:99)}
	{nnt3:content.column(colPos:110, pid:99, slide:1)}

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function column($colPos, $pageUid = null, $slide = null)
   {
   	if ($slide === null && $pageUid === true) {
   		$pageUid = null;
   		$slide = true;
   	}
   	if (!$pageUid && !$slide) $pageUid = \nn\t3::Page()->getPid();
   	$conf = [
   		'table' => 'tt_content',
   		'select.' => [
   			'orderBy' => 'sorting',
   			'where' => 'colPos=' . intval($colPos),
   		],
   	];
   	if ($pageUid) {
   		$conf['select.']['pidInList'] = intval($pageUid);
   	}
   	if ($slide) {
   		$conf['slide'] = -1;
   	}
   	$html = \nn\t3::Tsfe()->cObjGetSingle('CONTENT', $conf);
   	return $html;
   }
   

