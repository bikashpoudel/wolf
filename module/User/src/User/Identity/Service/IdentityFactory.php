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
namespace User\Identity\Service;

use User\Identity\Identity;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of IdentityFactory
 */
class IdentityFactory
	implements FactoryInterface {

	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return Identity
	 */
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$authenticationService = new AuthenticationService();
		$identity = new Identity();
		$identity->setAuthenticationService($authenticationService);

		return $identity;
	}

}
