<?php
// Copyright 2004-present Facebook. All Rights Reserved.
// This file is @generated by
// fbcode/hphp/facebook/tools/code_model/Generate.sh

namespace HH\CodeModel {

/**
 *  orderby orderings
 */
class OrderbyClause /*implements IOrderbyClause*/ {
  use QueryClause;
  use Node;

  private /*?Vector<IOrdering>*/ $orders;

  /**
   *  orderby orderings
   */
  public function getOrders() /*: Vector<IOrdering>*/ {
    if ($this->orders === null) {
      $this->orders = Vector {};
    }
    return $this->orders;
  }
  /**
   *  orderby orderings
   */
  public function setOrders(/*Vector<IOrdering>*/ $value) /*: this*/ {
    $this->orders = $value;
    return $this;
  }

  /**
   * Returns $visitor->visitOrderbyClause($this) if
   * such a method exists on $visitor.
   * Otherwise returns $visitor->visitExpression($this) if
   * such a method exists on $visitor.
   * Otherwise returns $visitor->visitNode($this) if
   */
  public function accept(/*mixed*/ $visitor) /*: mixed*/ {
    if (method_exists($visitor, "visitOrderbyClause")) {
      // UNSAFE
      return $visitor->visitOrderbyClause($this);
    } else if (method_exists($visitor, "visitExpression")) {
      // UNSAFE
      return $visitor->visitExpression($this);
    } else {
      return $visitor->visitNode($this);
    }
  }

  /**
   * Yields a list of nodes that are children of this node.
   * A node has exactly one parent, so doing a depth
   * first traversal of a node graph using getChildren will
   * traverse a spanning tree.
   */
  public function getChildren() /*: Continuation<INode>*/ {
    if ($this->orders !== null) {
      foreach ($this->orders as $elem) {
        yield $elem;
      }
    }
  }
}
}