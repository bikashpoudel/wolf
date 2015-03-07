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
namespace Wolf\Mapper;

use Wolf\Entity\EntityPluginManagerAwareTrait;
use Wolf\Db\Adapter\AdapterAwareTrait;
use Wolf\Entity\EntityPluginManagerAwareInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterAwareInterface;

/**
 * Description of AbstractMapper
 */
class AbstractMapper
	implements AdapterAwareInterface, EntityPluginManagerAwareInterface
{

	use AdapterAwareTrait;
	use EntityPluginManagerAwareTrait;

	/**
	 * Sql
	 *
	 * @var Sql
	 */
	protected $sql;

	/**
	 * Set Sql
	 *
	 * @param Sql $sql
	 */
	public function setSql($sql)
	{
		$this->sql = $sql;
	}
}