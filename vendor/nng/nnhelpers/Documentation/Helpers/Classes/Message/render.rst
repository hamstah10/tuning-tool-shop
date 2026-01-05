
.. include:: ../../../../Includes.txt

.. _Message-render:

==============================================
Message::render()
==============================================

\\nn\\t3::Message()->render(``$queueID = NULL``);
----------------------------------------------

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

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function render( $queueID = null ) {
   	if (!($messages = $this->flush($queueID))) return '';
   	$html = GeneralUtility::makeInstance(FlashMessageRendererResolver::class)->resolve()->render($messages);
   	return $html;
   }
   

