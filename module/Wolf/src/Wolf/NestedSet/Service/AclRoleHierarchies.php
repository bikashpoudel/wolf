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
namespace Wolf\NestedSet\Service;

use Zend\ServiceManager\FactoryInterface;
use Wolf\NestedSet\Tree\Tree;

/**
 * Acl Resource Hierarchies Tree Class
 */
class AclRoleHierarchies implements FactoryInterface
{
	/**
	 * Create service
	 *
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
	 * @return \Wolf\NestedSet\Tree\Tree
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
	{
		$parentServiceLocator = $serviceLocator->getServiceLocator();
		$tree = new Tree('acl_role_hierarchies', $parentServiceLocator->get('DbAdapter'));
		$tree->setExternalKey('role_id');
		return $tree;
	}
}