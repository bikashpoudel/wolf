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
namespace Wolf\NestedSet\Service;

use Wolf\NestedSet\NestedSetPluginManagerAwareInterface;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Nested set plugin manager initializer
 */
class NestedSetPluginManagerInitializer implements InitializerInterface {

	/**
	 * Intitalize
	 *
	 * @param mixed $instance
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
	 */
	public function initialize($instance, ServiceLocatorInterface $serviceLocator)
	{
		if ($instance instanceof NestedSetPluginManagerAwareInterface) {
			if ($serviceLocator->has('NestedSetPluginManager')) {
				$instance->setNestedSetPluginManager($serviceLocator->get('NestedSetPluginManager'));
			} else {
				$parentServiceLocator = $serviceLocator->getServiceLocator();
				if ($parentServiceLocator->has('NestedSetPluginManager')) {
					$instance->setNestedSetPluginManager($parentServiceLocator->get('NestedSetPluginManager'));
				}
			}
		}
	}
}

