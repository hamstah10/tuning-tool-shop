
.. include:: ../../../../Includes.txt

.. _Log-log:

==============================================
Log::log()
==============================================

\\nn\\t3::Log()->log(``$extName = 'nnhelpers', $message = NULL, $data = [], $severity = 'info'``);
----------------------------------------------

Schreibt einen Eintrag in die Tabelle ``sys_log``.
Der severity-Level kann angegeben werden, z.B. ``info``, ``warning`` oder ``error``

.. code-block:: php

	\nn\t3::Log()->log( 'extname', 'Alles übel.', ['nix'=>'gut'], 'error' );
	\nn\t3::Log()->log( 'extname', 'Alles schön.' );

| ``@return mixed``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function log( $extName = 'nnhelpers', $message = null, $data = [], $severity = 'info' ) {
   	if (is_array($message)) $message = join(" · ", $message);
   	$severity = strtoupper( $severity );
   	$logLevel = constant( "\TYPO3\CMS\Core\Log\LogLevel::$severity" );
   	$type = $severity == 'ERROR' ? 5 : 4;	// 4 = type: EXTENSION
   	// Die Core-Methode ist schön, allerdings nur, wenn man wirklich diese Flexibiltät braucht.
   	// Leider sind die Log-Einträge mit dem Core DatabaseWriter nicht im Backend sichtbar.
   	// Wir wollen nur einen einfach Eintrag in sys_log haben und nutzen einen simplen INSERT
   	/*
   	$logger = GeneralUtility::makeInstance( LogManager::class )->getLogger( __CLASS__ );
   	$logger->log( $logLevel, $message, $params );
   	*/
   	\nn\t3::Db()->insert('sys_log', [
   		'details' 		=> "[{$extName}] {$message} " . ($data ? print_r( $data, true ) : ''),
   		'action' 		=> $data['action'] ?? 0,
   		'level'			=> $logLevel,
   		'type'			=> $type,
   		'log_data'		=> serialize($data),
   		'error'			=> $severity == 'ERROR' ? 1 : 0,
   		'tstamp'		=> time(),
   		'IP'			=> $_SERVER['REMOTE_ADDR'] ?? '',
   	]);
   }
   

