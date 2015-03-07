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
namespace Acl\Mapper;

use User\Entity\User as UserEntity;
use Wolf\Mapper\AbstractMapper;
use Zend\Db\Sql\Predicate;
use Zend\Db\Sql\Select;
use Wolf\Db\Table\UserAclRoles;
use Wolf\Db\Table\AclRoles;

/**
 * Description of RbacMapper
 */
class Rbac extends AbstractMapper
{

	/**
	 * Find acl roles by user entity
	 *
	 * @param UserEntity $userEntity
	 */
	public function findAclRolesByUserEntity(UserEntity $userEntity)
	{
		$sql = $this->sql;
		$sqlObject = $sql->select()
			->from([
				'UART' => UserAclRoles::$tableName,
			])
			->join(
				['ART' => AclRoles::$tableName],
				'UART.role_id = ART.id',
				AclRoles::$columnsMap,
				Select::JOIN_INNER
			)
			->where([
				'UART.user_id' => $userEntity->id,
			])
			->columns([]);

		$stmt = $sql->prepareStatementForSqlObject($sqlObject);
		$resultSet = $stmt->execute();

		$aclRoles = [];
		foreach ($resultSet as $row) {
			$aclRoleEntity = $this->entityPluginManager->get('AclRoleEntity');
			$aclRoleEntity->setValues($row);

			$aclRoles[$aclRoleEntity->id] = $aclRoleEntity;
		}

		return $aclRoles;
	}

	/**
	 * Are roles allowed for this permissions
	 *
	 * @param type $permission
	 * @param array $roles
	 * @return boolean
	 */
	public function isAllowed($permission, array $roles = [])
	{
		$sql = $this->sql;
		$sqlObject = $sql->select()
			->from(
					['AclRolePermissionsTable' => 'acl_role_permissions']
			)
			->join(
				['AclPermissionsTable' => 'acl_permissions'],
				'AclRolePermissionsTable.permission_id = AclPermissionsTable.id',
				[],
				Select::JOIN_INNER
			)
			->columns([
				'RoleId' => 'role_id',
				'Permissionid' => 'permission_id',
			])
			->where([
				new Predicate\In('AclRolePermissionsTable.role_id', $roles),
				'AclPermissionsTable.identifier' => $permission,
			]);

		$statement = $sql->prepareStatementForSqlObject($sqlObject);
		$resultSet = $statement->execute();

		if ($resultSet->current()) {
			return true;
		}
		return false;
	}
}
