
.. include:: ../../../../Includes.txt

.. _Message-flush:

==============================================
Message::flush()
==============================================

\\nn\\t3::Message()->flush(``$queueID = NULL``);
----------------------------------------------

Löscht alle Flash-Messages
Optional kann eine Queue-ID angegeben werden.

.. code-block:: php

	\nn\t3::Message()->flush('oben');
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
   

