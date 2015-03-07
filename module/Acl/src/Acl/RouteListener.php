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
namespace Acl;

use User\Entity\User as UserEntity;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;
use Zend\Http\PhpEnvironment\Response;

/**
 * Description of RouteListener
 */
class RouteListener implements ListenerAggregateInterface {

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
		$this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'isRouteAccessible'], -1);
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
	 * Is Allowed to view the current route
	 *
	 * @param MvcEvent $e
	 */
	public function isRouteAccessible(MvcEvent $e)
	{
		$serviceManager  = $e->getApplication()->getServiceManager();
		$rbac            = $serviceManager->get('RbacService');
		$identityService = $serviceManager->get('IdentityService');
		$identity        = $identityService->getIdentity();

		//if the usermodel is not registerd, redirect!
		$routeMatch = $e->getRouteMatch();
		if (!$identity instanceof UserEntity) {
			//@todo log the error message
			$routeMatch->setParam('action', 'not-found');
		}
		$controllerName     = $routeMatch->getParam('__CONTROLLER__');
		$actionName         = $routeMatch->getParam('action');
		$namespaceMatch = preg_split('/\\\\/', $routeMatch->getParam('__NAMESPACE__'));
		$permissionKey  = strtolower($namespaceMatch[0] . ':' . $controllerName . ':' . $actionName);

		if (!$rbac->isAllowed($identity, $permissionKey)) {
			if ($identity->username == UserEntity::ACCOUNT_GUEST) {
				$e->getResponse()->setStatusCode(Response::STATUS_CODE_403);
                $routeMatch->setParam('controller', 'WolfAdmin\Controller\Auth');
                $routeMatch->setParam('action', 'signin');
			} else {
				$e->getResponse()->setStatusCode(Response::STATUS_CODE_404);
				$routeMatch->setParam('action', 'not-found');
			}
		}

		$e->getViewModel()->setVariable('identity', $identity);
	}

}
