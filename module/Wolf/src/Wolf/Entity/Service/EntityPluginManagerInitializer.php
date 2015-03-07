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
namespace Wolf\Entity\Service;

use Wolf\Entity\EntityPluginManagerAwareInterface;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * Description of EntityPluginManagerInitializer
 */
class EntityPluginManagerInitializer implements InitializerInterface
{

	/**
	 * Initialize
	 *
	 * @param EntityPluginManagerAwareInterface $instance
	 * @param ServiceLocatorInterface $serviceLocator
	 */
	public function initialize($instance, ServiceLocatorInterface $serviceLocator)
	{

		if ($instance instanceof EntityPluginManagerAwareInterface) {
			if ($serviceLocator->has('EntityPluginManager')) {
				$instance->setEntityPluginManager($serviceLocator->get('EntityPluginManager'));
			} else if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
				$psl = $serviceLocator->getServiceLocator();
				if ($psl->has('EntityPluginManager')) {
					$instance->setEntityPluginManager($psl->get('EntityPluginManager'));
				}
			}
		}

	}
}
