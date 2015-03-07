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
namespace Wolf\Entity;

use Wolf\Entity\EntityPluginManager;

/**
 * Description of EntityPluginManagerAwareInterface
 */
interface EntityPluginManagerAwareInterface {

	/**
	 *
	 * @param EntityPluginManager $entityPluginManager
	 * @return mixed
	 */
	public function setEntityPluginManager(EntityPluginManager $entityPluginManager);

	/**
	 *
	 * @return EntityPluginManager
	 */
	public function getEntityPluginManager();

}
