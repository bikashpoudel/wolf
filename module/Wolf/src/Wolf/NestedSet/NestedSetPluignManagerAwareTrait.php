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
namespace Wolf\NestedSet;

use Wolf\NestedSet\NestedSetPluginManager;

/**
 * Description of NestedSetPluignManagerAwareTrait
 */
trait NestedSetPluignManagerAwareTrait {

	/**
	 * Nested set plugin manager
	 *
	 * @var NestedSetPluginManager
	 */
	protected $nestedSetPluginManager;

	/**
	 * Set nested set pluign manager
	 *
	 * @param NestedSetPluginManager $nestedSetPluginManager
	 * @return type
	 */
	public function setNestedSetPluginManager(NestedSetPluginManager $nestedSetPluginManager)
	{
		$this->nestedSetPluginManager = $nestedSetPluginManager;
		return $this;
	}

	/**
	 * Get nested set plugin manager
	 *
	 * @return NestedSetPluginManager
	 */
	public function getNestedSetPluginManager()
	{
		return $this->nestedSetPluginManager;
	}
}
