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
 * Description of Navigation
 */
class Navigation {

	/**
	 * Table name
	 *
	 * @var array
	 */
	public static $tableName = "navigation";

	/**
	 * Columns Map Array
	 *
	 * @var array
	 */
	public static $columnsMap = [
		//generated via: Cli\Controller\TableGeneratorController on 12/12/2014 17:47:44
		'id' => 'id',
		'name' => 'name',
		'identifier' => 'identifier',
		'filePath' => 'file_path',
		'permissionId' => 'permission_id',
		'status' => 'status',
		'description' => 'description',
		'dateAdded' => 'date_added',
		'dateModified' => 'date_modified',

	];

}
