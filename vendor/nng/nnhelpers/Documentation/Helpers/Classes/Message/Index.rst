
.. include:: ../../../Includes.txt

.. _Message:

==============================================
Message
==============================================

\\nn\\t3::Message()
----------------------------------------------

Simplifies the use of FlashMessages.

In the backend: FlashMessages are automatically displayed at the top

.. code-block:: php

	\nn\t3::Message()->OK('Title', 'Infotext');
	\nn\t3::Message()->ERROR('Title', 'Infotext');

In the frontend: FlashMessages can be output via ViewHelper

.. code-block:: php

	\nn\t3::Message()->OK('Title', 'Infotext');
	
	
	
	\nn\t3::Message()->setId('top')->OK('Title', 'Infotext');
	
	

... or rendered as HTML and returned:

.. code-block:: php

	echo \nn\t3::Message()->render('above');
	echo \nn\t3::Message()->render();

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Message()->ERROR(``$title = '', $text = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Outputs an "ERROR" flash message

.. code-block:: php

	\nn\t3::Message()->ERROR('Title', 'Infotext');

| ``@return void``

| :ref:`➜ Go to source code of Message::ERROR() <Message-ERROR>`

\\nn\\t3::Message()->OK(``$title = '', $text = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Outputs an "OK" flash message

.. code-block:: php

	\nn\t3::Message()->OK('Title', 'Info text');

| ``@return void``

| :ref:`➜ Go to source code of Message::OK() <Message-OK>`

\\nn\\t3::Message()->WARNING(``$title = '', $text = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Outputs a "WARNING" flash message

.. code-block:: php

	\nn\t3::Message()->WARNING('Title', 'Info text');

| ``@return void``

| :ref:`➜ Go to source code of Message::WARNING() <Message-WARNING>`

\\nn\\t3::Message()->flash(``$title = '', $text = '', $type = 'OK', $queueID = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Saves a flash message in the message queue for frontend or backend.
| ``@return void``

| :ref:`➜ Go to source code of Message::flash() <Message-flash>`

\\nn\\t3::Message()->flush(``$queueID = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Deletes all flash messages
Optionally, a queue ID can be specified.

.. code-block:: php

	\nn\t3::Message()->flush('above');
	\nn\t3::Message()->flush();

| ``@return array``

| :ref:`➜ Go to source code of Message::flush() <Message-flush>`

\\nn\\t3::Message()->render(``$queueID = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Renders the Flash messages in the queue
Simple example:

.. code-block:: php

	\nn\t3::Message()->OK('Yes', 'No');
	echo \nn\t3::Message()->render();

Example with a queue ID:

.. code-block:: php

	\nn\t3::Message()->setId('above')->OK('Yes', 'No');
	echo \nn\t3::Message()->render('above');

Output in the fluid via the ViewHelper:

.. code-block:: php

	
	{nnt3:flashMessages()}

| ``@return string``

| :ref:`➜ Go to source code of Message::render() <Message-render>`

\\nn\\t3::Message()->setId(``$name = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Determines which MessageQueue is to be used

.. code-block:: php

	\nn\t3::Message()->setId('top')->OK('Title', 'Infotext');

Output in Fluid via ViewHelper:

.. code-block:: php

	
	{nnt3:flashMessages(id:'above')}

| ``@return void``

| :ref:`➜ Go to source code of Message::setId() <Message-setId>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
