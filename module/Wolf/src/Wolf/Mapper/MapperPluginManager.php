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

use Wolf\Entity\EntityPluginManagerAwareInterface;
use Wolf\Mapper\AbstractMapper;
use Zend\Db\Sql\Sql;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ConfigInterface;
use Zend\Db\Adapter\AdapterAwareInterface;

/**
 * Description of MapperPluginManager
 */
class MapperPluginManager
	extends AbstractPluginManager {

	/**
	 * Default set of helpers
	 *
	 * @var array
	 */
	protected $invokableClasses = [
		'usersmapper' => 'User\Mapper\Users',
		'rbacmapper'  => 'Acl\Mapper\Rbac',
	];

	/**
	 * Construct
	 *
	 * @param \Zend\ServiceManager\ConfigInterface $configuration
	 */
	public function __construct(ConfigInterface $configuration = null)
	{
		parent::__construct($configuration);

		$this->addInitializer(array($this, 'injectDbAdapter'));
		$this->addInitializer(array($this, 'injectSql'));
		$this->addInitializer(array($this, 'injectEntityPluginManager'));
	}

	/**
	 * Validate plugin
	 *
	 * @param AbstractMapper $plugin
	 * @return boolean
	 */
	 public function validatePlugin($plugin)
	 {
		return ($plugin instanceof AbstractMapper);
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

	/**
	 * Inject DbAdapter
	 *
	 * @param AdapterAwareInterface $instance
	 */
	public function injectDbAdapter($instance)
	{
		if ($instance instanceof AdapterAwareInterface) {
			if ($this->serviceLocator->has('DbAdapter')) {
				$instance->setDbAdapter($this->serviceLocator->get('DbAdapter'));
			}
		}
	}

	/**
	 * Inject Sql
	 *
	 * @param AbstractMapper $instance
	 */
	public function injectSql($instance)
	{
		if ($instance instanceof AbstractMapper) {
			$instance->setSql(new Sql($this->serviceLocator->get('DbAdapter')));
		}
	}

	/**
	 * Inject entity plugin manager
	 *
	 * @param EntityPluginManagerAwareInterface $instance
	 */
	public function injectEntityPluginManager($instance)
	{
		if ($instance instanceof EntityPluginManagerAwareInterface) {
			$instance->setEntityPluginManager($this->serviceLocator->get('EntityPluginManager'));
		}
	}
}
