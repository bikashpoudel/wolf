<?php
/**
**    ____  _____ _     ____
**   /  _ \/  __// \ |\/_   \
**   | | \||  \  | | // /   /
**   | |_/||  /_ | \// /   /_
**   \____/\____\\__/  \____/
**
** @author Bikash Poudel<bikash.poudel.com@gmail.com>
** © Dev2 Ltd. 2013-2014
**/
return [
	'controllers' => [
		'invokables' => [
			'Cli\Controller\Rbac'           => 'Cli\Controller\RbacController',
			'Cli\Controller\TableGenerator' => 'Cli\Controller\TableGeneratorController',
		],
		'factories' => [

		],
	],
	'console' => [
		'router' => [
			'routes' => [
				'rbacPermissions' => [
					'options' => [
						'route' => 'import-permissions [--verbose|-v] [--database|-d] <database>',
						'defaults' => [
							'controller' => 'Cli\Controller\Rbac',
							'action'     => 'import',
						]
					]
				],
				'tableGenerator' => [
					'options' => [
						'route'    => 'table-generator [--verbose|-v] [--database|-d] <database>',
						'defaults' => [
							'controller' => 'Cli\Controller\TableGenerator',
							'action'     => 'generate-table'
						]
					],
				],
			],
		],
	],
];