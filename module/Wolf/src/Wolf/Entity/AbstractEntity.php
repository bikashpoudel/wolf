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
namespace Wolf\Entity;

/**
 * Description of AbstractEntity
 */
class AbstractEntity
{

	/**
	 * Set values
	 * 
	 * @param array $values
	 */
	public function setValues(array $values = [])
	{
		foreach ($values as $key => $value) {
			$methodName = 'set' . ucfirst($key);
			if (method_exists($this, $methodName)) {
				$this->{$methodName}($value);
			}
		}
	}
}