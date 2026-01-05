<?php

namespace Nng\Nnrestapi\Annotations;

/**
 * # Api\Log()
 * 
 * Disable / force enable logging of requests to this endpoint.
 * Request will be saved in the database table `nnrestapi_log` if logging is enabled.
 *  
 * ```
 * | -------------------------------------------------------|-------------------------------------------------------|
 * | annotation							    				| description						                    |
 * | -------------------------------------------------------|-------------------------------------------------------|
 * | @Api\Log(false)				    				    | Logging will be disabled for this endpoint		    |
 * | @Api\Log(true)				    						| Logging will be explicitly enabled for this endpoint. |
 * | @Api\Log()												| Same as `true`                                        |
 * | -------------------------------------------------------|-------------------------------------------------------|
 * ```
 * 
 * @Annotation
 */
class Log
{
	public $value;

	public function __construct( $value ) {
		$this->value = $value['value'] ?? true;
	}

	public function mergeDataForEndpoint( &$data ) {
		$data['log'] = $this->value;
	}
}