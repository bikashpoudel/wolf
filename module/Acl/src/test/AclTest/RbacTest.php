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
namespace AclTest;

use Acl\Rbac;
use User\Entity\User as UserEntity;
use Wolf\Test\Bootstrap;

/**
 * Description of RbacTest
 */
class RbacTest extends \PHPUnit_Framework_TestCase
{
	/**
	 *
	 * @var MapperPluginManager
	 */
	protected $mapperPluginManager;

	/**
	 *
	 * @var NestedSetPluginManager
	 */
	protected $nestedSetPluginManager;

	/**
	 *
	 * @var Rbac
	 */
	protected $rbacService;

	/**
	 *
	 * @var Identity
	 */
	protected $identity;

	/**
	 * Setup
	 */
	public function setUp()
	{
		$serviceManager = Bootstrap::getServiceManager();
		$this->mapperPluginManager = $serviceManager->get('MapperPluginManager');
		$this->nestedSetPluginManager = $serviceManager->get('NestedSetPluginManager');

		$identityService = $serviceManager->get('IdentityService');
		$this->identity = $identityService->getIdentity();

		parent::setUp();
	}

	/**
	 * Test set mapper plugin manager sets mapper plugin correctly
	 */
	public function testSetMapperPluginManagerSetsMapperPluginCorrectly()
	{
		$rbacService = new Rbac();
		$rbacService->setMapperPluginManager($this->mapperPluginManager);

		$this->assertInstanceOf('Wolf\Mapper\MapperPluginManager',
			$rbacService->getMapperPluginManager(),
			'Mapper plugin manager setter is not working properly'
		);
	}

	/**
	 * Test set nested set plugin manager sets nested set plugin manager correctly
	 */
	public function testSetNestedSetPluginManagerSetsNestedSetPluginManagerCorrectly()
	{
		$rbacService = new Rbac();
		$rbacService->setNestedSetPluginManager($this->nestedSetPluginManager);

		$this->assertInstanceOf('Wolf\NestedSet\NestedSetPluginManager',
			$rbacService->getNestedSetPluginManager(),
			'Nested set pluing manager setter is not working properly'
		);
	}

	public function testIsAllowed()
	{
		$rbacService = new Rbac();
		
		$rbacService->setMapperPluginManager($this->mapperPluginManager);
		$rbacService->setNestedSetPluginManager($this->nestedSetPluginManager);
		$this->assertTrue($rbacService->isAllowed($this->identity, 'wolfadmin:auth:signin'));
	}
}
