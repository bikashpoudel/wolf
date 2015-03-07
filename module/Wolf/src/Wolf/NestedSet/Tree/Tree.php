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

use Wolf\NestedSet\Tree\Branch;
use Wolf\NestedSet\Tree\Node;

use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Operator;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

/**
 * Tree
 *
 * Main service class for reading/manipulating tree
 * @see http://framework.zend.com/wiki/display/ZFPROP/Zend_Db_NestedSet+-+Graham+Anderson
 */
class Tree extends TableGateway
{
	/**
	 * Tree constants
	 */
	const PREVIOUS_SIBLING = 'previous';
	const NEXT_SIBLING      = 'next';
	const FIRST_CHILD       = 'firstChild';
	const LAST_CHILD        = 'lastChild';
	/**
	 * Does the table allow multiple trees
	 *
	 * @var boolean
	 */
	protected $multiTree = true;

	/**
	 * Left key
	 *
	 * @var string
	 */
	protected $leftKey = 'left';

	/**
	 * Right key
	 *
	 * @var string
	 */
	protected $rightKey = 'right';

	/**
	 * Tree Key
	 *
	 * @var string
	 */
	protected $treeKey = 'tree_id';

	/**
	 * Parent key
	 *
	 * @var string
	 */
	protected $parentKey = 'parent_id';

	/**
	 * External key | The referenced table primary key
	 *
	 * @var string
	 */
	protected $externalKey = 'external_id';

	/**
	 * Get left key
	 *
	 * @return string
	 */
	public function getLeftKey()
	{
		return $this->leftKey;
	}

	/**
	 * Get right key
	 *
	 * @return string
	 */
	public function getRightKey()
	{
		return $this->rightKey;
	}

	/**
	 * Get Tree Key
	 *
	 * @return string
	 */
	public function getTreeKey()
	{
		return $this->treeKey;
	}

	/**
	 * Get Parent Key
	 *
	 * @return string
	 */
	public function getParentKey()
	{
		return $this->parentKey;
	}

	/**
	 * External Key
	 *
	 * @return type
	 */
	public function getExternalKey()
	{
		return $this->externalKey;
	}

	/**
	 * Set external key
	 *
	 * @param string $externalKey
	 */
	public function setExternalKey($externalKey)
	{
		$this->externalKey = $externalKey;
	}

	/**
	 * Has root
	 *
	 * @param boolean $treeId
	 */
	public function hasRoot($treeId = null)
	{
		$result = $this->select(array(
			$this->getTreeKey() => $treeId,
			$this->getLeftKey() => 1
		));
		if ($result->count() == 1) {
			return true;
		}
		return false;
	}

	/**
	 * Add Root Node
	 *
	 * @param array $values
	 * @return \Wolf\NestedSet\Tree\Node
	 * @throws \Exception
	 */
	public function addRootNode(array $values = array())
	{
		$values[$this->getLeftKey()] = 1;
		$values[$this->getRightKey()] = 2;
		$values[$this->getParentKey()] = null;

		if (!isset($values[$this->getTreeKey()])) {
			throw new \Exception('Tree id is not defined.');
		}
		$affectedRows = $this->insert($values);
		if (!$affectedRows) {
			throw new \Exception('Node could not be inserted');
		}

		$lastInsertId = $this->getLastInsertValue();
		return $this->getNodeById($lastInsertId);
	}

	/**
	 * Get Root
	 *
	 * @param int $treeId
	 * @return \Wolf\NestedSet\Tree\Node
	 */
	public function getRoot($treeId = null)
	{
		$resultSet = $this->select(array(
			$this->getTreeKey() => $treeId,
			$this->getLeftKey() => 1
		));
		return new Node($resultSet->current(), $this);
	}

	/**
	 * Get node by tree id and external id
	 *
	 * @param type $treeId
	 * @param type $externalId
	 * @return \Wolf\NestedSet\Tree\Node
	 */
	public function getNodeByTreeIdAndExternalId($treeId, $externalId)
	{
		$resultSet = $this->select([
			$this->getTreeKey()      => $treeId,
			$this->getExternalKey()  => $externalId,
		]);
		return new Node($resultSet->current(), $this);
	}

	/**
	 * Get Node By Id
	 *
	 * @param int $id
	 * @return \Wolf\NestedSet\Tree\Node
	 */
	public function getNodeById($id)
	{
		$resultSet = $this->select(array(
			'id' => $id
		));
		if (!$resultSet->count() == 1) {
			throw new \Exception(
				sprintf('Node by id: %d is not found', $id)
			);
		}
		//@todo $this needs to be injected as a service.
		return new Node($resultSet->current(), $this);
	}

	/**
	 * Get Tree
	 *
	 * @param int $treeId
	 * @return \Wolf\NestedSet\Tree\Branch
	 */
	public function getTree($treeId)
	{
		$resultSet = $this->select(array(
			'tree_id' => $treeId
		));
		return new Branch($resultSet, $this);
	}

