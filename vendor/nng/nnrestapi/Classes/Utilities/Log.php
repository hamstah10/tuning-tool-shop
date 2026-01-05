<?php 

namespace Nng\Nnrestapi\Utilities;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Context\Context;

use \Nng\Nnrestapi\Helper\PrivacyHelper;

/**
 * Helper for logging requests
 * 
 */
class Log extends \Nng\Nnhelpers\Singleton 
{
	/**
	 * Logging modes
	 * 
	 * @var string
	 */
	const MODE_ALL 				= 'all';			// all requests except if disabled by annotation
	const MODE_EXPLICIT 		= 'explicit';		// only explicitly enabled endpoints
	const MODE_FORCE 			= 'force';			// all requests, even if not explicitly enabled

	const MODE_ERROR_ALL 		= 'all';			// all errors
	const MODE_ERROR_EXCEPTIONS = 'exception';		// only exceptions
	const MODE_ERROR_API 		= 'api';			// only errors called by \nn\rest::ApiError()

	/**
	 * Tablename that stores the security-data
	 * 
	 * @var string
	 */
	const TABLENAME = 'nnrestapi_log';

	/**
	 * Timestamp of current request
	 * to measure response duration
	 * 
	 * @var int
	 */
	var $tstamp = 0;

	/**
	 * Cache for current request
	 * 
	 * @var \Nng\Nnrestapi\Mvc\Request
	 */
	var $request = null;

	/**
	 * Cache for current response
	 * 
	 * @var \Nng\Nnrestapi\Mvc\Response
	 */
	var $response = null;

	/**
	 * Constructor
	 * 
	 * @param \Nng\Nnrestapi\Mvc\Request $request
	 * @return void
	 */
	public function __construct( &$request = null ) 
	{
		$this->request = $request;
		$this->tstamp = microtime(true);
		return $this;
	}

	/**
	 * Set the response
	 * 
	 * @param \Nng\Nnrestapi\Mvc\Response $response
	 * @return self
	 */
	public function setResponse( &$response ) 
	{
		$this->response = $response;
		return $this;
	}

	/**
	 * Insert an entry in the log-table
	 * ```
	 * \nn\rest::Log()->request([
	 * 	'type'		=> 'GET',
	 * 	'path'		=> '/api/v1/endpoint',
	 * 	'status'	=> 404,
	 * 	'code'		=> 404001,
	 * 	'payload'	=> [],
	 * ]);
	 * ```
	 * @param array $params
	 * @return array
	 */
	public function request( $params = [] ) 
	{
		$endpoint = $this->request->getEndpoint();
		$options = \nn\rest::Settings()->getLoggingOptions();
		
		// get http status code (e.g. `404`) 
		$statusCode = (int) ($params['status'] ?? $this->response->getStatus());

		// ... and customStatusCode from `\nn\rest::ApiError()` (e.g. `404001`)
		$customStatusCode = (int)$this->response->getCustomStatusCode();

		// is the response an error?
		$isError = ($statusCode > 299);
		$isException = ($statusCode >= 500) || ($params['isException'] ?? false);

		// should we log this?
		$loggingEnabled = ($options['enabled'] || $options['tempEnabled'] || $isError);
		if (!$loggingEnabled) {
			return;
		}

		$mode = $options['mode'];
		$errorLoggingMode = $options['errorLoggingMode'];

		// not an error? then check if logging is enabled
		if (!$isError) {
			// if `@Api\Log()` annotation is NOT present: use settings from extension manager
			$logEnabledByAnnotation = $endpoint['log'] ?? ($mode == self::MODE_ALL || $mode == self::MODE_FORCE);

			// logging disabled by `@Api\Log(false)` annotation - and not forced?
			if (($mode != self::MODE_FORCE) && !$logEnabledByAnnotation) {
				return;
			}
			// only log explicitly enabled endpoints - and `@Api\Log()` not present?
			if (($mode == self::MODE_EXPLICIT) && !$logEnabledByAnnotation) {
				return;
			}
		}
		
		// check error level, but only if temporary logging is disabled
		if ($isError && !$options['tempEnabled']) {
			// error logging disabled inextension manager?
			if (!$options['errorLoggingEnabled']) {
				return;
			}
			// error logging mode is set to `api` and not an exception?
			if ($errorLoggingMode == self::MODE_ERROR_API && $isException) {
				return;
			}
			// error logging mode is set to `exception` and an exception?
			if ($errorLoggingMode == self::MODE_ERROR_EXCEPTIONS && !$isException) {
				return;
			}
		}
		
		$request = $this->request;
		$mvcRequest = $request->getMvcRequest();

		$queryParams = $mvcRequest->getQueryParams();
		unset($queryParams['params']);

		$remoteAddr = $this->request->getRemoteAddr();
		$hashedIp = PrivacyHelper::anonymizeIp($remoteAddr, $options['logIpMode']);

		$context = GeneralUtility::makeInstance(Context::class);
		$userAspect = $context->getAspect('frontend.user');
		$feUserUid = $userAspect ? $userAspect->get('id') : 0;

		$payload = $options['logPayload'] ? $request->getRawBody() : '';
		$payload = PrivacyHelper::removeSensitiveData($payload);

		$queryParams = PrivacyHelper::removeSensitiveData($mvcRequest->getServerParams()['QUERY_STRING'] ?? '');

		$row = array_merge($params, [
			'iphash' 		=> $hashedIp,
			'method' 		=> $request->getMethod(),
			'target' 		=> "{$endpoint['class']}::{$endpoint['method']}",
			'feuser' 		=> $feUserUid,
			'datetime' 		=> date('Y-m-d H:i:s'),
			'duration' 		=> floor((microtime(true) - $this->tstamp) * 1000),
			'uri' 			=> $mvcRequest->getUri()->getPath(),
			'queryparams' 	=> $queryParams,
			'payload' 		=> $payload,
			'status' 		=> $statusCode,
			'code' 			=> $customStatusCode,
			'error' 		=> $params['error'] ?? $this->response->getMessage(),
		]);

		try {
			\nn\t3::Db()->insert( self::TABLENAME, $row);
		} catch( \Throwable $e ) {}
	}
	
