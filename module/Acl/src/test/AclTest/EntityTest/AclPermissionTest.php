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
namespace AclTest\EntityTest;

use Acl\Entity\AclPermission as AclPermissionEntity;
use PHPUnit_Framework_TestCase;

/**
 * Description of AclPermissionTest
 */
class AclPermissionTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Acl Permission Entity
	 *
	 * @var AclPermissionEntity
	 */
	protected $aclPermissionEntity;

	public function setUp()
	{
		$this->aclPermissionEntity = new AclPermissionEntity();
		parent::setUp();
	}

	/**
	 * Test acl permission entity is null
	 */
	public function testAclPermissionEntityIsNull()
	{
		$this->assertNull($this->aclPermissionEntity->id);
		$this->assertNull($this->aclPermissionEntity->identifier);
		$this->assertNull($this->aclPermissionEntity->name);
		$this->assertNull($this->aclPermissionEntity->description);
		$this->assertNull($this->aclPermissionEntity->dateAdded);
	}

	/**
	 * Test Setters
	 *
	 * @depends testAclPermissionEntityIsNull
	 * @dataProvider getAclPermissionModelArray
	 */
	public function testSetters($aclPermissionModelArray)
	{
		$this->aclPermissionEntity->setValues($aclPermissionModelArray);

		$this->assertEquals($aclPermissionModelArray['id'], $this->aclPermissionEntity->id, 'Setting id property did not work');
		$this->assertEquals($aclPermissionModelArray['identifier'], $this->aclPermissionEntity->identifier, 'Setting identifier property did not work');
		$this->assertEquals($aclPermissionModelArray['name'], $this->aclPermissionEntity->name, 'Setting name property did not work');
		$this->assertEquals($aclPermissionModelArray['description'], $this->aclPermissionEntity->description, 'Setting description property did not work');
		$this->assertEquals($aclPermissionModelArray['dateAdded'], $this->aclPermissionEntity->dateAdded, 'Setting dateAdded property did not work');
	}

	/**
	 * Get acl permission model array
	 *
	 * @return array
	 */
	public function getAclPermissionModelArray()
	{
		return [
			[
				[
					'id'          => 1,
					'identifier'  => 'wolfadmin:auth:signin',
					'name'        => 'wolfadmin:auth:signin',
					'description' => 'Wolfadmin auth sign in',
					'dateAdded'   => '2012-12-12 12:01:01',
				]
			]
		];
	}

}
