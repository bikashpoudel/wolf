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

use Wolf\Entity\AbstractEntity;
use Zend\ServiceManager\AbstractPluginManager;

/**
 * Description of EntityPluginManager
 */
class EntityPluginManager
	extends AbstractPluginManager {

	/**
	 * Share by default
	 *
	 * @var boolean
	 */
	protected $shareByDefault = false;

	/**
	 * Default set of helpers
	 *
	 * @var array
	 */
	protected $invokableClasses = [
		'aclpermissionentity' => 'Acl\Entity\AclPermission',
		'aclroleentity'       => 'Acl\Entity\AclRole',
		'aclroletypeentity'   => 'Acl\Entity\AclRoleType',
		'userentity'          => 'User\Entity\User',
	];

	/**
	 * Validate plugin
	 *
	 * @param AbstractEntity $plugin
	 * @return bool
	 */
	public function validatePlugin($plugin)
	{
		return $plugin instanceof AbstractEntity;
	}

	/**
     * Attempt to create an instance via an invokable class
     *
     * Overrides parent implementation by passing $creationOptions to the
     * constructor, if non-null.
     *
     * @param  string $canonicalName
     * @param  string $requestedName
     * @return null|\stdClass
     * @throws Exception\ServiceNotCreatedException If resolved class does not exist
     */
    protected function createFromInvokable($canonicalName, $requestedName)
    {
        $invokable = $this->invokableClasses[$canonicalName];

        if (null === $this->creationOptions
            || (is_array($this->creationOptions) && empty($this->creationOptions))
        ) {
            $instance = new $invokable();
        } else {
            if (isset($this->creationOptions['name'])) {
                $name = $this->creationOptions['name'];
            } else {
                $name = $requestedName;
            }

            if (isset($this->creationOptions['options'])) {
                $options = $this->creationOptions['options'];
            } else {
                $options = $this->creationOptions;
            }

            $instance = new $invokable($options);
        }

        return $instance;
    }

}
