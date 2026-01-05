
.. include:: ../../../../Includes.txt

.. _Message-flash:

==============================================
Message::flash()
==============================================

\\nn\\t3::Message()->flash(``$title = '', $text = '', $type = 'OK', $queueID = NULL``);
----------------------------------------------

Saves a flash message in the message queue for frontend or backend.
| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function flash( $title = '', $text = '', $type = 'OK', $queueID = null )
   {
   	$message = GeneralUtility::makeInstance(FlashMessage::class,
   		$text,
   		$title,
   		constant("TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::{$type}"),
   		true
   	);
   	$flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
   	$queueID = $queueID ?: $this->queueId ?: 'core.template.flashMessages';
   	$messageQueue = $flashMessageService->getMessageQueueByIdentifier( $queueID );
   	$messageQueue->addMessage($message);
   }
   

