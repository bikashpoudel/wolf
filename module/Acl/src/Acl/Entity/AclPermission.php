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

class AclPermission
	extends AbstractEntity {

	/**
	 * Id
	 *
	 * @var int
	 */
	public $id;

	/**
	 * Identifier
	 *
	 * @var string
	 */
	public $identifier;

	/**
	 * Name
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Description
	 *
	 * @var string
	 */
	public $description;

	/**
	 * Date Added
	 *
	 * @var string
	 */
	public $dateAdded;

	/**
	 *
	 * @param int $id
	 * @return \Acl\Entity\AclPermission
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 *
	 * @param string $identifier
	 * @return \Acl\Entity\AclPermission
	 */
	public function setIdentifier($identifier)
	{
		$this->identifier = $identifier;
		return $this;
	}

	/**
	 *
	 * @param string $name
	 * @return \Acl\Entity\AclPermission
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 *
	 * @param string $description
	 * @return \Acl\Entity\AclPermission
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}

	/**
	 *
	 * @param string $dateAdded
	 * @return \Acl\Entity\AclPermission
	 */
	public function setDateAdded($dateAdded)
	{
		$this->dateAdded = $dateAdded;
		return $this;
	}
}
