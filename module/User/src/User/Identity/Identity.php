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
namespace User\Identity;

use User\Entity\User as UserEntity;
use Wolf\Mapper\MapperPluginManagerAwareInterface;
use Wolf\Mapper\MapperPluginManagerAwareTrait;
use Zend\Authentication\AuthenticationService;

/**
 * Description of Identity
 */
class Identity
	implements
	MapperPluginManagerAwareInterface {

	use MapperPluginManagerAwareTrait;

	/**
	 * Identity
	 *
	 * @var User\Entity\User
	 */
	protected $identity;

	/**
	 * Authentication Service
	 *
	 * @var AuthenticationService
	 */
	protected $authenticationService;

	/**
	 * Set AuthenticationService
	 *
	 * @param AuthenticationService $authenticationService
	 * @return \User\Identity\Identity
	 */
	public function setAuthenticationService(AuthenticationService $authenticationService)
	{
		$this->authenticationService = $authenticationService;
		return $this;
	}

	/**
	 * Get identity
	 *
	 * @return UserEntity
	 */
	public function getIdentity()
	{
		$usersMapper = $this->mapperPluginManager->get('UsersMapper');

		$authenticationService = $this->authenticationService;
		if ($authenticationService->hasIdentity()) {
			$userModel = $usersMapper->findUserByEmailAndStatus($authenticationService->getIdentity(), UserEntity::STATUS_ACTIVE);
		} else {
			$userModel = $usersMapper->findUserByUsername(UserEntity::ACCOUNT_GUEST);
		}

		return $userModel;
	}
}
