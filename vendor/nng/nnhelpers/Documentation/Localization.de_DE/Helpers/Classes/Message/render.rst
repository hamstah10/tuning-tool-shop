
.. include:: ../../../../Includes.txt

.. _Message-render:

==============================================
Message::render()
==============================================

\\nn\\t3::Message()->render(``$queueID = NULL``);
----------------------------------------------

Rendert die Flash-Messages in der Queue
Simples Beispiel:

.. code-block:: php

	\nn\t3::Message()->OK('Ja', 'Nein');
	echo \nn\t3::Message()->render();

Beispiel mit einer Queue-ID:

.. code-block:: php

	\nn\t3::Message()->setId('oben')->OK('Ja', 'Nein');
	echo \nn\t3::Message()->render('oben');

Ausgabe im Fluid über den ViewHelper:

.. code-block:: php

	<nnt3:flashMessages id="oben" />
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
   

