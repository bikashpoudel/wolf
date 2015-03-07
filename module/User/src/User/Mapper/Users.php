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
namespace User\Mapper;

use Wolf\Mapper\AbstractMapper;
use Wolf\Db\Table\Users as UsersTable;
use User\Entity\User as UserEntity;
use Zend\Db\Sql\Select;

/**
 * Description of Users
 */
class Users
	extends AbstractMapper
{

	/**
	 * Get user select
	 *
	 * @return Select
	 */
	protected function getUserSelect()
	{
		$sqlObject = $this->sql->select()
			->from([
				'Users' => 'users'
			])
			->columns(
				UsersTable::$columnsMap
			);

		return $sqlObject;
	}
	/**
	 * Get user by email and status
	 *
	 * @param \User\Mapper\type $email
	 * @param \User\Mapper\type $status
	 * @return UserEntity
	 */
	public function findUserByEmailAndStatus($email, $status)
	{
		$sql = $this->sql;
		$sqlObject = $this->getUserSelect();
		$sqlObject->where([
			'email'  => $email,
			'status' => $status,
		]);

		$statement = $sql->prepareStatementForSqlObject($sqlObject);
		$resultSet = $statement->execute();

		if ($row = $resultSet->current()) {
			$userEntity = $this->entityPluginManager->get('UserEntity');
			$userEntity->setValues($row);
			return $userEntity;
		}

		return null;
	}

	/**
	 * Find user by username
	 *
	 * @param type $username
	 * @return UserEntity
	 */
	public function findUserByUsername($username)
	{
		$sql = $this->sql;
		$sqlObject = $this->getUserSelect();
		$sqlObject->where([
			'username' => $username,
		]);

		$statement = $sql->prepareStatementForSqlObject($sqlObject);
		$resultSet = $statement->execute();

		if ($row = $resultSet->current()) {
			$userEntity = $this->entityPluginManager->get('UserEntity');
			$userEntity->setValues($row);
			return $userEntity;
		}

		return null;
	}
}
