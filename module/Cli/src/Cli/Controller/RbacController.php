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
namespace Cli\Controller;

use Wolf\Entity\AclPermission as AclPermissionEntity;
use Wolf\Mvc\Controller\AbstractController;
use Wolf\Mvc\Exception;
use Zend\Dom\Document as ZendDomDocument;
use Zend\Dom\Document\Query as ZendDomDocumentQuery;
use Zend\Validator\ValidatorPluginManager;


/**
 * Index controller
 */
class RbacController
	extends AbstractController
{
	/**
	 * Import
	 */
	public function importAction()
	{
		$rolesXmlPath = getcwd() . '/data/rbac/rbac.xml';
		$rolesXml = file_get_contents($rolesXmlPath);
		if (!file_exists($rolesXmlPath)) {
			throw Exception\InvalidArgumentException(
				'Rbac.xml: File not found in path : `%s`',
				$rolesXmlPath
			);
		}
		$aclMapper = $this->mapperPluginManager->get('AclMapper');
		$zendDomDocument = new ZendDomDocument($rolesXml);
		$zendDomQuery = new ZendDomDocumentQuery($zendDomDocument);

		$rolesList = $zendDomQuery->execute('//rbac/roles/identifier', $zendDomDocument);
		$permissonList = $zendDomQuery->execute('//rbac/permissions/permission', $zendDomDocument);

		$adapter = $aclMapper->getDbAdapter();
		try {
			$adapter->getDriver()->getConnection()->beginTransaction();
			$permissionArray = [];
			//iterate through the permission list and grab identifier, name and description
			foreach ($permissonList as $permission) {
				$identifier = $permission->getElementsByTagName('identifier')->item(0)->nodeValue;
				$name = $permission->getElementsByTagName('name')->item(0)->nodeValue;
				$description = $name;
				if ($permission->getElementsByTagName('description')->length == 1) {
					$description = $permission->getElementsByTagName('description')->item(0)->nodeValue;
				}

				//check if the identifier already exists in the datbase.
				$aclPermissionEntity = $aclMapper->findAclPermissionByIdentifier($identifier);
				if ($aclPermissionEntity instanceof AclPermissionEntity) {
					$permissionArray[$identifier] = $aclPermissionEntity;
					print sprintf('NOT CHANGED: Acl permission: %s already exists in the db.', $aclPermissionEntity->identifier) . PHP_EOL;
				} else {
					//insert the permission
					//insert this acl permission and then put it in the permissions array
					$aclPermissionEntity = new AclPermissionEntity();
					$aclPermissionEntity->setValues([
						'identifier'  => $identifier,
						'name'        => $name,
						'description' => $description,
					]);
					$aclMapper->save($aclPermissionEntity, $adapter);

					print sprintf('SUCCES: Acl permission: %s was inserted', $aclPermissionEntity->identifier) . PHP_EOL;

					$permissionArray[$identifier] = $aclPermissionEntity;
				}
			}

			foreach ($rolesList as $role) {
				$roleIdentifier = $role->nodeValue;
				$aclRoleEntity = $aclMapper->findAclRoleByIdentifier($roleIdentifier);

				//if acl role mdoel is not found; continue; put it in the error array
				if (!$aclRoleEntity) {
					//@todo write to error array
					print sprintf('ERROR: Acl role by identifier: %s is not found', $roleIdentifier) . PHP_EOL;
					continue;
				}

				//now check to see if there is //rbac/roel-permissions/$roleIdentifier/allow/identifier node
				$allowedPermissionsList = $zendDomQuery->execute(
					sprintf('//rbac/role-permissions/%s/allow/identifier', $roleIdentifier),
					$zendDomDocument
				);

				foreach ($allowedPermissionsList as $allowedPermissionNode) {
					$permissionIdentifier = $allowedPermissionNode->nodeValue;


					if (isset($permissionArray[$permissionIdentifier])) {
						$aclPermissionEntity = $permissionArray[$permissionIdentifier];
					} else {
						print sprintf('QUERY: Acl permission: %s is not listed on //rbac/permissions/permission. Looking up database instead.', $permissionIdentifier) . PHP_EOL;
						//get the permission model from the db
						$aclPermissionEntity = $aclMapper->findAclPermissionByIdentifier($permissionIdentifier);
					}

					//if permission model does not exist, put it in the error array; and continue;
					if (!$aclPermissionEntity) {
						//@todo write to error array
						print sprintf('ERROR: Acl permission by identifier: %s is not found', $permissionIdentifier) . PHP_EOL;
						continue;
					}

					if (!$aclMapper->isAllowed($aclPermissionEntity->identifier, [$aclRoleEntity->id])) {
						$aclMapper->allow($aclRoleEntity, $aclPermissionEntity, $adapter);
						print sprintf('SUCCESS: Acl Role: %s is now allowed for permission: %s', $aclRoleEntity->identifier, $aclPermissionEntity->identifier) . PHP_EOL;
					} else {
						print sprintf('NOT CHANGED: Acl Role: %s is already allowed for permission: %s', $aclRoleEntity->identifier, $aclPermissionEntity->identifier) . PHP_EOL;
					}
				}

			}

			$adapter->getDriver()->getConnection()->commit();
		} catch (\Exception $ex) {
			print 'An error occured during the execution. Rolling back all the changes.' . PHP_EOL;
			$adapter->getDriver()->getConnection()->rollback();
			throw $ex;
		}
	}
}