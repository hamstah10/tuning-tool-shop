
.. include:: ../../../Includes.txt

.. _Errors:

==============================================
Errors
==============================================

\\nn\\t3::Errors()
----------------------------------------------

Output errors and exceptions

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Errors()->Error(``$message, $code = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Throw an error with backtrace

.. code-block:: php

	\nn\t3::Errors()->Error('Damn', 1234);

Is an alias to:

.. code-block:: php

	\nn\t3::Error('Damn', 1234);

| ``@return void``

| :ref:`➜ Go to source code of Errors::Error() <Errors-Error>`

\\nn\\t3::Errors()->Exception(``$message, $code = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Throw a Typo3 exception with backtrace

.. code-block:: php

	\nn\t3::Errors()->Exception('Damn', 1234);

Is an alias to:

.. code-block:: php

	\nn\t3::Exception('Damn', 1234);

| ``@return void``

| :ref:`➜ Go to source code of Errors::Exception() <Errors-Exception>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
