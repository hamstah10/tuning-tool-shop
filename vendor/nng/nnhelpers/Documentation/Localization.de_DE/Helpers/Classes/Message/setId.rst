
.. include:: ../../../../Includes.txt

.. _Message-setId:

==============================================
Message::setId()
==============================================

\\nn\\t3::Message()->setId(``$name = NULL``);
----------------------------------------------

Legt fest, welcher MessageQueue verwendet werden soll

.. code-block:: php

	\nn\t3::Message()->setId('oben')->OK('Titel', 'Infotext');

Ausgabe in Fluid per ViewHelper:

.. code-block:: php

	<nnt3:flashMessages id="oben" />
	{nnt3:flashMessages(id:'oben')}

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setId( $name = null ) {
   	$this->queueId = $name;
   	return $this;
   }
   

