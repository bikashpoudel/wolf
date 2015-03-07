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
namespace Cli\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Db\Metadata\Metadata;
use Zend\Console\Getopt;

/**
 * Description of TableGenerator
 */
class TableGeneratorController extends AbstractActionController {

	/**
	 * Generate table action
	 */
	public function generateTableAction()
	{

		if (php_sapi_name() == 'cli') {
			$opt = new Getopt([
				'database|d=s' => 'Database',
			]);

			if (!$opt->d) {
				throw new \Exception('--database|d is a required parameter.');
			}

			//check if database has been passed from the command line and if the database name matches dev2_(.)
			preg_match('/^wolf(.)*/', $opt->d, $matches);
			if ($matches && isset($matches[0])) {
				$_SERVER['DATABASE_SLAVE']  = $opt->d;
				$_SERVER['DATABASE_MASTER'] = $opt->d;
			} else {
				throw new \Exception('--database|d is a required parameter, and should match /^wolf(.)+/ pattern.');
			}
		}

		$metaData = new Metadata($this->dbAdapter);
		$tableNames = $metaData->getTableNames();
		$templateFile = getcwd() . '/data/templates/table.tpl';
		$templateContent = file_get_contents($templateFile);
		$underscoreToCamelCaseFilter = $this->filterPluginManager->get('wordunderscoretocamelcase');
		$siteSettings = $this->siteSettings;
		$defaultNameSpace = $siteSettings->get('site.default.namespace');

		foreach ($tableNames as $tableName) {
			$clonedTC = $templateContent;
			$plainTableName = $tableName;
			$table = $metaData->getTable($tableName);
			$tableName = $underscoreToCamelCaseFilter->filter($tableName);
			$savePath  = sprintf('%s/module/%s/src/%s/Db/Table/%s.php',
				getcwd(),
				$defaultNameSpace,
				$defaultNameSpace,
				$tableName
			);

			print (sprintf('Generating table class for: %s @ %s' . PHP_EOL, $tableName, $savePath));

			$columns = $table->getColumns();
			$columnNamesCollection = '';
			foreach ($columns as $column) {
				$columnNamesCollection .= sprintf(
					"\t\t'%s' => '%s'," . PHP_EOL,
					lcfirst($underscoreToCamelCaseFilter->filter($column->getName())),
					$column->getName()
				);
			}

			$columnNamesCollection = "\t\t//generated via: "
				. __CLASS__
				. ' on ' . date('d/m/Y H:i:s')
				. PHP_EOL
				. $columnNamesCollection;
			$fileContent = sprintf($clonedTC, $tableName, $tableName, $plainTableName, $columnNamesCollection);

			//open the file on the save path
			$handle = fopen($savePath, 'w') or die(sprintf('Cannot open file @ %s for writing', $savePath));
			fwrite($handle, $fileContent);
			fclose($handle);

			echo $fileContent . PHP_EOL . PHP_EOL;
		}
	}
}
