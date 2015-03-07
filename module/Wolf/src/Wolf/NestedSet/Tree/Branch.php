<?php
/**
**    ____  _____ _     ____
**   /  _ \/  __// \ |\/_   \
**   | | \||  \  | | // /   /
**   | |_/||  /_ | \// /   /_
**   \____/\____\\__/  \____/
**
** @author Bikash Poudel<bikash.poudel.com@gmail.com>
** © Dev2 Ltd. 2013-2014
**/
namespace Wolf\NestedSet\Tree;

use Zend\Db\ResultSet\ResultSet;

/**
 * Branch
 *
 * @see http://framework.zend.com/wiki/display/ZFPROP/Zend_Db_NestedSet+-+Graham+Anderson
 */
class Branch
{
	/**
	 * Result set
	 *
	 * @var \Zend\Db\ResultSet\ResultSet
	 */
	protected $resultSet = null;

	protected $table = null;

	/**
	 * Constructor
	 *
	 * @param \Zend\Db\ResultSet\ResultSet $resultSet
	 */
	public function __construct(ResultSet $resultSet, Tree $tree)
	{
		$this->resultSet = $resultSet;
		$this->table = $tree;
	}

	/**
	 * Get result set
	 *
	 * @return type
	 */
	public function getResultSet()
	{
		return $this->resultSet;
	}

	/**
	 * To Multi Array
	 */
	public function toMultiArray(array &$references = array())
	{
		$tree = array();

		foreach ($this->resultSet as $row) {
			$nodeId   = $row['id'];
			$parentId = $row['parent_id'];

			$node = new Node($row, $this->table);

			$references[$nodeId] = array(
				'item'     => $node,
				'parent'   => null,
				'children' => array()
			);

			if (isset($references[$parentId])) {
				$references[$nodeId]['parent']              = &$references[$parentId];
				$references[$parentId]['children'][$nodeId] = &$references[$nodeId];
			} else {
				$tree[$nodeId] = &$references[$nodeId];
			}
		}

		return $tree;
	}
}