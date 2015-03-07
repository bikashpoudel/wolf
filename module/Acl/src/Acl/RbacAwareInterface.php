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
namespace Acl;

/**
 * Interface Rbacaware
 */
interface RbacAwareInterface
{
	/**
	 * Set Rbac
	 *
	 * @param Rbac $rbac
	 */
	public function setRbac(Rbac $rbac);

	/**
	 * Get Rbac
	 */
	public function getRbac();
}
