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
 * Description of MapperPluginManagerAware
 */
interface MapperPluginManagerAwareInterface {

	/**
	 * Set mapper plugin manager
	 *
	 * @param MapperPluginManager $mapperPluginManager
	 */
	public function setMapperPluginManager(MapperPluginManager $mapperPluginManager);

	/**
	 * Get mapper plugin manager
	 */
	public function getMapperPluginManager();

}
