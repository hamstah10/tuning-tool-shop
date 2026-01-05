<?php 

// @todo: TYPO3 v13 will probably remove these Middlewares
// check warnings in `EXT:typo3/cms-frontend/Configuration/RequestMiddlewares.php`

$pageResolverCallpoint = [
	'after' 	=> 'typo3/cms-frontend/prepare-tsfe-rendering',
	'before' 	=> 'typo3/cms-frontend/shortcut-and-mountpoint-redirect',
];

return [
	'frontend' => [

		// handle preflight (OPTION) requests
		'nnrestapi/corspreflightheader' => [
            'target' => \Nng\Nnrestapi\Middleware\CorsPreflightHeader::class,
            'before' => [
				'typo3/cms-frontend/timetracker',
			],
        ],

		// add CORS header to response (positioned very early so it processes responses LAST)
		'nnrestapi/corsheader' => [
            'target' => \Nng\Nnrestapi\Middleware\CorsHeader::class,
            'before' => [
                'typo3/cms-frontend/timetracker',
            ],
        ],

		// Parses the `PUT` and `DELETE` requests (usually not supported by PHP)
		'nnrestapi/requestparser' => [
			'target' => \Nng\Nnrestapi\Middleware\RequestParser::class,
			'before' => [
				'typo3/cms-frontend/timetracker',
			],
		],

		// Bypass base-redirect-resolver for API requests (prevents redirect to /en/api/... on multilingual sites)
		'nnrestapi/baseredirectbypass' => [
			'target' => \Nng\Nnrestapi\Middleware\BaseRedirectBypass::class,
			'after' => [
				'typo3/cms-frontend/site',
			],
			'before' => [
				'typo3/cms-frontend/base-redirect-resolver',
			],
		],

		// Resolve the request, forward to ApiController
		'nnrestapi/cachehashfix' => [
			'target' => \Nng\Nnrestapi\Middleware\CacheHashFixer::class,
			'after' => [
				'typo3/cms-frontend/site',
			],
			'before' => [
				'typo3/cms-frontend/page-resolver',
			],
		],
		
		// Resolve the request, forward to ApiController
		'nnrestapi/resolver' => [
			'target' => \Nng\Nnrestapi\Middleware\PageResolver::class,
			'after' => [
				$pageResolverCallpoint['after'],
			],
			'before' => [
				$pageResolverCallpoint['before'],
			],
		]
	]
];