	/**
	 * Apply delta shift - Shift the left and right values of nodes to make room
	 * for adding new node
	 * Calls to this method should be wrapped in the transaction
	 *
	 * @param type $delta
	 * @param type $value
	 * @param type $treeId
	 */
	public function applyDeltaShift($delta, $value, $treeId)
	{
		//update left keys
		$this->update(
			//@todo is this bug with zend or what????
			array($this->leftKey => new Expression($this->adapter->getPlatform()->quoteIdentifier($this->leftKey) . ' + ' . $delta)),
			array(
				new Operator($this->treeKey, '=', $treeId),
				new Operator($this->leftKey, '>=', $value),
			)
		);

		//update right keys
		$this->update(
			array($this->rightKey => new Expression($this->adapter->getPlatform()->quoteIdentifier($this->rightKey) . ' + ' . $delta)),
			array(
				new Operator($this->treeKey, '=', $treeId),
				new Operator($this->rightKey, '>=', $value),
			)
		);
	}

	/**
	 * Apply Delta Range
	 *
	 * @param \Wolf\NestedSet\Tree\Node $node
	 * @param type $delta
	 * @param type $treeId
	 * @return void
	 */
	public function applyDeltaRange(Node $node, $delta, $treeId = null)
	{
		$this->update(
			array($this->leftKey => new Expression($this->adapter->getPlatform()->quoteIdentifier($this->leftKey) . ' + ' . $delta)),
			array(
				new Operator($this->treeKey, '=', $treeId),
				new Operator($this->leftKey, '>=', $node->getLeft()),
				new Operator($this->leftKey, '<=', $node->getRight())
			)
		);

		$this->update(
			array($this->rightKey => new Expression($this->adapter->getPlatform()->quoteIdentifier($this->rightKey) . ' + ' . $delta)),
			array(
				new Operator($this->treeKey, '=', $treeId),
				new Operator($this->rightKey, '>=', $node->getLeft()),
				new Operator($this->rightKey, '<=', $node->getRight())
			)
		);
	}

	/**
	 * Add new node to specified relation
	 *
	 * @param \Wolf\NestedSet\Tree\Node $relation
	 * @param array $data
	 * @param string $position
	 * @throws \Exception
	 */
	public function addNode(Node $relation, $data, $position = self::LAST_CHILD)
	{
		switch ($position) {
			case self::LAST_CHILD:
				$data[$this->leftKey]   = $relation->getRight();
				$data[$this->rightKey]  = $relation->getRight() + 1;
				$data[$this->parentKey] = $relation->getId();
				break;
			case self::FIRST_CHILD:
				$data[$this->leftKey]   = $relation->getLeft() + 1;
				$data[$this->rightKey]  = $relation->getLeft() + 2;
				$data[$this->parentKey] = $relation->getId();
				break;
			case self::NEXT_SIBLING:
				$data[$this->leftKey]   = $relation->getRight() + 1;
				$data[$this->rightKey]  = $relation->getRight() + 2;
				$data[$this->parentKey] = $relation->getParentId();
				break;
			case self::PREVIOUS_SIBLING:
				$data[$this->leftKey]   = $relation->getLeft();
				$data[$this->rightKey]  = $relation->getLeft() + 1;
				$data[$this->parentKey] = $relation->getParentId();
				break;
			default:
				throw new \Exception('Invalid position');
		}
		$data[$this->treeKey] = $relation->getTreeId();

		$performTransaction = true;
		if ($this->adapter->getDriver()->getConnection()->inTransaction()) {
			$performTransaction = false;
		}

		if ($performTransaction) {
			$this->adapter->getDriver()->getConnection()->beginTransaction();
		}

		try {
			$this->applyDeltaShift(2, $data[$this->leftKey], $relation->getTreeId());
			$this->insert($data);
			if ($performTransaction) {
				$this->adapter->getDriver()->getConnection()->commit();
			}
		} catch (\Exception $ex) {
			if ($performTransaction) {
				$this->adapter->getDriver()->getConnection()->rollback();
			}
			throw $ex;
		}

		$nodeId = $this->getLastInsertValue();
		return $this->getNodeById($nodeId);
	}

