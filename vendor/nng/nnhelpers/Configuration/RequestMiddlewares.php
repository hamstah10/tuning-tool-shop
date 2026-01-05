<?php 

return [
	'frontend' => [
		// Enrich the response
		'nnhelpers/resolver' => [
			'target' => \Nng\Nnhelpers\Middleware\ModifyResponse::class,
			'before' => [
				'typo3/cms-frontend/site',
			],
		],
		// save the global request for usage BEFORE pid was resolve
		'nnhelpers/requestparser' => [
			'target' => \Nng\Nnhelpers\Middleware\RequestParser::class,
			'before' => [
				'typo3/cms-frontend/timetracker',
			],
		],
		// update the global request for usage AFTER pid was resolved
		'nnhelpers/requestparser-after-pid' => [
			'target' => \Nng\Nnhelpers\Middleware\RequestParser::class,
			'after' => [
				'typo3/cms-frontend/page-resolver',
			],
			'before' => [
				'typo3/cms-frontend/preview-simulator',
			],
		],
	],
];