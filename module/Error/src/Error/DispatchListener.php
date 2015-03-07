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
namespace Error;

use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

/**
 * Description of DispatchListener
 */
class DispatchListener
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
		$this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH , [$this, 'handleErrors'], 1);
		$this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR , [$this, 'handleErrors'], 1);
		$this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER_ERROR, [$this, 'handleErrors'], 1);
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
        }
	}

	/**
	 * Init error logging
	 *
	 * @todo use error handler class
	 * @return void
	 */
	public function handleErrors(MvcEvent $e)
	{
		if (!$e->getRequest() instanceof Request) {
			return;
		}

		$responseCode   = $e->getResponse()->getStatusCode();
		switch ($responseCode) {
			case Response::STATUS_CODE_404:
				$e->getViewModel()->setTemplate('error/404');
				break;
		}

		//if there is no error return
		if (!$e->isError()) {
			return;
		}

		//http://samsonasik.wordpress.com/2014/01/01/zend-framework-2-programmatically-handle-404-page
		$error = $e->getParam('error');
		$e->getViewModel()->setVariable('display_exceptions', true);

		switch ($error) {
			case Application::ERROR_EXCEPTION:
				//log the exception?
				$e->getViewModel()->setVariable('exception', $e->getParam('exception'));
				$e->getViewModel()->setTemplate('error/index');
				break;
			case Application::ERROR_ROUTER_NO_MATCH:
				$e->getViewModel()->setTemplate('error/404');
				break;
			case Application::ERROR_CONTROLLER_CANNOT_DISPATCH:
				$e->getViewModel()->setVariables($e->getResult()->getVariables());
				$e->getViewModel()->setTemplate('error/404');
				break;
			case Application::ERROR_CONTROLLER_INVALID:
				$e->getViewModel()->setTemplate('error/404');
				break;
			case Application::ERROR_CONTROLLER_NOT_FOUND:
				$e->getViewModel()->setTemplate('error/404');
				break;
		}

		$e->getViewModel()->setVariable('reason', $error);
		$response = $e->getResponse();
		$response->setStatusCode($e->getResponse()->getStatusCode());
		$response->sendHeaders();
	}
}
