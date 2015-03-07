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
namespace Wolf\Session;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
/**
 * Description of RouteListener
 */
class BootstrapListener
	implements ListenerAggregateInterface{

	/**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = [];

	/**
     * Attach to an event manager
     *
     * @param  EventManagerInterface $events
     * @param  int $priority
     */
	public function attach(EventManagerInterface $events)
	{
		//write to the sessions table as the application booststraps
		$this->listeners[] = $events->attach(MvcEvent::EVENT_BOOTSTRAP, [$this, 'initApplicationSession']);
	}

	/**
	 * Detach
	 *
	 * @param EventManagerInterface $events
	 */
	public function detach(EventManagerInterface $events)
	{
		foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        };
	}

	/**
	 * Initialize the applications session
	 *
	 * @param MvcEvent $e
	 */
	public function initApplicationSession(MvcEvent $e)
	{
		$serviceManager = $e->getApplication()->getServiceManager();
		$storage = $serviceManager->get('SessionStorage');
        $storage->init();
	}
}
