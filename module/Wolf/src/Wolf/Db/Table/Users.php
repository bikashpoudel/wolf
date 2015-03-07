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
 * Description of Users
 */
class Users {

	/**
	 * Table name
	 *
	 * @var array
	 */
	public static $tableName = "users";

	/**
	 * Columns Map Array
	 *
	 * @var array
	 */
	public static $columnsMap = [
		//generated via: Cli\Controller\TableGeneratorController on 25/12/2014 13:36:16
		'id' => 'id',
		'username' => 'username',
		'password' => 'password',
		'passwordSalt' => 'password_salt',
		'email' => 'email',
		'prefix' => 'prefix',
		'firstName' => 'first_name',
		'middleName' => 'middle_name',
		'lastName' => 'last_name',
		'gender' => 'gender',
		'dateOfBirth' => 'date_of_birth',
		'company' => 'company',
		'locale' => 'locale',
		'timezone' => 'timezone',
		'status' => 'status',
		'profilePicture' => 'profile_picture',
		'emailMailingList' => 'email_mailing_list',
		'mobileMailingList' => 'mobile_mailing_list',
		'termsAccepted' => 'terms_accepted',
		'failedLoginCount' => 'failed_login_count',
		'dateAdded' => 'date_added',
		'dateModified' => 'date_modified',

	];

}
