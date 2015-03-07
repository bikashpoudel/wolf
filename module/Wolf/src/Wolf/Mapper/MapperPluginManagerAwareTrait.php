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
namespace Wolf\Mapper;

use Wolf\Mapper\MapperPluginManager;

/**
 * Description of MapperPluginManagerTrait
 */
trait MapperPluginManagerAwareTrait {

	/**
	 * Mapper plugin manager
	 *
	 * @var MapperPluginManager
	 */
	protected $mapperPluginManager;

	/**
	 * Set mapper plugin manager
	 *
	 * @param MapperPluginManager $mapperPluginManager
	 * @return type
	 */
	public function setMapperPluginManager(MapperPluginManager $mapperPluginManager)
	{
		$this->mapperPluginManager = $mapperPluginManager;
		return $this;
	}

	/**
	 * Get mapper plugin manager
	 *
	 * @return MapperPluginManager
	 */
	public function getMapperPluginManager()
	{
		return $this->mapperPluginManager;
	}

}
