
.. include:: ../../../Includes.txt

.. _Log:

==============================================
Log
==============================================

\\nn\\t3::Log()
----------------------------------------------

Log to the ``sys_log`` table

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Log()->error(``$extName = '', $message = '', $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Write a warning in the sys_log table.
Abbreviation for \nn\t3::Log()->log(..., 'error');

.. code-block:: php

	    \nn\t3::Log()->error( 'extname', 'text', ['die'=>'data'] );

return void

| :ref:`➜ Go to source code of Log::error() <Log-error>`

\\nn\\t3::Log()->info(``$extName = '', $message = '', $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Write an info to the sys_log table.
Abbreviation for \nn\t3::Log()->log(..., 'info');

.. code-block:: php

	    \nn\t3::Log()->error( 'extname', 'text', ['die'=>'data'] );

return void

| :ref:`➜ Go to source code of Log::info() <Log-info>`

\\nn\\t3::Log()->log(``$extName = 'nnhelpers', $message = NULL, $data = [], $severity = 'info'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Writes an entry to the ``sys_log`` table.
The severity level can be specified, e.g. ``info``, ``warning`` or ``error``

.. code-block:: php

	\nn\t3::Log()->log( 'extname', 'Alles Ã¼bel.', ['nix'=>'gut'], 'error' );
	\nn\t3::Log()->log( 'extname', 'Alles schÃ¶n.' );

| ``@return mixed``

| :ref:`➜ Go to source code of Log::log() <Log-log>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