	/**
	 * Move Node
	 *
	 * @param \Wolf\NestedSet\Tree\Node $node
	 * @param \Wolf\NestedSet\Tree\Node $relation
	 * @param string $position
	 * @return array
	 * @throws \Exception
	 * @throws \Wolf\NestedSet\Tree\Exception
	 */
	public function moveNode(Node $node, Node $relation, $position = self::LAST_CHILD)
	{
		$updateParent = false;
		switch ($position) {
			case self::LAST_CHILD:
				$nodeDestination = $relation->getRight();
				$updateParent = true;
				break;
			case self::FIRST_CHILD:
				$nodeDestination = $relation->getLeft() + 1;
				$updateParent = true;
				break;
			case self::NEXT_SIBLING:
				$nodeDestination = $relation->getRight() + 1;
				break;
			case self::PREVIOUS_SIBLING:
				$nodeDestination = $relation->getLeft();
				break;
			default:
				throw new \Exception('Invalid position argument: ' . $position);
		}

		$branchWidth = ($node->getRight() - $node->getLeft()) + 1;

		$performTransaction = true;
		if ($this->adapter->getDriver()->getConnection()->inTransaction()) {
			$performTransaction = false;
		}

		if ($performTransaction) {
			$this->adapter->getDriver()->getConnection()->beginTransaction();
		}

		try {
			$treeId = $node->getTreeId();
			$this->applyDeltaShift($branchWidth, $nodeDestination, $treeId);

			if ($node->getLeft() >= $nodeDestination) {
				$node->setLeft($node->getLeft() + $branchWidth);
				$node->setRight($node->getRight() + $branchWidth);
			}

			$range = $nodeDestination - $node->getLeft();
			$this->applyDeltaRange($node, $range, $treeId);
			$this->applyDeltaShift(-$branchWidth, ($node->getRight() + 1), $treeId);

			if ($updateParent) {
				$parentId = $relation->getId();
			} else {
				$parentId = $relation->getParentId();
			}

			$this->update(
				array($this->parentKey => $parentId),
				array(
					'id' => $node->getId()
				)
			);

			if ($performTransaction) {
				$this->adapter->getDriver()->getConnection()->commit();
			}

		} catch (\Exception $ex) {
			$this->adapter->getDriver()->getConnection()->rollback();
			throw $ex;
		}

		$newBranchValues = array(
			$this->leftKey => $node->getLeft() + $range,
			$this->rightKey => $node->getRight() + $range
		);

		if ($node->getLeft() <= $nodeDestination) {
			$newBranchValues[$this->leftKey] -= $branchWidth;
			$newBranchValues[$this->rightKey] -= $branchWidth;
		}
		return $newBranchValues;
	}

	/**
	 * Delete Node
	 *
	 * @param \Wolf\NestedSet\Tree\Node $node
	 * @return type
	 * @throws \Wolf\NestedSet\Tree\Exception
	 */
	public function deleteNode(Node $node)
	{
		if (!$this->adapter->getDriver()->getConnection()->inTransaction()) {
			$this->adapter->getDriver()->getConnection()->beginTransaction();
		}

		try {
			$rowsDeleted = $this->delete(array(
				new Operator($this->treeKey, '=', $node->getTreeId()),
				new Operator($this->leftKey, '>=', $node->getLeft()),
				new Operator($this->rightKey, '<=', $node->getRight())
			));

			$this->applyDeltaShift(
				$node->getLeft() - $node->getRight() -1,
				$node->getRight() + 1,
				$node->getTreeId()
			);

			$this->adapter->getDriver()->getConnection()->commit();
		} catch (\Exception $ex) {
			$this->adapter->getDriver()->getConnection()->rollback();
			throw $ex;
		}

		return $rowsDeleted;
	}

	/**
	 * Add child
	 *
	 * @param \Wolf\NestedSet\Tree\Node $parent
	 * @param array $data
	 * @param array $position
	 * @return \Wolf\NestedSet\Tree\Node
	 */
	public function addChild(Node $parent, array $data, $position = self::LAST_CHILD)
	{
		return $this->addNode($parent, $data, $position);
	}

	/**
	 * Add sibling
	 *
	 * @param \Wolf\NestedSet\Tree\Node $relation
	 * @param array $data
	 * @param string $position
	 * @return \Wolf\NestedSet\Tree\Node
	 */
	public function addSibling(Node $relation, array $data, $position = self::NEXT_SIBLING)
	{
		return $this->addNode($relation, $data, $position);
	}

	/**
	 * Fetch tree
	 *
	 * @param int $treeId
	 * @return \Wolf\NestedSet\Tree\Branch
	 */
	public function fetchTree($treeId = null)
	{
		$resultSet = $this->select(function(Select $select) use ($treeId) {
			$select->where(array(
				$this->treeKey => $treeId
			))
			->order($this->leftKey . ' ASC');
		});
		return new Branch($resultSet, $this);
	}

	/**
	 * Fetch Branch
	 *
	 * @param Node $node
	 * @return Branch
	 */
	public function fetchBranch(Node $node)
	{
		$resultSet = $this->select(function(Select $select) use($node){
			$select->where(array(
				new Operator($this->leftKey, '>=', $node->getLeft()),
				new Operator($this->rightKey, '<=', $node->getRight()),
				new Operator($this->treeKey, '=', $node->getTreeId())
			))
			->order($this->leftKey . ' ASC');
		});

		return new Branch($resultSet, $this);
	}
}