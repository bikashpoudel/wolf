<?php

/**
**  ____  _____ _     ____
** /  _ \/  __// \ |\/_   \
** | | \||  \  | | // /   /
** | |_/||  /_ | \// /   /_
** \____/\____\\__/  \____/
**
** @author Bikash Poudel <bikash.poudel.com@gmail.com>
** © 2013-2014 Dev2Digital Ltd.
**/

return [
	'BjyProfiler' => false,
	'Db\Master' => [
		'driver'   => 'pdo',
		'dsn'      => sprintf('mysql:dbname=%s;host=localhost;charset=utf8;buffer_results=1', $_SERVER['DATABASE_SLAVE']),
		'username' => 'webuser',
		'password' => 'w01fw3bus3r',
	],
];