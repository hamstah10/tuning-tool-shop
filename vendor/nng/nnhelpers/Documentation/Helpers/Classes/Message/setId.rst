
.. include:: ../../../../Includes.txt

.. _Message-setId:

==============================================
Message::setId()
==============================================

\\nn\\t3::Message()->setId(``$name = NULL``);
----------------------------------------------

Determines which MessageQueue is to be used

.. code-block:: php

	\nn\t3::Message()->setId('top')->OK('Title', 'Infotext');

Output in Fluid via ViewHelper:

.. code-block:: php

	
	{nnt3:flashMessages(id:'above')}

| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function setId( $name = null ) {
   	$this->queueId = $name;
   	return $this;
   }
   

