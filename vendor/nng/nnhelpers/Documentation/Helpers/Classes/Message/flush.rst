
.. include:: ../../../../Includes.txt

.. _Message-flush:

==============================================
Message::flush()
==============================================

\\nn\\t3::Message()->flush(``$queueID = NULL``);
----------------------------------------------

Deletes all flash messages
Optionally, a queue ID can be specified.

.. code-block:: php

	\nn\t3::Message()->flush('above');
	\nn\t3::Message()->flush();

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function flush( $queueID = null ) {
   	$flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
   	$queueID = $queueID ?: $this->queueId ?: 'core.template.flashMessages';
   	$messageQueue = $flashMessageService->getMessageQueueByIdentifier( $queueID );
   	return $messageQueue->getAllMessagesAndFlush() ?: [];
   }
   

