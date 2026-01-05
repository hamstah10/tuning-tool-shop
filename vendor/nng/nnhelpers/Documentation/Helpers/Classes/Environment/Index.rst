
.. include:: ../../../Includes.txt

.. _Environment:

==============================================
Environment
==============================================

\\nn\\t3::Environment()
----------------------------------------------

Everything you need to know about the application's environment.
From the user's language ID and the baseUrl to the question of which extensions are running.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Environment()->extLoaded(``$extName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Check whether extension is loaded.

.. code-block:: php

	\nn\t3::Environment()->extLoaded('news');

| :ref:`➜ Go to source code of Environment::extLoaded() <Environment-extLoaded>`

\\nn\\t3::Environment()->extPath(``$extName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the absolute path to an extension
e.g. ``/var/www/website/ext/nnsite/``

.. code-block:: php

	\nn\t3::Environment()->extPath('extname');

| ``@return string``

| :ref:`➜ Go to source code of Environment::extPath() <Environment-extPath>`

\\nn\\t3::Environment()->extRelPath(``$extName = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the relative path (from the current script) to an extension
e.g. ``../typo3conf/ext/nnsite/``

.. code-block:: php

	\nn\t3::Environment()->extRelPath('extname');

| ``@return string``

| :ref:`➜ Go to source code of Environment::extRelPath() <Environment-extRelPath>`

\\nn\\t3::Environment()->getBaseURL();
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the baseUrl``(config.baseURL``), incl. http(s) protocol e.g. https://www.webseite.de/

.. code-block:: php

	\nn\t3::Environment()->getBaseURL();

| ``@return string``

| :ref:`➜ Go to source code of Environment::getBaseURL() <Environment-getBaseURL>`

\\nn\\t3::Environment()->getCookieDomain(``$loginType = 'FE'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the cookie domain e.g. www.webseite.de

.. code-block:: php

	\nn\t3::Environment()->getCookieDomain()

| ``@return string``

| :ref:`➜ Go to source code of Environment::getCookieDomain() <Environment-getCookieDomain>`

\\nn\\t3::Environment()->getCountries(``$lang = 'de', $key = 'cn_iso_2'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get all countries available in the system

.. code-block:: php

	\nn\t3::Environment()->getCountries();

| ``@return array``

| :ref:`➜ Go to source code of Environment::getCountries() <Environment-getCountries>`

\\nn\\t3::Environment()->getCountryByIsocode(``$cn_iso_2 = NULL, $field = 'cn_iso_2'``);
"""""""""""""""""""""""""""""""""""""""""""""""

A country from the ``static_countries``table
using its country code (e.g. ``DE``)

.. code-block:: php

	\nn\t3::Environment()->getCountryByIsocode( 'DE' );
	\nn\t3::Environment()->getCountryByIsocode( 'DEU', 'cn_iso_3' );

| ``@return array``

| :ref:`➜ Go to source code of Environment::getCountryByIsocode() <Environment-getCountryByIsocode>`

\\nn\\t3::Environment()->getDefaultLanguage(``$returnKey = 'typo3Language'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns the default language (Default Language). In TYPO3, this is always the language with ID ``0``
The languages must be defined in the YAML site configuration.

.. code-block:: php

	// 'de'
	\nn\t3::Environment()->getDefaultLanguage();
	
	// 'de-DE'
	\nn\t3::Environment()->getDefaultLanguage('hreflang');
	
	// ['title'=>'German', 'typo3Language'=>'de', ...]
	\nn\t3::Environment()->getDefaultLanguage( true );

| ``@param string|boolean $returnKey``
| ``@return string|array``

| :ref:`➜ Go to source code of Environment::getDefaultLanguage() <Environment-getDefaultLanguage>`

\\nn\\t3::Environment()->getDomain();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the domain e.g. www.webseite.de

.. code-block:: php

	\nn\t3::Environment()->getDomain();

| ``@return string``

| :ref:`➜ Go to source code of Environment::getDomain() <Environment-getDomain>`

\\nn\\t3::Environment()->getExtConf(``$ext = 'nnhelpers', $param = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get configuration from ``ext_conf_template.txt`` (backend, extension configuration)

.. code-block:: php

	\nn\t3::Environment()->getExtConf('nnhelpers', 'varname');

Also exists as ViewHelper:

.. code-block:: php

	{nnt3:ts.extConf(path:'nnhelper')}
	{nnt3:ts.extConf(path:'nnhelper.varname')}
	{nnt3:ts.extConf(path:'nnhelper', key:'varname')}

| ``@return mixed``

| :ref:`➜ Go to source code of Environment::getExtConf() <Environment-getExtConf>`

\\nn\\t3::Environment()->getLanguage();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the current language (as a number) of the frontend.

.. code-block:: php

	\nn\t3::Environment()->getLanguage();

| ``@return int``

| :ref:`➜ Go to source code of Environment::getLanguage() <Environment-getLanguage>`

\\nn\\t3::Environment()->getLanguageFallbackChain(``$langUid = true``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns a list of the languages that should be used if, for example
e.g. a page or element does not exist in the desired language.

Important: The fallback chain contains in the first place the current or in $langUid
transferred language.

.. code-block:: php

	// Use settings for current language (see Site-Config YAML)
	\nn\t3::Environment()->getLanguageFallbackChain(); // --> e.g. [0] or [1,0]
	
	// Get settings for a specific language
	\nn\t3::Environment()->getLanguageFallbackChain( 1 );
	// --> [1,0] - if fallback was defined in Site-Config and the fallbackMode is set to "fallback"
	// --> [1] - if there is no fallback or the fallbackMode is set to "strict"

| ``@param string|boolean $returnKey``
| ``@return string|array``

| :ref:`➜ Go to source code of Environment::getLanguageFallbackChain() <Environment-getLanguageFallbackChain>`

\\nn\\t3::Environment()->getLanguageKey();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the current language (as abbreviation like "de") in the frontend

.. code-block:: php

	\nn\t3::Environment()->getLanguageKey();

| ``@return string``

| :ref:`➜ Go to source code of Environment::getLanguageKey() <Environment-getLanguageKey>`

\\nn\\t3::Environment()->getLanguages(``$key = 'languageId', $value = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns a list of all defined languages.
The languages must be defined in the YAML site configuration.

.. code-block:: php

	// [['title'=>'German', 'iso-639-1'=>'de', 'typo3Language'=>'de', ....], ['title'=>'English', 'typo3Language'=>'en', ...]]
	\nn\t3::Environment()->getLanguages();
	
	// ['de'=>['title'=>'German', 'typo3Language'=>'de'], 'en'=>['title'=>'English', 'typo3Language'=>'en', ...]]
	\nn\t3::Environment()->getLanguages('iso-639-1');
	
	// ['de'=>0, 'en'=>1]
	\nn\t3::Environment()->getLanguages('iso-639-1', 'languageId');
	
	// [0=>'de', 1=>'en']
	\nn\t3::Environment()->getLanguages('languageId', 'iso-639-1');

There are also helpers for converting language IDs into language abbreviations
and vice versa:

.. code-block:: php

	// --> 0
	\nn\t3::Convert('de')->toLanguageId();
	
	// --> 'de'
	\nn\t3::Convert(0)->toLanguage();

| ``@param string $key``
| ``@param string $value``
| ``@return string|array``

| :ref:`➜ Go to source code of Environment::getLanguages() <Environment-getLanguages>`

\\nn\\t3::Environment()->getLocalConf(``$path = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get configuration from ``LocalConfiguration.php`` 

.. code-block:: php

	\nn\t3::Environment()->getLocalConf('FE.cookieName');

| ``@return string``

| :ref:`➜ Go to source code of Environment::getLocalConf() <Environment-getLocalConf>`

\\nn\\t3::Environment()->getPathSite();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the absolute path to the Typo3 root directory. e.g. ``/var/www/website/``

.. code-block:: php

	\nn\t3::Environment()->getPathSite()

Formerly: ``PATH_site``

| :ref:`➜ Go to source code of Environment::getPathSite() <Environment-getPathSite>`

\\nn\\t3::Environment()->getPostMaxSize();
"""""""""""""""""""""""""""""""""""""""""""""""

Return maximum upload size for files from the frontend.
This specification is the value that was defined in php.ini and, if necessary
was overwritten via the .htaccess.

.. code-block:: php

	\nn\t3::Environment()->getPostMaxSize(); // e.g. '1048576' for 1MB

| ``@return integer``

| :ref:`➜ Go to source code of Environment::getPostMaxSize() <Environment-getPostMaxSize>`

\\nn\\t3::Environment()->getPsr4Prefixes();
"""""""""""""""""""""""""""""""""""""""""""""""

Return list of PSR4 prefixes.

This is an array with all folders that must be parsed by class when autoloading / bootstrapping TYPO3
have to be parsed. In a TYPO3 extension, this is the ``Classes`` folder by default.
The list is generated by Composer/TYPO3.

An array is returned. Key is ``Vendor\Namespace\``, Value is an array with paths to the folders,
which are searched recursively for classes. It does not matter whether TYPO3 is running in composer
mode or not.

.. code-block:: php

	\nn\t3::Environment()->getPsr4Prefixes();

Example for return:

.. code-block:: php

	[
	    'Nng\Nnhelpers\' => ['/path/to/composer/../../public/typo3conf/ext/nnhelpers/Classes', ...],
	    'Nng\Nnrestapi\' => ['/path/to/composer/../../public/typo3conf/ext/nnrestapi/Classes', ...]
	]

| ``@return array``

| :ref:`➜ Go to source code of Environment::getPsr4Prefixes() <Environment-getPsr4Prefixes>`

\\nn\\t3::Environment()->getRelPathSite();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the relative path to the Typo3 root directory. e.g. ``../``

.. code-block:: php

	\nn\t3::Environment()->getRelPathSite()

| ``@return string``

| :ref:`➜ Go to source code of Environment::getRelPathSite() <Environment-getRelPathSite>`

\\nn\\t3::Environment()->getRequest();
"""""""""""""""""""""""""""""""""""""""""""""""

Fetches the current request.
Workaround for special cases - and in the event that the core team
does not implement this option itself in the future.

.. code-block:: php

	$request = \nn\t3::Environment()->getRequest();

| ``@return \TYPO3\CMS\Core\Http\ServerRequest``

| :ref:`➜ Go to source code of Environment::getRequest() <Environment-getRequest>`

\\nn\\t3::Environment()->getSite(``$request = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Get the current ``site`` object.
This object can be used to access the configuration from the site YAML file from TYPO3 9 onwards, for example.

In the context of a MiddleWare, the ``site`` may not yet be parsed / loaded.
In this case, the ``$request`` from the MiddleWare can be passed to determine the site.

See also ``\nn\t3::Settings()->getSiteConfig()`` to read the site configuration.

.. code-block:: php

	\nn\t3::Environment()->getSite();
	\nn\t3::Environment()->getSite( $request );
	
	\nn\t3::Environment()->getSite()->getConfiguration();
	\nn\t3::Environment()->getSite()->getIdentifier();

| ``@return \TYPO3\CMS\Core\Site\Entity\Site``

| :ref:`➜ Go to source code of Environment::getSite() <Environment-getSite>`

\\nn\\t3::Environment()->getSyntheticFrontendRequest(``$pageUid = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Generates a virtual frontend request that can be used in any context.
Also initializes the frontend TypoScript object and all relevant objects.

.. code-block:: php

	$request = \nn\t3::Environment()->getSyntheticFrontendRequest();

| ``@param int $pageUid``
| ``@return \TYPO3\CMS\Core\Http\ServerRequest``

| :ref:`➜ Go to source code of Environment::getSyntheticFrontendRequest() <Environment-getSyntheticFrontendRequest>`

\\nn\\t3::Environment()->getVarPath();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the absolute path to the ``/var directory`` of Typo3.

This directory stores temporary cache files.
Depending on the version of Typo3 and installation type (Composer or Non-Composer mode)
this directory can be found in different locations.

.. code-block:: php

	// /full/path/to/typo3temp/var/
	$path = \nn\t3::Environment()->getVarPath();

| :ref:`➜ Go to source code of Environment::getVarPath() <Environment-getVarPath>`

\\nn\\t3::Environment()->isBackend();
"""""""""""""""""""""""""""""""""""""""""""""""

Check whether we are in the backend context

.. code-block:: php

	    \nn\t3::Environment()->isBackend();

| ``@return bool``

| :ref:`➜ Go to source code of Environment::isBackend() <Environment-isBackend>`

\\nn\\t3::Environment()->isFrontend();
"""""""""""""""""""""""""""""""""""""""""""""""

Check whether we are in the frontend context

.. code-block:: php

	    \nn\t3::Environment()->isFrontend();

| ``@return bool``

| :ref:`➜ Go to source code of Environment::isFrontend() <Environment-isFrontend>`

\\nn\\t3::Environment()->isHttps();
"""""""""""""""""""""""""""""""""""""""""""""""

Returns ``true`` if the page is accessed via HTTPS.

.. code-block:: php

	$isHttps = \nn\t3::Environment()->isHttps();

| ``@return boolean``

| :ref:`➜ Go to source code of Environment::isHttps() <Environment-isHttps>`

\\nn\\t3::Environment()->isLocalhost();
"""""""""""""""""""""""""""""""""""""""""""""""

Checks whether installation is running on local server

.. code-block:: php

	\nn\t3::Environment()->isLocalhost()

| ``@return boolean``

| :ref:`➜ Go to source code of Environment::isLocalhost() <Environment-isLocalhost>`

\\nn\\t3::Environment()->setLanguage(``$languageId = 0``);
"""""""""""""""""""""""""""""""""""""""""""""""

Set the current language.

Helpful if we need the language in a context where it has not been initialized, e.g. in a
initialized, e.g. in a MiddleWare or CLI.

.. code-block:: php

	\nn\t3::Environment()->setLanguage(0);

| ``@param int $languageId``
| ``@return self``

| :ref:`➜ Go to source code of Environment::setLanguage() <Environment-setLanguage>`

\\nn\\t3::Environment()->setRequest(``$request``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sets the current request.
Is set in the ``RequestParser middleware``

.. code-block:: php

	\nn\t3::Environment()->setRequest( $request );

| ``@param \TYPO3\CMS\Core\Http\ServerRequest``
| ``@return self``

| :ref:`➜ Go to source code of Environment::setRequest() <Environment-setRequest>`

\\nn\\t3::Environment()->t3Version();
"""""""""""""""""""""""""""""""""""""""""""""""

Get the version of Typo3, as an integer, e.g. "8"
Alias to ``\nn\t3::t3Version()``

.. code-block:: php

	\nn\t3::Environment()->t3Version();
	
	if (\nn\t3::t3Version() >= 8) {
	    // only for >= Typo3 8 LTS
	}

| ``@return int``

| :ref:`➜ Go to source code of Environment::t3Version() <Environment-t3Version>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
