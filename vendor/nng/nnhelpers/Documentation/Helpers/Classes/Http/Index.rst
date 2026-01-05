
.. include:: ../../../Includes.txt

.. _Http:

==============================================
Http
==============================================

\\nn\\t3::Http()
----------------------------------------------

Make simple redirects, build URLs

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Http()->buildUri(``$pageUid, $vars = [], $absolute = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Build URI, works in frontend and backend context.
Takes realURL into account

.. code-block:: php

	\nn\t3::Http()->buildUri( 123 );
	\nn\t3::Http()->buildUri( 123, ['test'=>1], true );

| ``@return string``

| :ref:`➜ Go to source code of Http::buildUri() <Http-buildUri>`

\\nn\\t3::Http()->followRedirect(``$url``);
"""""""""""""""""""""""""""""""""""""""""""""""

Determine redirect destination

.. code-block:: php

	\nn\t3::Http()->followRedirect( 'https://www.99grad.de/some/redirect' );

| ``@param string $url``
| ``@return void``

| :ref:`➜ Go to source code of Http::followRedirect() <Http-followRedirect>`

\\nn\\t3::Http()->redirect(``$pidOrUrl = NULL, $vars = [], $varsPrefix = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Redirect to a page

.. code-block:: php

	\nn\t3::Http()->redirect( 'https://www.99grad.de' );
	\nn\t3::Http()->redirect( 10 ); // => path/to/pageId10
	\nn\t3::Http()->redirect( 10, ['test'=>'123'] ); // => path/to/pageId10&test=123
	\nn\t3::Http()->redirect( 10, ['test'=>'123'], 'tx_myext_plugin' );
| ``@return void``

| :ref:`➜ Go to source code of Http::redirect() <Http-redirect>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
