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
 * Navigation Item  Hierarchies Tree Class
 */
class NavigationItemHierarchies implements FactoryInterface
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
		$tree = new Tree('navigation_item_hierarchies', $parentServiceLocator->get('DbAdapter'));
		$tree->setExternalKey('navigation_item_id');
		return $tree;
	}
}