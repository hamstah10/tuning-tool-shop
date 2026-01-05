
.. include:: ../../../../Includes.txt

.. _Tsfe-includeHiddenRecords:

==============================================
Tsfe::includeHiddenRecords()
==============================================

\\nn\\t3::Tsfe()->includeHiddenRecords(``$includeHidden = false, $includeStartEnd = false, $includeDeleted = false``);
----------------------------------------------

Get hidden content elements in the frontend.
Can be used before rendering.

.. code-block:: php

	\nn\t3::Tsfe()->includeHiddenRecords(true, true, true);
	$html = \nn\t3::Content()->render(123);

| ``@param bool $includeHidden``
| ``@param bool $includeStartEnd``
| ``@param bool $includeDeleted``
| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function includeHiddenRecords($includeHidden = false, $includeStartEnd = false, $includeDeleted = false)
   {
   	$context = GeneralUtility::makeInstance(Context::class);
   	$current = $context->getAspect('visibility');
   	$includeHidden		= $includeHidden || (method_exists($current, 'includesHiddenPages') ? $current->includesHiddenPages() : false);
   	$includeDeleted		= $includeDeleted || (method_exists($current, 'includesDeletedRecords') ? $current->includesDeletedRecords() : false);
   	$includeStartEnd	= $includeStartEnd || (method_exists($current, 'includesStartEndRecords') ? $current->includesStartEndRecords() : false);
   	$context->setAspect(
   		'visibility',
   		GeneralUtility::makeInstance(
   			VisibilityAspect::class,
   			$includeHidden,		// pages
   			$includeHidden,		// tt_content
   			$includeDeleted,
   			$includeStartEnd
   		)
   	);
   }
   

