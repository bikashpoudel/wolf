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
namespace Cli;

use Zend\Console\Getopt;
/**
 * Description of Module
 */
class Module {

	/**
	 * Get config
	 *
	 * @return array
	 */
    public function getConfig()
    {
		//set the superglobal server variable
		$_SERVER['DATABASE_SLAVE'] = 'wolf';
		return include __DIR__ . '/config/module.config.php';
    }

	/**
	 * Get autoloader config
	 *
	 * @return array
	 */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