	/**
	 * Insert an error entry in the log-table
	 * ```
	 * \nn\rest::Log()->error($exception);
	 * ```
	 * @param $exception
	 * @param $response
	 * @return void
	 */
	public function error($exception = null, $response = null) 
	{
		$this->request([
			'isException'	=> true,
			'status' 		=> $response?->getStatus() ?? 500,
			'error' 		=> $exception->getMessage() . ' Line:' . $exception->getLine() . ' File:' . $exception->getFile(),
		]);
	}

	/**
	 * Dump the current logs
	 * ```
	 * $criteria = [
	 *  // ... any field from the log-table
	 *  'sort' => 'DESC',
	 *  'sortBy' => 'datetime',
	 *  'limit' => 100,
	 *  'offset' => 0,
	 *  'errors' => 1, // only show errors
	 *  'keyword' => 'xxx', // search in all fields
	 * ];
	 * \nn\rest::Log()->dump($criteria);
	 * ```
	 * @param array $criteria
	 * @return array
	 */
	public function dump( $criteria = [] ) 
	{
		$keyword = $criteria['keyword'] ?? '';

		$constraints = [];
		$searchConstraints = [];

		$queryBuilder = \nn\t3::Db()->getQueryBuilder( self::TABLENAME );
		$queryBuilder
			->select('*')
			->from(self::TABLENAME)
			->orderBy($criteria['sortBy'] ?? 'datetime', $criteria['sort'] ?? 'DESC');
	
		// add `LIKE` constraints for text fields
		$fields = \nn\t3::Db()->getColumns(self::TABLENAME);
		foreach ($fields as $k=>$conf) {
			$val = $criteria[$k] ?? false ?: $keyword;
			if (!$val) {
				continue;
			} 
			$searchConstraints[] = $queryBuilder->expr()->like($k, $queryBuilder->createNamedParameter('%' . $val . '%'));
		}

		// only show errors?
		if ($criteria['errors'] ?? false) {
			$constraints[] = $queryBuilder->expr()->gt('status', 299);
		}

		if ($searchConstraints) {
			$constraints[] = $queryBuilder->expr()->or(...$searchConstraints);
		}

		if ($constraints) {
			$queryBuilder->andWhere(
				$queryBuilder->expr()->and(...$constraints),
			);
		}

		$total = $queryBuilder->executeQuery()->rowCount();

		$queryBuilder
			->setMaxResults($criteria['limit'] ?? 100)
			->setFirstResult($criteria['offset'] ?? 0);

		$results = $queryBuilder->executeQuery()->fetchAllAssociative();
		
		return [
			'total'		=> $total,
			'results'	=> $results,
		];
	}

