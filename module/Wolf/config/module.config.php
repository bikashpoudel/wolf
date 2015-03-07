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
	//the default set of listeners that will be listened to when the application boostraps
	'listeners' => [
		'CliBootstrapListener', //disables few listeners in cli mode
		'ErrorHandlerDispatchListener', //error handler
		'ModuleRouteListener',  //module route listener
		'RbacRouteListener', //acl route listener
		'SessionBootstrapListener', //session listener
	],

	//service config
	'service_manager' => [
		'abstract_factories' => [],
		'factories'          => [
			'Zend\Db\Adapter\Adapter' => 'Wolf\Db\Adapter\Service\AdapterFactory',
		],
		'invokables'         => [
			'EntityPluginManager'    => 'Wolf\Entity\EntityPluginManager',
			'MapperPluginManager'    => 'Wolf\Mapper\MapperPluginManager',
			'NestedSetPluginManager' => 'Wolf\NestedSet\NestedSetPluginManager',
			'SessionStorage'         => 'Wolf\Session\Storage',

			//register default listeners here
			'CliBootstrapListener'         => 'Cli\BootstrapListener',
			'ErrorHandlerDispatchListener' => 'Error\DispatchListener',
			'ModuleRouteListener'          => 'Zend\Mvc\ModuleRouteListener',
			'RbacRouteListener'            => 'Acl\RouteListener',
			'SessionBootstrapListener'     => 'Wolf\Session\BootstrapListener',
		],
		'initializers'        => [
			'DbAdapterInitializer'              => 'Wolf\Db\Adapter\Service\AdapterInitializer',
			'MapperPluginManagerInitializer'    => 'Wolf\Mapper\Service\MapperPluginManagerInitializer',
			'NestedSetPluginManagerInitializer' => 'Wolf\NestedSet\Service\NestedSetPluginManagerInitializer',
		],
		'aliases' =>[
			'DbAdapter' => 'Zend\Db\Adapter\Adapter',
		]
	],

	'controllers' => [
		'initializers' => [
			'MapperPluginManagerInitializer' => 'Wolf\Mapper\Service\MapperPluginManagerInitializer',
		],
	],

	//view helpers
	'view_helpers' => [
		'factories'          => [],
		'invokables'         => [],
		'intializers'        => [],
	],

	'translator' => [
		'locale' => 'en_GB',
		'translation_file_patterns' => [
			[
				'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
			],
		],
	],

	'view_manager' => [
		'doctype'               => 'HTML5',
		'template_map'          => [
			'layout/layout'     => __DIR__ . '/../view/layout/layout.phtml',
			'layout/navigation' => __DIR__ . '/../view/layout/navigation.phtml',
		],
		'template_path_stack' => [
            __DIR__ . '/../view',
        ],
		'strategies' => [
           'ViewJsonStrategy',
        ],
	],

	'router' => [
		'routes' => [
			'wolfadmin' => [
				'type'    => 'Zend\Mvc\Router\Http\Segment',
				'options' => [
					'route'    => '/wolfadmin[/]',
					'defaults' => [
						'__NAMESPACE__' => 'WolfAdmin\Controller',
						'controller'    => 'Index',
						'action'        => 'index',
					],
				],
			],
			'wolfadminoptions' => [
				'type' => 'segment',
				'options' => [
					'route' => '/wolfadmin[/:controller][/:action]',
					'defaults' => [
						'__NAMESPACE__' => 'WolfAdmin\Controller',
						'controller'    => 'Index',
						'action'        => 'list',
					],
				],
				'may_terminate' => true,
				'child_routes' => [
					'default' => [
						'type' => 'Segment',
						'options' => [
							'route' => '/[:controller[/:action]]',
							'constraints' => [
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
							],
							'defaults' => [
							],
						],
					],
				],
			],
		],
	],
];