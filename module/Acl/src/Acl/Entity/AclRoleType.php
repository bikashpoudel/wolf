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
namespace Acl\Entity;

use Wolf\Entity\AbstractEntity;

/**
 * Description of AclRoleType
 */
class AclRoleType
	extends AbstractEntity
{
	/**
	 *
	 * @var int
	 */
	public $id;

	/**
	 *
	 * @var string
	 */
	public $identifier;

	/**
	 *
	 * @var string
	 */
	public $name;

	/**
	 *
	 * @var string
	 */
	public $dateAdded;

	/**
	 *
	 * @var string
	 */
	public $status;

	/**
	 *
	 * @param int $id
	 * @return \Acl\Entity\AclRoleType
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 *
	 * @param string $identifier
	 * @return \Acl\Entity\AclRoleType
	 */
	public function setIdentifier($identifier)
	{
		$this->identifier = $identifier;
		return $this;
	}

	/**
	 *
	 * @param string $name
	 * @return \Acl\Entity\AclRoleType
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 *
	 * @param string $dateAdded
	 * @return \Acl\Entity\AclRoleType
	 */
	public function setDateAdded($dateAdded)
	{
		$this->dateAdded = $dateAdded;
		return $this;
	}

	/**
	 *
	 * @param string $status
	 * @return \Acl\Entity\AclRoleType
	 */
	public function setStatus($status)
	{
		$this->status = $status;
		return $this;
	}
}
