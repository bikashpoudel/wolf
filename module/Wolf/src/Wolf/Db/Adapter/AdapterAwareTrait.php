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
namespace Wolf\Db\Adapter;

use Zend\Db\Adapter\Adapter;

/**
 * Description of AdapterAwareTrait
 */
trait AdapterAwareTrait {

	/**
	 * Adapter
	 *
	 * @var Adapter
	 */
	protected $adapter;

	/**
	 * Set DbAdapter
	 *
	 * @param Adapter $adapter
	 * @return \Wolf\Db\Adapter\AdapterAwareTrait
	 */
	public function setDbAdapter(Adapter $adapter)
	{
		$this->adapter = $adapter;
		return $this;
	}

	/**
	 * Get Db Adapter
	 *
	 * @return Adapter
	 */
	public function getDbAdapter()
	{
		return $this->adapter;
	}
}
