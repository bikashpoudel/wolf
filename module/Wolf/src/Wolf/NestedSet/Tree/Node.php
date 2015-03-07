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

use Wolf\NestedSet\Tree\Tree;
use Zend\Db\Sql\Predicate\Operator;
use Zend\Db\Sql\Select;

/**
 * Node class
 *
 * @see http://framework.zend.com/wiki/display/ZFPROP/Zend_Db_NestedSet+-+Graham+Anderson
 */
class Node
{
	/**
	 * Table
	 *
	 * @var \Wolf\\NestedSet\Tree\Tree
	 */
	protected $table = null;

	/**
	 * Id - Node Id
	 *
	 * @var int
	 */
	protected $id = null;

	/**
	 * TreeId
	 *
	 * @var int
	 */
	protected $treeId = null;

	/**
	 * External Id
	 *
	 * @var int
	 */
	protected $externalId = null;

	/**
	 * Parent Id
	 *
	 * @var int
	 */
	protected $parentId = null;

	/**
	 * Left Id
	 *
	 * @var int
	 */
	protected $left = null;

	/**
	 * Right Id
	 *
	 * @var int
	 */
	protected $right = null;

	/**
	 * Constructor
	 *
	 * @param \stdClass $resultSet
	 * @param \Wolf\\NestedSet\Tree\Tree $tree
	 */
	public function __construct($nodeData, Tree $tree)
	{
		$this->table       = $tree;
		$this->id         = $nodeData->id;
		$this->externalId = $nodeData->{$tree->getExternalKey()};
		$this->left       = $nodeData->left;
		$this->right      = $nodeData->right;
		$this->treeId     = $nodeData->tree_id;
		$this->parentId   = $nodeData->parent_id;
	}

	/**
	 * Get Id
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get external id
	 *
	 * @return int
	 */
	public function getExternalId()
	{
		return $this->externalId;
	}

	/**
	 * Get left
	 *
	 * @return int
	 */
	public function getLeft()
	{
		return $this->left;
	}

	/**
	 * Set left
	 *
	 * @param int $left
	 * @return \Wolf\\NestedSet\Tree\Node
	 */
	public function setLeft($left)
	{
		$this->left = $left;
		return $this;
	}

	/**
	 * Get right
	 *
	 * @return type
	 */
	public function getRight()
	{
		return $this->right;
	}

	/**
	 * Set Right
	 *
	 * @param int $right
	 * @return \Wolf\\NestedSet\Tree\Node
	 */
	public function setRight($right)
	{
		$this->right = $right;
		return $this;
	}

	/**
	 * Get tree id
	 *
	 * @return int
	 */
	public function getTreeId()
	{
		return $this->treeId;
	}

	/**
	 * Get parent id
	 *
	 * @return int
	 */
	public function getParentId()
	{
		return $this->parentId;
	}

	/**
	 * Is root
	 *
	 * @return boolean
	 */
	public function isRoot()
	{
		return ($this->left == 1);
	}

	/**
	 * Is Leaf
	 *
	 * @return boolean
	 */
	public function isLeaf()
	{
		return ($this->right - $this->left == 1);
	}

	/**
	 * Get the full tree this node belongs to.
	 *
	 * @return \Wolf\\NestedSet\Tree\Branch
	 */
	public function getTree()
	{
		return $this->table->getTree($this->treeId);
	}

	/**
	 * Get Root
	 *
	 * @return \Wolf\\NestedSet\Tree\Node
	 */
	public function getRoot()
	{
		return $this->table->getRoot($this->treeId);
	}

	/**
	 * Get Parent Node
	 *
	 * @return \Wolf\\NestedSet\Tree\Node
	 */
	public function getParent()
	{
		return $this->table->getNodeById($this->parentId);
	}

	/**
	 * Get Anchestors of the node
	 *
	 * @return \Wolf\\NestedSet\Tree\Branch
	 */
	public function getAnchestors()
	{
		$resultSet = $this->table->select(function(Select $select){
			$select->where(array(
				new Operator($this->table->getLeftKey(), '<', $this->left),
				new Operator($this->table->getRightKey(), '>', $this->left),
			))
			->order($this->table->getLeftKey() . ' ASC');
		});

		return new Branch($resultSet);
	}

