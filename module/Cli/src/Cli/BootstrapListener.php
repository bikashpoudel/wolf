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
namespace Cli;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;

/**
 * Description of BootstrapListener
 */
class BootstrapListener
	implements ListenerAggregateInterface {

	/**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = [];

	/**
	 * Attach
	 *
	 * @param EventManagerInterface $events
	 */
	public function attach(EventManagerInterface $events)
	{
		$this->listeners[] = $events->attach(MvcEvent::EVENT_BOOTSTRAP, [$this, 'removeListeners'], -1);
	}

	/**
	 * Detach events
	 *
	 * @param EventManagerInterface $events
	 */
	public function detach(EventManagerInterface $events)
	{
		foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
	}

	/**
	 * Remove listeners
	 *
	 * @param MvcEvent $e
	 */
	public function removeListeners(MvcEvent $e)
	{
		//if its a cli script remove listeners that deal with view
		if (php_sapi_name() == 'cli') {
			$serviceManager = $e->getApplication()->getServiceManager();
			$eventManager   = $e->getApplication()->getEventManager();

			$eventManager->detachAggregate($serviceManager->get('AclRouteListener'));
			$eventManager->detachAggregate($serviceManager->get('ErrorHandlerDispatchListener'));
			$eventManager->detachAggregate($serviceManager->get('LayoutRenderListener'));
		}
	}

}
