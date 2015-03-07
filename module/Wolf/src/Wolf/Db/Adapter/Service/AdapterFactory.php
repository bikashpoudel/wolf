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

use BjyProfiler\Db\Adapter\ProfilingAdapter;
use BjyProfiler\Db\Profiler\Profiler as BjyDbProfiler;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * Description of AdapterFactory
 */
class AdapterFactory implements FactoryInterface
{

	/**
	 * Create Service
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return DbAdapter
	 */
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$config = [];
		if ($serviceLocator->has('config')) {
			$config = $serviceLocator->get('config');

		} else if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
			$pluginServiceLocator = $serviceLocator->getServiceLocator();
			if ($pluginServiceLocator->has('config')) {
				$config = $pluginServiceLocator->get('config');
			}
		}

		return $this->createDbAdapter($config);
	}

	/**
	 * Create Db Adapter
	 *
	 * @param array $config
	 * @return \Zend\Db\Adapter\Adapter
	 */
	protected function createDbAdapter(array $config = [])
	{
		if (isset($config['Db\Master']) && isset($config['BjyProfiler'])) {

			$adapter = new ProfilingAdapter($config['Db\Master']);
			$adapter->setProfiler(new BjyDbProfiler);
			$adapter->injectProfilingStatementPrototype();
			return $adapter;

		} else if (isset($config['Db\Master'])) {
			
			return new DbAdapter($config['Db\Master']);

		}
	}

}