	/**
	 * Get all siblings for this node
	 *
	 * @return \Wolf\\NestedSet\Tree\Branch
	 */
	public function getSiblings()
	{
		$resultSet = $this->table->select(function(Select $select) {
			$select->where(array(
				new Operator($this->table->getTreeKey(), '=', $this->treeId),
				new Operator($this->table->getParentKey(), '=', $this->parentId),
				new Operator($this->table->getLeftKey(), '=', $this->left)
			))
			->order($this->table->getLeftKey(). ' ASC');
		});
		return new Branch($resultSet);
	}

	/**
	 * Get sibling
	 *
	 * @param string $position
	 * @return \Wolf\\NestedSet\Tree\Node|null
	 * @throws \Exception
	 */
	public function getSibling($position = null)
	{
		$whereArray = array();
		switch ($position) {
			case Tree::NEXT_SIBLING:
				$whereArray[$this->table->getParentKey()] = $this->parentId;
				$whereArray[$this->table->getLeftKey()] = $this->right + 1;
				break;
			case Tree::PREVIOUS_SIBLING:
				$whereArray[$this->table->getParentKey()] = $this->parentId;
				$whereArray[$this->table->getRightKey()] = $this->left - 1;
				break;
			default:
				throw new \Exception('Invalid sibling specified.');
				break;
		}
		$whereArray[$this->table->getTreeKey()] = $this->treeId;
		$resultSet = $this->table->select($whereArray);

		if ($resultSet->count()) {
			$siblingId = $resultSet->current()->id;
			return $this->table->getNodeById($siblingId);
		}
		return null;
	}

	/**
	 * Get previous sibling
	 *
	 * @return \Wolf\\NestedSet\Tree\Node|null
	 */
	public function getPreviousSibling()
	{
		return $this->getSibling(Tree::PREVIOUS_SIBLING);
	}

	/**
	 * Get next sibling
	 *
	 * @return \Wolf\\NestedSet\Tree\Node|null
	 */
	public function getNextSibling()
	{
		return $this->getSibling(Tree::NEXT_SIBLING);
	}

	/**
	 * Get descendants
	 *
	 * @return \Wolf\\NestedSet\Tree\Branch
	 */
	public function getDescendants()
	{
		$resultSet = $this->table->select(function(Select $select) {
			$select->where(array(
				new Operator($this->table->getLeftKey(), '>', $this->left),
				new Operator($this->table->getRightKey(), '<', $this->right),
				new Operator($this->table->getTreeKey(), '=', $this->treeId),
			))
			->order($this->table->getLeftKey() . ' ASC');
		});
		return new Branch($resultSet);
	}

	/**
	 * Get children
	 *
	 * @return \Wolf\\NestedSet\Tree\Branch
	 */
	public function getChildren()
	{
		return $this->getDescendants();
	}

	/**
	 * Add child
	 *
	 * @param array $data
	 * @param type $position
	 * @return type
	 */
	public function addChild(array $data, $position = Tree::LAST_CHILD)
	{
		return $this->table->addChild($this, $data, $position);
	}

	/**
	 * Move before
	 *
	 * @param \Wolf\\NestedSet\Tree\Node $relation
	 * @return type
	 */
	public function moveBefore(Node $relation)
	{
		return $this->table->moveNode($this, $relation, Tree::PREVIOUS_SIBLING);
	}

	/**
	 * Move after
	 *
	 * @param \Wolf\\NestedSet\Tree\Node $relation
	 * @return type
	 */
	public function moveAfter(Node $relation)
	{
		return $this->table->moveNode($this, $relation, Tree::NEXT_SIBLING);
	}

	/**
	 * Move Below
	 *
	 * @param \Wolf\\NestedSet\Tree\Node $relation
	 * @return type
	 */
	public function moveBelow(Node $relation)
	{
		return $this->table->moveNode($this, $relation, Tree::LAST_CHILD);
	}

	/**
	 * Delete node
	 *
	 * @param \Wolf\\NestedSet\Tree\Node $node
	 * @return type
	 */
	public function delete(Node $node)
	{
		return $this->table->deleteNode($node);
	}
}