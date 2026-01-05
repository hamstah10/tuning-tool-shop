
.. include:: ../../../../Includes.txt

.. _Mail-send:

==============================================
Mail::send()
==============================================

\\nn\\t3::Mail()->send(``$paramOverrides = []``);
----------------------------------------------

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

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function send ( $paramOverrides = [] ) {
   	\nn\t3::autoload();
   	// Defaults mergen mit Parametern
   	$params = [
   		'emogrify'	=> true,
   		'absPrefix'	=> true,
   	];
   	ArrayUtility::mergeRecursiveWithOverrule( $params, $paramOverrides);
   	$mail = GeneralUtility::makeInstance(MailMessage::class);
   	$html = $params['html'] ?? '';
   	$pathSite = \nn\t3::Environment()->getPathSite();
   	$recipients = \nn\t3::Arrays($params['toEmail'] ?? '')->trimExplode();
   	$fromEmail = array_shift(\nn\t3::Arrays($params['fromEmail'] ?? '')->trimExplode());
   	if ($replyToEmail = $params['replyToEmail'] ?? false) {
   		$mail->replyTo( new \Symfony\Component\Mime\Address($replyToEmail, $params['replyToName'] ?? '') );
   	}
   	if ($ccToEmail = $params['ccToEmail'] ?? false) {
   		$ccToEmail = \nn\t3::Arrays($ccToEmail)->trimExplode();
   		$mail->setCc( $ccToEmail );
   	}
   	if ($bccToEmail = $params['bccToEmail'] ?? false) {
   		$bccToEmail = \nn\t3::Arrays($bccToEmail)->trimExplode();
   		$mail->setBcc( $bccToEmail );
   	}
   	$mail->from( new \Symfony\Component\Mime\Address($fromEmail, $params['fromName'] ?? '') );
   	$mail->to(...$recipients);
   	$mail->subject($params['subject'] ?? '');
   	// Inline-Media im HTML-Code finden (<img data-embed="1" src="..." />)
   	$dom = new \DOMDocument();
   	@$dom->loadHTML($html);
   	// XPATH Cheat-Sheet: https://devhints.io/xpath
   	$xpath = new \DOMXPath($dom);
   	$nodes = $xpath->query('//*[@data-embed]');
   	$attachedFiles = [];
   	foreach ($nodes as $node) {
   		if ($img = $node->getAttribute('src')) {
   			$node->removeAttribute('data-embed');
   			$cid = 'img-' . md5($pathSite . $img);
   			$node->setAttribute('src', 'cid:'.$cid);
   			$mail->embedFromPath( $pathSite . $img, $cid );
   		}
   		if ($file = $node->getAttribute('href')) {
   			if (!isset($attachedFiles[$pathSite . $file])) {
   				$absPath = \nn\t3::File()->absPath( $file );
   				$mail->attachFromPath( $absPath );
   				$attachedFiles[$absPath] = true;
   			}
   		}
   	}
   	// Zusätzlich Anhänge?
   	$attachments = \nn\t3::Arrays($params['attachments'] ?? '')->trimExplode();
   	foreach ($attachments as $path) {
   		if (!isset($attachedFiles[$pathSite . $path])) {
   			$absPath = \nn\t3::File()->absPath( $path );
   			$mail->attachFromPath( $absPath );
   			$attachedFiles[ $absPath ] = true;
   		}
   	}
   	$html = $dom->saveHTML();
   	// Relative Pfade im Quelltext mit absoluten Pfaden ersetzen
   	if ($params['absPrefix'] ?? false) {
   		$html = \nn\t3::Dom()->absPrefix( $html );
   	}
   	// CSS in Inline-Styles umwandeln
   	if ($params['emogrify'] ?? false) {
   		$html = CssInliner::fromHtml($html)->inlineCss()->render();
   	}
   	$plaintext = $params['plaintext'] ?? strip_tags($html);
   	if ($html) {
   		$mail->html($html);
   		$mail->text($plaintext);
   	} else {
   		$mail->text($plaintext);
   	}
   	$returnPath = $params['returnPath_email'] ?? \TYPO3\CMS\Core\Utility\MailUtility::getSystemFromAddress();
   	if (strpos($returnPath, 'no-reply') === false) {
   		$mail->setReturnPath( $returnPath );
   	}
   	// zsätzliche Header?
   	if ($headers = $params['headers'] ?? false) {
   		$mailHeaders = $mail->getHeaders();
   		foreach ($headers as $k=>$v) {
   			$mailHeaders->addTextHeader($k, $v);
   		}
   	}
   	$sent = $mail->send();
   	if (!$sent) {
   /*
   		\nn\t3::Log()->error('nnhelpers', 'Mail not sent', $recipients);
   		$fp = fopen('mail_error.log', 'a');
   		$to = join(',', $recipients);
   		fputs($fp, date('d.m.Y H:i:s')." {$to}\n\n\n");
   		fclose($fp);
   		$helpMail = $this->params['errorMail_email'];
   		$mail->setReturnPath( $helpMail );
   		$mail->setTo( $helpMail );
   		$mail->setSubject('Mailversand: FEHLER!');
   		$mail->send();
   //*/
   	}
   	return $sent;
   }
   

