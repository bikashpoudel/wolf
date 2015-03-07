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
namespace Acl\Service;

use Wolf\Rbac\RbacAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\InitializerInterface;

/**
 * Description of RbacInitializer
 */
class RbacInitializer implements InitializerInterface {

	/**
	 * Initialize
	 *
	 * @param RbacAwareInterface $instance
	 * @param ServiceLocatorInterface $serviceLocator
	 */
	public function initialize($instance, ServiceLocatorInterface $serviceLocator)
	{
		if ($instance instanceof RbacAwareInterface) {
			if ($serviceLocator->has('RbacService')) {
				$instance->setRbac($serviceLocator->get('RbacService'));
			} else if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
				$pluginServiceLocator = $serviceLocator->getServiceLocator();
				if ($pluginServiceLocator->get('RbacService')) {
					$instance->setRbac($pluginServiceLocator->get('RbacService'));
				}
			}
		}
	}
}