	/**
	 * Remove expired log entries from database.
	 * 
     * ```
	 * // clear logs older than defined in extension manager
	 * \nn\rest::Log()->clear();
	 * 
	 * // clear ALL logs
	 * \nn\rest::Log()->clear( true );
	 * 
	 * // clear logs older than 2022-01-01 00:00:00
	 * \nn\rest::Log()->clear( '2022-01-01 00:00:00' );
	 * 
	 * // clear logs older than 24 hours
	 * \nn\rest::Log()->clear( time() - 86400 );
	 * ```
	 * @param int|string $tstamp
	 * @return void
	 */
	public function clear( $tstamp = null ) 
	{		
		$options = \nn\rest::Settings()->getLoggingOptions();

		if ($tstamp === true) {
			$queryBuilder = \nn\t3::DB()->truncate( self::TABLENAME );
			return;
		}

		if ($tstamp === null) {
			$lifetime = $options['lifetime'] ?? 5;
			$tstamp = time() - ($lifetime * 60 * 60 * 24);
		}

		if (is_numeric($tstamp)) {
			$tstamp = date('Y-m-d H:i:s', $tstamp);
		}

		// save logs before deleting them?
		if ($options['logfiles'] ?? false) {
			$this->saveToLogfile($tstamp);
		}
		
		$queryBuilder = \nn\t3::DB()->getQueryBuilder( self::TABLENAME );
		$queryBuilder->delete( self::TABLENAME );
		$queryBuilder->andWhere(
			$queryBuilder->expr()->lt('datetime', $queryBuilder->createNamedParameter($tstamp))
		);

		$deleted = 0;
		try {
			$deleted = $queryBuilder->executeStatement();
		} catch( \Throwable $e ) {
		} catch ( \Exception $e ) {}

		return [
			'deleted' => $deleted
		];
	}

	/**
	 * Dump logs from database for a given date range
	 * ```
	 * // dump all logs up to now
	 * \nn\rest::Log()->dumpFromToDate();
	 * 
	 * // dump all logs older than given date
	 * \nn\rest::Log()->dumpFromToDate('2025-01-01 00:00:00');
	 * \nn\rest::Log()->dumpFromToDate(1735689600);
	 * 
	 * // dump logs between two dates
	 * \nn\rest::Log()->dumpFromToDate('2025-01-01 00:00:00', '2025-12-31 23:59:59');
	 * \nn\rest::Log()->dumpFromToDate(1735689600, 1767225599);
	 * ```
	 * @param int|string|null $endDate - logs older than this date will be returned (default: now)
	 * @param int|string|null $startDate - optional start date for date range
	 * @return array
	 */
	public function dumpFromToDate( $endDate = null, $startDate = null ) 
	{
		// default endDate to now
		if (!$endDate) {
			$endDate = time();
		}

		// convert to datetime strings
		$endDate = is_numeric($endDate) ? date('Y-m-d H:i:s', $endDate) : $endDate;
		$startDate = $startDate ? (is_numeric($startDate) ? date('Y-m-d H:i:s', $startDate) : $startDate) : '0000-00-00 00:00:00';

		$queryBuilder = \nn\t3::DB()->getQueryBuilder( self::TABLENAME );
		$queryBuilder->select('*')
			->from( self::TABLENAME )
			->andWhere(
				$queryBuilder->expr()->gte('datetime', $queryBuilder->createNamedParameter($startDate)),
				$queryBuilder->expr()->lte('datetime', $queryBuilder->createNamedParameter($endDate))
			)
			->orderBy('datetime', 'ASC');

		return $queryBuilder->executeQuery()->fetchAllAssociative();
	}

	/**
	 * Save/export logs to logfile
	 * 
	 * See `dumpFromToDate()` for parameters.
	 * 
	 * @param int|string|null $endDate - logs older than this date will be saved (default: now)
	 * @param int|string|null $startDate - optional start date for date range
	 * @return int
	 */
	public function saveToLogfile( $endDate = null, $startDate = null ) 
	{
		$logs = $this->dumpFromToDate($endDate, $startDate);

		if (!$logs) {
			return 0;
		}

		// find oldest and newest entry and use as filename (YYYYMMDDHHMMSS-YYYYMMDDHHMMSS.log)
		$oldest = date('YmdHis', strtotime(reset($logs)['datetime']));
		$newest = date('YmdHis', strtotime(end($logs)['datetime']));

		$absVarPath = \nn\t3::Environment()->getVarPath() . '/log/nnrestapi/';
		$filename = $absVarPath . $oldest . '-' . $newest . '.log';

		\nn\t3::File()->mkdir($absVarPath);

		// write to file
		$handle = fopen($filename, 'w');
		fputcsv($handle, array_keys($logs[0]), "\t");
		foreach ($logs as $log) {
			fputcsv($handle, $log, "\t");
		}
		fclose($handle);

		return count($logs);
	}

	/**
	 * Enable temporary logging
	 * ```
	 * // enable temporary logging for 5 minutes
	 * \nn\rest::Log()->enableTemporaryLogging(5);
	 * 
	 * // disable temporary logging
	 * \nn\rest::Log()->enableTemporaryLogging(false);
	 * ```
	 * @param bool $enabled
	 * @return void
	 */
	public function enableTemporaryLogging( $enabled = true ) 
	{
		if ($enabled === false) {
			\nn\t3::Cache()->setMemCache('nnrestapi_logger', ['enabled' => false]);
			return;
		}
		
		$options = \nn\rest::Settings()->getLoggingOptions();
		$expires = ($enabled === true ? $options['loggingTempDuration'] : $enabled) * 60;

		\nn\t3::Cache()->setMemCache('nnrestapi_logger', ['enabled' => true], $expires);
	}
	
}