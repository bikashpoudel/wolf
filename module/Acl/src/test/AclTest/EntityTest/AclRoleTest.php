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

use Acl\Entity\AclRole as AclRoleEntity;

/**
 * Description of AclRoleTest
 */
class AclRoleTest extends \PHPUnit_Framework_TestCase
{
	protected $aclRoleEntity;

	public function setUp()
	{
		$this->aclRoleEntity = new AclRoleEntity();
		parent::setUp();
	}

	public function initialState()
	{
		$this->assertNull($this->aclRoleEntity->id);
		$this->assertNull($this->aclRoleEntity->typeId);
		$this->assertNull($this->aclRoleEntity->identifier);
		$this->assertNull($this->aclRoleEntity->name);
		$this->assertNull($this->aclRoleEntity->status);
		$this->assertNull($this->aclRoleEntity->description);
		$this->assertNull($this->aclRoleEntity->dateAdded);
	}

	/**
	 * @dataProvider aclRoleModelArray
	 */
	public function testSetters($aclRoleModelArray)
	{
		$this->aclRoleEntity->setValues($aclRoleModelArray);

		$this->assertEquals($aclRoleModelArray['id'], $this->aclRoleEntity->id);
		$this->assertEquals($aclRoleModelArray['typeId'], $this->aclRoleEntity->typeId);
		$this->assertEquals($aclRoleModelArray['identifier'], $this->aclRoleEntity->identifier);
		$this->assertEquals($aclRoleModelArray['name'], $this->aclRoleEntity->name);
		$this->assertEquals($aclRoleModelArray['status'], $this->aclRoleEntity->status);
		$this->assertEquals($aclRoleModelArray['description'], $this->aclRoleEntity->description);
		$this->assertEquals($aclRoleModelArray['dateAdded'], $this->aclRoleEntity->dateAdded);
	}

	/**
	 * Acl role model array
	 *
	 * @return array
	 */
	public function aclRoleModelArray()
	{
		return [[[
			'id' => 1,
			'typeId' => 1,
			'identifier'  => 'system',
			'name'        => 'System',
			'status'      => 'active',
			'description' => 'test description',
			'dateAdded'   => '2014-12-12 01:01:01'
		]]];
	}

}
