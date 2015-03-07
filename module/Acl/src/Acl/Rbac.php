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
namespace Acl;

use Wolf\NestedSet\NestedSetPluginManagerAwareInterface;
use Wolf\Mapper\MapperPluginManagerAwareInterface;
use Wolf\Mapper\MapperPluginManagerAwareTrait;
use Wolf\NestedSet\NestedSetPluignManagerAwareTrait;
use User\Entity\User as UserEntity;
use Zend\Permissions\Rbac\Rbac as ZendRbac;

/**
 * Acl
 */
class Rbac extends ZendRbac
	implements
		MapperPluginManagerAwareInterface,
		NestedSetPluginManagerAwareInterface
{
	use MapperPluginManagerAwareTrait;
	use NestedSetPluignManagerAwareTrait;

	/**
	 * Rbac Mapper
	 *
	 * @var \Rbac\Mapper\Rbac
	 */
	protected $rbacMapper;

	/**
	 * Run time cache for roles that are granted are stored in this array
	 *
	 * @var array
	 */
	protected $grantedArray = [];

	/**
	 * User specific roles
	 *
	 * Any roles that are directly assigned to the user
	 *
	 * @var array
	 */
	protected $userSpecificRoles = [];

	/**
	 * Available roles
	 *
	 * @var array
	 */
	protected $availableRoles = [];

	/**
	 * Acl role hierarchies table
	 *
	 * @var Wolf\NestedSet\Service\AclRoleHierarchies
	 */
	protected $aclRoleHierarchiesTable;

	/**
	 *
	 * @return RbacMapper
	 */
	public function getRbacMapper()
	{
		if (!$this->rbacMapper) {
			$this->rbacMapper = $this->mapperPluginManager->get('RbacMapper');
		}
		return $this->rbacMapper;
	}

	/**
	 *
	 * @param UserEntity $userEntity
	 * @return array
	 */
	public function getUserSpecificRoles(UserEntity $userEntity)
	{
		$rbacMapper = $this->getRbacMapper();
		if (!$this->userSpecificRoles) {
			$this->userSpecificRoles = $rbacMapper->findAclRolesByUserEntity($userEntity);
		}

		return $this->userSpecificRoles;
	}

	/**
	 *
	 * @param UserEntity $userEntity
	 * @return array
	 */
	public function getAvailableRoles(UserEntity $userEntity)
	{

		$aclRoleHierarchiesTable = $this->getAclRoleHierarchiesTable();
		$userSpecificRoles = $this->getUserSpecificRoles($userEntity);
		if (!$this->availableRoles) {
			foreach ($userSpecificRoles as $role) {
				$node = $aclRoleHierarchiesTable->getNodeByTreeIdAndExternalId($role->typeId, $role->id);
				$branch = $aclRoleHierarchiesTable->fetchBranch($node);
				foreach ($branch->getResultSet() as $row) {
					$this->availableRoles[] = $row['role_id'];
				}
			}
		}
		return $this->availableRoles;
	}

	/**
	 *
	 * @return AclRoleHierarchiesTable
	 */
	public function getAclRoleHierarchiesTable()
	{
		if (!$this->aclRoleHierarchiesTable) {
			$this->aclRoleHierarchiesTable = $this->nestedSetPluginManager->get('AclRoleHierarchies');
		}

		return $this->aclRoleHierarchiesTable;
	}

	/**
	 * Is Granted
	 *
	 * @param \Wolf\Entity\User $userEntity
	 * @param string $permission
	 * @param \Zend\Permissions\Rbac\AssertionInterface $assert
	 * @return boolean
	 */
	public function isAllowed(UserEntity $userEntity, $permission, $assert = null)
	{

		if (array_key_exists($permission, $this->grantedArray)) {
			return $this->grantedArray[$permission];
		}

		$rbacMapper = $this->getRbacMapper();
		$availableRoles = $this->getAvailableRoles($userEntity);

		if ($rbacMapper->isAllowed($permission, $availableRoles)) {
			$this->grantedArray[$permission] = true;
		} else {
			$this->grantedArray[$permission] = false;
		}

		return $this->grantedArray[$permission];
	}
}