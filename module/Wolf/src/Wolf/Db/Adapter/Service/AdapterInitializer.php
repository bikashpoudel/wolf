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
namespace Wolf\Db\Adapter\Service;

use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of AdapterInitializer
 */
class AdapterInitializer
	implements InitializerInterface {

	/**
	 * Initialize
	 *
	 * @param AdapterAwareInterface $instance
	 * @param ServiceLocatorInterface $serviceLocator
	 */
	public function initialize($instance, ServiceLocatorInterface $serviceLocator)
	{
		if ($instance instanceof AdapterAwareInterface) {
			if ($serviceLocator->has('DbAdapter')) {
				$instance->setDbAdapter($serviceLocator->get('DbAdapter'));
			} else if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
				$pluginServiceLocator = $serviceLocator->getServiceLocator();
				if ($pluginServiceLocator->has('DbAdapter')) {
					$instance->setDbAdapter($pluginServiceLocator->get('DbAdapter'));
				}
			}
		}
	}

}
