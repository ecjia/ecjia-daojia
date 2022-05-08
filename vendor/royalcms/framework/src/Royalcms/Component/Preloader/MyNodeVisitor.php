<?php


namespace Royalcms\Component\Preloader;


use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class MyNodeVisitor extends NodeVisitorAbstract
{

    public function leaveNode(Node $node) {

        if ($node instanceof Node\Stmt\Class_) {

        }
        elseif ($node instanceof Node\Stmt\Interface_) {

        }

        return $node;
    }

}