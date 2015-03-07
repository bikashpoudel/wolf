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

use Acl\Entity\AclRoleType as AclRoleTypeEntity;

/**
 * Description of AclRoleTypeTest
 */
class AclRoleTypeTest
	extends \PHPUnit_Framework_TestCase
{

	/**
	 *
	 * @var AclRoleTypeEntity
	 */
	protected $aclRoleTypeEntity;

	public function setUp()
	{
		$this->aclRoleTypeEntity = new AclRoleTypeEntity();
		parent::setUp();
	}

	/**
	 *
	 */
	public function testAclRoleTypeEntityIsNull()
	{
		$this->assertNull($this->aclRoleTypeEntity->id);
		$this->assertNull($this->aclRoleTypeEntity->identifier);
		$this->assertNull($this->aclRoleTypeEntity->name);
		$this->assertNull($this->aclRoleTypeEntity->status);
		$this->assertNull($this->aclRoleTypeEntity->dateAdded);
	}

	/**
	 *
	 * @depends testAclRoleTypeEntityIsNull
	 * @dataProvider getAclRoleTypeEntityModelArray
	 * @param type $aclRoleTypeEntityModelArray
	 */
	public function testSetters($aclRoleTypeEntityModelArray)
	{
		$this->aclRoleTypeEntity->setValues($aclRoleTypeEntityModelArray);
		$this->assertEquals($aclRoleTypeEntityModelArray['id'], $this->aclRoleTypeEntity->id);
		$this->assertEquals($aclRoleTypeEntityModelArray['identifier'], $this->aclRoleTypeEntity->identifier);
		$this->assertEquals($aclRoleTypeEntityModelArray['name'], $this->aclRoleTypeEntity->name);
		$this->assertEquals($aclRoleTypeEntityModelArray['status'], $this->aclRoleTypeEntity->status);
		$this->assertEquals($aclRoleTypeEntityModelArray['dateAdded'], $this->aclRoleTypeEntity->dateAdded);
	}

	/**
	 * Get acl role type entity model array
	 *
	 * @return array
	 */
	public function getAclRoleTypeEntityModelArray()
	{
		return [[[
			'id'         => 1,
			'identifier' => 'system',
			'name'       => 'system',
			'status'     => 'active',
			'dateAdded'  => '2014-12-12 01:01:01',
		]]];
	}

}
