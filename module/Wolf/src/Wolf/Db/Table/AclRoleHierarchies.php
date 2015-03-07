<?php

/**
 * *  ____  _____ _     ____
 * * /  _ \/  __// \ |\/_   \
 * * | | \||  \  | | // /   /
 * * | |_/||  /_ | \// /   /_
 * * \____/\____\\__/  \____/
 * *
 * * @author Cli Script <cli.script@dev2digital.com>
 * * © 2013-2014 Dev2Digital Ltd.
 * */
namespace Wolf\Db\Table;

/**
 * Description of AclRoleHierarchies
 */
class AclRoleHierarchies {

	/**
	 * Table name
	 *
	 * @var array
	 */
	public static $tableName = "acl_role_hierarchies";

	/**
	 * Columns Map Array
	 *
	 * @var array
	 */
	public static $columnsMap = [
		//generated via: Cli\Controller\TableGeneratorController on 12/12/2014 17:47:43
		'id' => 'id',
		'treeId' => 'tree_id',
		'left' => 'left',
		'right' => 'right',
		'parentId' => 'parent_id',
		'roleId' => 'role_id',
		'dateModified' => 'date_modified',

	];

}
