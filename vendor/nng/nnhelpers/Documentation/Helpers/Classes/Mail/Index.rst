
.. include:: ../../../Includes.txt

.. _Mail:

==============================================
Mail
==============================================

\\nn\\t3::Mail()
----------------------------------------------

Little helper for sending emails

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Mail()->send(``$paramOverrides = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Send an e-mail.

.. code-block:: php

	$html = \nn\t3::Template()->render('MailTemplate', ['varKey'=>'varValue'], 'tx_extname_plugin');
	
	\nn\t3::Mail()->send([
	    'html' => $html,
	    'plaintext' => Optional: text version
	    'fromEmail' => Sender email
	    'fromName' => Sender name
	    'toEmail' => Recipient email(s)
	    'ccToEmail' => CC recipient email(s)
	    'bccToEmail' => BCC recipient email(s)
	    'replyToEmail' => Reply to recipient's email
	    'replyToName' => Reply to name
	    'subject' => Subject
	    'attachments' => [...],
	    'emogrify' => Convert CSS styles to inline styles (default: `true`)
	    'absPrefix' => Convert relative paths to absolute paths (default: `true`)
	    'headers' => ['List-Unsubscribe' => ', <https://www.unsubscribe.com>'],
	]);

Embed images with    ````
File attachments with    ````
| ``@return void``

| :ref:`➜ Go to source code of Mail::send() <Mail-send>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
