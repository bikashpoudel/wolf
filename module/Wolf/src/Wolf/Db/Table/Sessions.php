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
 * Description of Sessions
 */
class Sessions {

	/**
	 * Table name
	 *
	 * @var array
	 */
	public static $tableName = "sessions";

	/**
	 * Columns Map Array
	 *
	 * @var array
	 */
	public static $columnsMap = [
		//generated via: Cli\Controller\TableGeneratorController on 12/12/2014 17:47:44
		'id' => 'id',
		'name' => 'name',
		'modified' => 'modified',
		'lifetime' => 'lifetime',
		'data' => 'data',
		'dateModified' => 'date_modified',

	];

}
