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
use Wolf\NestedSet\NestedSetPluginManager;

/**
 * Nested set plugin manager aware interface
 */
interface NestedSetPluginManagerAwareInterface
{
	/**
	 * Tree plugin manager
	 *
	 * @param \Wolf\NestedSet\NestedSetPluginManager $nestedSetPluginManager
	 * @return \Admin\Controller\IndexController
	 */
	public function setNestedSetPluginManager(NestedSetPluginManager $nestedSetPluginManager);

	/**
	 * Get tree plugin manager
	 *
	 * @return \Wolf\NestedSet\NestedSetPluginManager
	 */
	public  function getNestedSetPluginManager();
}
