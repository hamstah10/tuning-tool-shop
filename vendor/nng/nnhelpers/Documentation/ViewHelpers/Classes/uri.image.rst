
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\Uri\ImageViewHelper:

=======================================
uri.image
=======================================

Description
---------------------------------------

<nnt3:uri.image />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

[Translate to EN] Vereinfacht die Verwendung des Uri.ImageViewhelpers.

Wirft keinen Fehler, falls kein ``image`` oder ``src`` übergeben wurde.
Erlaubt auch die Übergabe eines Arrays, zieht sich einfach das erste Bild.

.. code-block:: php

	// tt_content.image ist eigentlich ein Array. Es wird einfach das erste Bild gerendert!
	{nnt3:uri.image(image:data.image)}
	
	// wirft keinen Fehler (falls der Redakteur kein Bild hochgeladen hat!)
	{nnt3:uri.image(image:'')}

