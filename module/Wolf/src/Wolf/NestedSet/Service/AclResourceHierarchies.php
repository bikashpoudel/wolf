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

use Wolf\NestedSet\Tree\Tree;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Acl Resource Hierarchies Tree Class
 */
class AclResourceHierarchies implements FactoryInterface
{
	/**
	 * Create service
	 *
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
	 * @return \Wolf\NestedSet\Tree\Tree
	 */
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$parentServiceLocator = $serviceLocator->getServiceLocator();
		$tree = new Tree('acl_resource_hierarchies', $parentServiceLocator->get('DbAdapter'));
		$tree->setExternalKey('resource_id');
		return $tree;
	}
}