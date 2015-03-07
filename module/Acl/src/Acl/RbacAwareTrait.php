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
namespace Acl;

use Rbac;

/**
 * Description of RbacAwareTrait
 */
trait RbacAwareTrait {

	/**
	 * Rbac
	 *
	 * @var Rbac
	 */
	protected $rbac;

	/**
	 * Set Rbac
	 *
	 * @param Rbac $rbac
	 * @return \Wolf\Rbac\RbacAwareTrait
	 */
	public function setRbac(Rbac $rbac)
	{
		$this->rbac = $rbac;
		return $this;
	}

	/**
	 * Get rbac
	 *
	 * @return Rbac
	 */
	public function getRbac()
	{
		return $this->rbac;
	}

}
