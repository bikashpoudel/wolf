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
 * Description of AclRole
 */
class AclRole
	extends AbstractEntity {

	/**
	 *
	 * @var int
	 */
	public $id;

	/**
	 *
	 * @var int
	 */
	public $typeId;

	/**
	 *
	 * @var identifier
	 */
	public $identifier;

	/**
	 *
	 * @var name
	 */
	public $name;

	/**
	 *
	 * @var status
	 */
	public $status;

	/**
	 *
	 * @var description
	 */
	public $description;

	/**
	 *
	 * @var dateAdded
	 */
	public $dateAdded;

	/**
	 *
	 * @param int $id
	 * @return \Acl\Entity\AclRole
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * Set type id
	 *
	 * @param int $typeId
	 * @return \Acl\Entity\AclRole
	 */
	public function setTypeId($typeId)
	{
		$this->typeId = $typeId;
		return $this;
	}

	/**
	 *
	 * @param string $identifier
	 * @return \Acl\Entity\AclRole
	 */
	public function setIdentifier($identifier)
	{
		$this->identifier = $identifier;
		return $this;
	}

	/**
	 *
	 * @param string $name
	 * @return \Acl\Entity\AclRole
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 *
	 * @param string $status
	 * @return \Acl\Entity\AclRole
	 */
	public function setStatus($status)
	{
		$this->status = $status;
		return $this;
	}

	/**
	 *
	 * @param string $description
	 * @return \Acl\Entity\AclRole
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}

	/**
	 *
	 * @param string $dateAdded
	 * @return \Acl\Entity\AclRole
	 */
	public function setDateAdded($dateAdded)
	{
		$this->dateAdded = $dateAdded;
		return $this;
	}

}
