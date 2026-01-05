
.. include:: ../../../Includes.txt

.. _TypoScriptHelper:

==============================================
TypoScriptHelper
==============================================

\\nn\\t3::TypoScriptHelper()
----------------------------------------------

[Translate to EN] Helper for TypoScript

.. code-block:: php

	$typoScriptHelper = \nn\t3::injectClass( \Nng\Nnhelpers\Helpers\TypoScriptHelper::class );
	$typoScriptHelper->getTypoScript( 1 );

All credits to this script go to Stoppeye on StackOverflow:
https://stackoverflow.com/questions/77151557/typo3-templateservice-deprecation-how-to-get-plugin-typoscript-not-in-fe-cont

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::TypoScriptHelper()->getTypoScript(``$pageUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

[Translate to EN] Get complete TypoScript setup for a given page ID following TYPO3 13 approach.

.. code-block:: php

	$typoScriptHelper = \nn\t3::injectClass( \Nng\Nnhelpers\Helpers\TypoScriptHelper::class );
	
	// get typoscript for current page
	$typoScriptHelper->getTypoScript();
	
	// get typoscript for page with uid 1
	$typoScriptHelper->getTypoScript( 1 );
	

| ``@param int $pageUid`` Page UID to get TypoScript for
| ``@return array Complete TypoScript setup with dot-syntax``

| :ref:`➜ Go to source code of TypoScriptHelper::getTypoScript() <TypoScriptHelper-getTypoScript>`

\\nn\\t3::TypoScriptHelper()->getTypoScriptObject(``$pageUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

[Translate to EN] Get the TypoScript setup as TypoScript object.

| ``@param int $pageUid`` Page UID to get TypoScript for
| ``@return \TYPO3\CMS\Core\TypoScript\FrontendTypoScript``

| :ref:`➜ Go to source code of TypoScriptHelper::getTypoScriptObject() <TypoScriptHelper-getTypoScriptObject>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
