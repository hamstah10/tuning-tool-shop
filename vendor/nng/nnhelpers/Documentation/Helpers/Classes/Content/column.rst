
.. include:: ../../../../Includes.txt

.. _Content-column:

==============================================
Content::column()
==============================================

\\nn\\t3::Content()->column(``$colPos, $pageUid = NULL, $slide = NULL``);
----------------------------------------------

Loads the content for a specific column``(colPos``) and page.
If no pageUid is specified, it uses the current page.
With ``slide``, the content element of the parent page is fetched if no content element exists in the column on the specified page.

Get content of ``colPos = 110`` from the current page:

.. code-block:: php

	\nn\t3::Content()->column( 110 );

Get content of ``colPos = 110`` from the current page. If there is no content in the column on the current page, use the content from the parent page:

.. code-block:: php

	\nn\t3::Content()->column( 110, true );

Get the content of ``colPos = 110`` from the page with id ``99``:

.. code-block:: php

	\nn\t3::Content()->column( 110, 99 );

Get content of ``colPos = 110`` from the page with id ``99``. If there is no content in the column on page ``99``, use the content from the parent page of page ``99``:

.. code-block:: php

	\nn\t3::Content()->column( 110, 99, true );

Also available as ViewHelper:

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
   

