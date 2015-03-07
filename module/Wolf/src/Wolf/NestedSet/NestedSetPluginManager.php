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
namespace Wolf\NestedSet;

use Zend\ServiceManager\AbstractPluginManager;

/**
 * Nested set plugin manager
 */
class NestedSetPluginManager extends AbstractPluginManager
{
	/**
	 * Default set of helpers
	 *
	 * @var array
	 */
	protected $factories = array(
		'aclrolehierarchies'        => 'Wolf\NestedSet\Service\AclRoleHierarchies',
		'aclresourcehierarchies'    => 'Wolf\NestedSet\Service\AclResourceHierarchies',
		'navigationitemhierarchies' => 'Wolf\NestedSet\Service\NavigationItemHierarchies',
	);

	/**
	 * Share by default
	 *
	 * @var boolean
	 */
	protected $shareByDefault = true;

	/**
	 * Validate Plugin
	 *
	 * @param mixed $plugin
	 */
	public function validatePlugin($plugin)
	{
		return ($plugin instanceof Tree\Tree);
	}
}
