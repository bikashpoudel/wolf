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
namespace Wolf\Mapper\Service;

use Wolf\Mapper\MapperPluginManagerAwareInterface;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * Description of MapperPluginManagerInitializer
 */
class MapperPluginManagerInitializer
	implements InitializerInterface {

	/**
	 * Initialize
	 *
	 * @param MapperPluginManagerAwareInterface $instance
	 * @param ServiceLocatorInterface $serviceLocator
	 */
	public function initialize($instance, ServiceLocatorInterface $serviceLocator)
	{
		if ($instance instanceof MapperPluginManagerAwareInterface) {
			if ($serviceLocator->has('MapperPluginManager')) {
				$instance->setMapperPluginManager($serviceLocator->get('MapperPluginManager'));
			} else if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
				$psl = $serviceLocator->getServiceLocator();
				if ($psl->has('MapperPluginManager')) {
					$instance->setMapperPluginManager($psl->get('MapperPluginManager'));
				}
			}
		}
	}

}
