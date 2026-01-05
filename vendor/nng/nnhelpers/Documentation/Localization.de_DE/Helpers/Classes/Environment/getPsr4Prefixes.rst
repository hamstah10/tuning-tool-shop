
.. include:: ../../../../Includes.txt

.. _Environment-getPsr4Prefixes:

==============================================
Environment::getPsr4Prefixes()
==============================================

\\nn\\t3::Environment()->getPsr4Prefixes();
----------------------------------------------

Liste der PSR4 Prefixes zurückgeben.

Das ist ein Array mit allen Ordnern, die beim autoloading / Bootstrap von TYPO3 nach Klassen
geparsed werden müssen. In einer TYPO3 Extension ist das per default der Ordern ``Classes``.
Die Liste wird von Composer/TYPO3 generiert.

Zurückgegeben wird ein array. Key ist ``Vendor\Namespace\``, Wert ist ein Array mit Pfaden zu den Ordnern,
die rekursiv nach Klassen durchsucht werden. Es spielt dabei keine Rolle, ob TYPO3 im composer
mode läuft oder nicht.

.. code-block:: php

	\nn\t3::Environment()->getPsr4Prefixes();

Beispiel für Rückgabe:

.. code-block:: php

	[
	    'Nng\Nnhelpers\' => ['/pfad/zu/composer/../../public/typo3conf/ext/nnhelpers/Classes', ...],
	    'Nng\Nnrestapi\' => ['/pfad/zu/composer/../../public/typo3conf/ext/nnrestapi/Classes', ...]
	]

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getPsr4Prefixes() {
   	$composerClassLoader = ClassLoadingInformation::getClassLoader();
   	$psr4prefixes = $composerClassLoader->getPrefixesPsr4();
   	return $psr4prefixes;
   }
   

