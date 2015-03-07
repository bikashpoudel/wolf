<?php

/**
 * *  ____  _____ _     ____
 * * /  _ \/  __// \ |\/_   \
 * * | | \||  \  | | // /   /
 * * | |_/||  /_ | \// /   /_
 * * \____/\____\\__/  \____/
 * *
 * * @author Bikash Poudel <bikash.poudel.com@gmail.com>
 * * © 2013-2014 Dev2Digital Ltd.
 * */
return [
	'view_manager' => [
		'display_exceptions'  => true,
		'not_found_template'  => 'error/404',
        'exception_template'  => 'error/index',
		'template_map'        => [
			'error/404'       => __DIR__ . '/../view/error/404.phtml',
			'error/index'     => __DIR__ . '/../view/error/index.phtml',
		],
		'template_path_stack' => [
            __DIR__ . '/../view',
        ],
		'display_not_found_reason' => true,
	],
	//the default set of listeners that will be listened to when the application boostraps
	'listeners' => [],

	//service config
	'service_manager' => [
		'abstract_factories' => [],
		'factories'          => [],
		'invokables'         => [],
		'intializers'        => [],
	],

	//view helpers
	'view_helpers' => [
		'factories'          => [],
		'invokables'         => [],
		'intializers'        => [],
	],
];