
.. include:: ../../../Includes.txt

.. _Mail:

==============================================
Mail
==============================================

\\nn\\t3::Mail()
----------------------------------------------

Helferlein für den Mailversand

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Mail()->send(``$paramOverrides = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine E-Mail senden.

.. code-block:: php

	$html = \nn\t3::Template()->render('MailTemplate', ['varKey'=>'varValue'], 'tx_extname_plugin');
	
	\nn\t3::Mail()->send([
	    'html'            => $html,
	    'plaintext'       => Optional: Text-Version
	    'fromEmail'       => Absender-Email
	    'fromName'        => Absender-Name
	    'toEmail'     => Empfänger-Email(s)
	    'ccToEmail'       => CC Empfänger-Email(s)
	    'bccToEmail'  => BCC Empfänger-Email(s)
	    'replyToEmail'    => Antwort an Empfänger-Email
	    'replyToName' => Antwort an Name
	    'subject'     => Betreff
	    'attachments' => [...],
	    'emogrify'        => CSS-Stile in Inline-Styles umwandeln (default: `true`)
	    'absPrefix'       => Relative Pfade in absolute umwandeln (default: `true`)
	    'headers'     => ['List-Unsubscribe' => '<mailto:unsubscribe@99grad.de>, <https://www.unsubscribe.com>'],
	]);

Bilder einbetten mit    ``<img data-embed="1" src="..." />``
Dateianhänge mit        ``<a data-embed="1" href="..." />``
| ``@return void``

| :ref:`➜ Go to source code of Mail::send() <Mail-send>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
