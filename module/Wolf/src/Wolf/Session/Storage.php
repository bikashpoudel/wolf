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
namespace Wolf\Session;

use Wolf\Session\SaveHandler\EncodedDbTableGateway;
use Zend\Session\SaveHandler\DbTableGatewayOptions;
use Zend\Session\SessionManager;
use Zend\Session\Container;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Session\Config\SessionConfig;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\AdapterAwareTrait;

/**
 * Description of Storage
 */
class Storage
	implements AdapterAwareInterface {

	/**
	 * Adapter aware trait
	 */
	use AdapterAwareTrait;

	/**
	 * Set session storage
	 */
	public function init()
    {
        $gwOpts = new DbTableGatewayOptions();
		$gwOpts->setIdColumn('id');
        $gwOpts->setDataColumn('data');
		$gwOpts->setNameColumn('name');
        $gwOpts->setLifetimeColumn('lifetime');
        $gwOpts->setModifiedColumn('modified');

		$sessionsTable = new TableGateway('sessions', $this->adapter);
		$saveHandler = new EncodedDbTableGateway($sessionsTable, $gwOpts);
        $sessionManager = new SessionManager();
        $sessionConfig = new SessionConfig();
		$saveHandler
            ->open($sessionConfig
			->getOption('save_path'), 'wolf');

        $sessionManager->setSaveHandler($saveHandler);
        Container::setDefaultManager($sessionManager);
        $sessionManager->start();
    }
}
