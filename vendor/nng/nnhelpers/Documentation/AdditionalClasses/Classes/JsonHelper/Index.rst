
.. include:: ../../../Includes.txt

.. _JsonHelper:

==============================================
JsonHelper
==============================================

\\nn\\t3::JsonHelper()
----------------------------------------------

The script helps to convert and parse JavaScript object strings into an array.

.. code-block:: php

	$data = \Nng\Nnhelpers\Helpers\JsonHelper::decode( "{title:'Test', cat:[2,3,4]}" );
	print_r($data);

The helper makes it possible to use the JavaScript object notation in TypoScript and to convert it into an array via the ``{nnt3:parse.json()}`` ViewHelper.
This is practical if, for example, slider configurations or other JavaScript objects are to be defined in TypoScript in order to use them later in JavaScript.

Another application example: You want to use the "normal" JS syntax in a ``.json file`` instead of the JSON syntax.
Let's take a look at an example. This text was written in a text file and is to be parsed via PHP:

.. code-block:: php

	// Contents of a text file.
	{
	    example: ['one', 'two', 'three']
	}

PHP would report an error in this example with ``json_decode()``: The string contains comments, wrapping and the keys and values are not enclosed in double quotes. However, the JsonHelper or the ViewHelper ``$jsonHelper->decode()`` can easily convert it.

This is how you could define a JS object in the TypoScript setup:

.. code-block:: php

	// Content in the TS setup
	my_conf.data (
	  {
	     dots: true,
	     sizes: [1, 2, 3]
	  }
	)

The mixture is a little confusing: ``my_conf.data (...)`` opens a section for multiline code in the TypoScript.
There is then a "normal" JavaScript object between the ``(...)``
This can then simply be used as an array in the Fluid template:

.. code-block:: php

	{nnt3:ts.setup(path:'my_conf.data')->f:variable(name:'myConfig')}
	{myConfig->nnt3:parse.json()->f:debug()}

Or attach it to an element as a data attribute to parse it later via JavaScript:

.. code-block:: php

	{nnt3:ts.setup(path:'my_conf.data')->f:variable(name:'myConfig')}
	...

This script is mainly based on the work of https://bit.ly/3eZuNu2 and
has been optimized by us for PHP 7+.all credit and glory please in this direction.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::JsonHelper()->decode(``$str, $useArray = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a JS object string into an array.

.. code-block:: php

	$data = \Nng\Nnhelpers\Helpers\JsonHelper::decode( "{title:'Test', cat:[2,3,4]}" );
	print_r($data);

The PHP function ``json_decode()`` only works with JSON syntax: ``{"key": "value"}``. Neither line breaks nor comments are allowed in JSON.
This function can also be used to parse strings in JavaScript notation.

| ``@return array|string``

| :ref:`➜ Go to source code of JsonHelper::decode() <JsonHelper-decode>`

\\nn\\t3::JsonHelper()->encode(``$var``);
"""""""""""""""""""""""""""""""""""""""""""""""

Converts a variable into JSON format.
Relic of the original class, probably from a time when ``json_encode()`` did not yet exist.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\JsonHelper::encode(['a'=>1, 'b'=>2]);

| ``@return string;``

| :ref:`➜ Go to source code of JsonHelper::encode() <JsonHelper-encode>`

\\nn\\t3::JsonHelper()->removeCommentsAndDecode(``$str, $useArray = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Removes comments from the code and parses the string.

.. code-block:: php

	\Nng\Nnhelpers\Helpers\JsonHelper::removeCommentsAndDecode( "// Comment\n{title:'Test', cat:[2,3,4]}" )

| ``@return array|string``

| :ref:`➜ Go to source code of JsonHelper::removeCommentsAndDecode() <JsonHelper-removeCommentsAndDecode>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
