
.. include:: ../../../Includes.txt

.. _Flexform:

==============================================
Flexform
==============================================

\\nn\\t3::Flexform()
----------------------------------------------

Load and parse FlexForms

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Flexform()->getFalMedia(``$ttContentUid = NULL, $field = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes FAL media that were specified directly in the FlexForm

.. code-block:: php

	\nn\t3::Flexform()->getFalMedia( 'falmedia' );
	\nn\t3::Flexform()->getFalMedia( 'settings.falmedia' );
	\nn\t3::Flexform()->getFalMedia( 1201, 'falmedia' );

.. code-block:: php

	$cObjData = \nn\t3::Tsfe()->cObjData();
	$falMedia = \nn\t3::Flexform()->getFalMedia( $cObjData['uid'], 'falmedia' );

| ``@return array``

| :ref:`➜ Go to source code of Flexform::getFalMedia() <Flexform-getFalMedia>`

\\nn\\t3::Flexform()->getFlexform(``$ttContentUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Retrieves the flexform of a specific content element as an array

.. code-block:: php

	\nn\t3::Flexform()->getFlexform( 1201 );

| ``@return array``

| :ref:`➜ Go to source code of Flexform::getFlexform() <Flexform-getFlexform>`

\\nn\\t3::Flexform()->insertCountries(``$config, $a = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Inserts options from TypoScript for selection in a FlexForm or TCA.

.. code-block:: php

	
	    select
	    
	    nn\t3\Flexform->insertCountries
	    1
	

| ``@return array``

| :ref:`➜ Go to source code of Flexform::insertCountries() <Flexform-insertCountries>`

\\nn\\t3::Flexform()->insertOptions(``$config, $a = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Inserts options from TypoScript for selection in a FlexForm or TCA.

.. code-block:: php

	
	    select
	    
	    nn\t3\Flexform->insertOptions
	    plugin.tx_extname.settings.templates
	    
	    tx_extname.colors
	    
	    value
	    1
	    Nothing
	    
	    1
	

Various types of structure are permitted for the Typoscript:

.. code-block:: php

	plugin.tx_extname.settings.templates {
	    # Direct key => label pairs
	    small = Small Design
	    # ... or: Label set in subarray
	    mid {
	        label = Mid Design
	    }
	    # ... or: Key set in subarray, practical e.g. for CSS classes
	    10 {
	        label = Big Design
	        classes = big big-thing
	    }
	    # ... or a userFunc. Returns one of the variants above as an array
	    30 {
	        userFunc = nn\t3\Flexform->getOptions
	    }
	}

The selection can be restricted to certain controller actions in the TypoScript.
In this example, the "Yellow" option is only displayed if the ``switchableControllerAction``
| ``Category->list`` has been selected.

.. code-block:: php

	plugin.tx_extname.settings.templates {
	    yellow {
	        label = Yellow
	        controllerAction = Category->list,...
	    }
	}

| ``@return array``

| :ref:`➜ Go to source code of Flexform::insertOptions() <Flexform-insertOptions>`

\\nn\\t3::Flexform()->parse(``$xml = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a Flexform XML into an array

.. code-block:: php

	\nn\t3::Flexform()->parse('');

Also exists as a ViewHelper:

.. code-block:: php

	{rawXmlString->nnt3:parse.flexForm()->f:debug()}

| ``@return array``

| :ref:`➜ Go to source code of Flexform::parse() <Flexform-parse>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
