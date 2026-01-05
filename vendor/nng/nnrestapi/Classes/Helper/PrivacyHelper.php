<?php

namespace Nng\Nnrestapi\Helper;

use TYPO3\CMS\Core\Utility\IpAnonymizationUtility;

/**
 * ## PrivacyHelper.
 * 
 * Collection of methods to handle privacy-compliance
 * 
 * ```
 * use \Nng\Nnrestapi\Helper\PrivacyHelper;
 * ```
 * 
 */
class PrivacyHelper
{
	/**
	 * Anonymization modes
	 * 
	 * @var string
	 */
	const MODE_IP_ANONYMIZED 	= 'anonymized';		// anonymized IP
	const MODE_IP_HASHED 		= 'hashed';			// hashed IP
	const MODE_IP_FULL 			= 'ip';				// full IP
	const MODE_IP_NONE 			= 'none';			// no IP

	/**
	 * Sensitive keys to redact from logs
	 * 
	 * @var array
	 */
	const SENSITIVE_KEYS = [
		'password', 'passwd', 'pass',
		'pwd', 'secret', 'token',
		'access_token', 'accesstoken',
		'refresh_token', 'refreshtoken',
		'bearer', 'authorization',
		'auth', 'apikey', 'api_key',
		'api-key', 'private_key',
		'privatekey', 'client_secret',
		'clientsecret',
	];

	/**
	 * Anonymize IP address
	 * ```
	 * PrivacyHelper::anonymizeIp($ip, PrivacyHelper::MODE_IP_ANONYMIZED);
	 * ```
	 * @param  string  $ip
	 * @return string
	 */
	public static function anonymizeIp($ip, $mode = self::MODE_IP_ANONYMIZED)
	{
		switch ($mode) {
			case self::MODE_IP_NONE:
				return '';
			case self::MODE_IP_HASHED:
				$salt = $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey'] ?? \nn\t3::Encrypt()->getSaltingKey();
				return substr(hash_hmac('sha256', $ip . md5(date('Ymd')), $salt), 0, 16);
			case self::MODE_IP_FULL:
				return $ip;
			case self::MODE_IP_ANONYMIZED:
				return IpAnonymizationUtility::anonymizeIp($ip);
			default:
				return $ip;
		}
	}

	/**
	 * Remove sensitive data from payload or query params:
	 * - password
	 * - token
	 * - apikey
	 * ```
	 * // returns `'{"username":"david","password":"[REMOVED]"}`
	 * $example = PrivacyHelper::removeSensitiveData('{"username":"david","password":"dontlogme"}');
	 * 
	 * // returns `username=david&password=[REMOVED]`
	 * $example = PrivacyHelper::removeSensitiveData('username=david&password=dontlogme');
	 * ```
	 * @param string|array $data
	 * @return string
	 */
	public static function removeSensitiveData($data) 
	{
		if (!$data) {
			return '';
		}
		
		if (is_array($data)) {
			$data = json_encode($data);
		}
		
		$keys = implode('|', array_map(function($key) {
			return preg_quote($key, '/');
		}, self::SENSITIVE_KEYS));

		// JSON format: "key": "value" or 'key': 'value'
		$data = preg_replace('/(["\'](' . $keys . ')["\']\s*:\s*)(["\'])[^"\']*\3/i', '$1$3[REMOVED]$3', $data);
		// Query string format: key=value
		$data = preg_replace('/(' . $keys . ')=[^&]*/i', '$1=[REMOVED]', $data);

		return $data;
	}
}