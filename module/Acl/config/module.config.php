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
		'template_path_stack' => [
            __DIR__ . '/../view',
        ],
	],
	//the default set of listeners that will be listened to when the application boostraps
	'listeners' => [],

	//service config
	'service_manager' => [
		'abstract_factories' => [],
		'factories'          => [],
		'invokables'         => [
			'RbacService' => 'Acl\Rbac',
		],
		'intializers'        => [
			'RbacInitializer' => 'Acl\Service\RbacInitializer',
		],
	],

	//view helpers
	'view_helpers' => [
		'factories'          => [],
		'invokables'         => [],
		'intializers'        => [],
	],
];