<?php


namespace Royalcms\Component\Preloader;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\PrettyPrinter\Standard;

class MyStandard extends Standard
{

    /**
     * Pretty prints an array of nodes (statements) and indents them optionally.
     *
     * @param Node[] $nodes  Array of nodes
     * @param bool   $indent Whether to indent the printed nodes
     *
     * @return string Pretty printed statements
     */
    protected function pStmts(array $nodes, bool $indent = true) : string {
        if ($indent) {
            $this->indent();
        }

        $result = '';
        foreach ($nodes as $node) {
            $comments = $node->getComments();
            if ($comments) {
                $result .= $this->nl . $this->pComments($comments);
                if ($node instanceof Stmt\Nop) {
                    continue;
                }
            }

            $result .= $this->nl . $this->p($node);
        }


        $result = $this->pNoteReplace($result, $nodes);

        if ($indent) {
            $this->outdent();
        }

        return $result;
    }

    protected function pNoteReplace($pretty, $nodes)
    {
        $namespace = $this->getNamespaceNode($nodes);

        if (! $namespace) {
            return $pretty;
        }

        $namespaceName = $namespace->name . '\\\\';

        //replace class exists
        $pretty = preg_replace('/class_exists\(\'(.*)\', false\)/i', 'class_exists(\''.$namespaceName.'${1}\', false)', $pretty, 1);
        //replace interface exists
        $pretty = preg_replace('/interface_exists\(\'(.*)\', false\)/i', 'interface_exists(\''.$namespaceName.'${1}\', false)', $pretty, 1);
        //replace trait exists
        $pretty = preg_replace('/trait_exists\(\'(.*)\', false\)/i', 'trait_exists(\''.$namespaceName.'${1}\', false)', $pretty, 1);

        return $pretty;
    }

    protected function pNoteNotNamespaceReplace()
    {
        //replace class exists
        $pretty = preg_replace('/class_exists\(\'(.*)\'\)/i', 'class_exists(\'${1}\', false)', $pretty, 1);
        //replace interface exists
        $pretty = preg_replace('/interface_exists\(\'(.*)\'\)/i', 'interface_exists(\'${1}\', false)', $pretty, 1);
        //replace trait exists
        $pretty = preg_replace('/trait_exists\(\'(.*)\'\)/i', 'trait_exists(\'${1}\', false)', $pretty, 1);
    }

    protected function pStmt_Class(Stmt\Class_ $node) {

        $code = parent::pStmt_Class($node);

        $className = trim($node->name);

        $code = "if (! class_exists('$className', false)) {\n{$code}";
        $code = "$code\n}";

        return $code;
    }

    protected function pStmt_Interface(Stmt\Interface_ $node) {
        $code = parent::pStmt_Interface($node);

        $className = trim($node->name);

        $code = "if (! interface_exists('$className', false)) {\n{$code}";
        $code = "$code\n}";

        return $code;
    }

    protected function pStmt_Trait(Stmt\Trait_ $node) {
        $code = parent::pStmt_Trait($node);

        $className = trim($node->name);

        $code = "if (! trait_exists('$className', false)) {\n{$code}";
        $code = "$code\n}";

        return $code;
    }


    protected function getNamespaceNode($nodes)
    {
        $nodes = array_filter($nodes, function ($node) {
            return $node instanceof Namespace_;
        });

        if (empty($nodes)) {
            return null;
        }

        $namespace = array_shift($nodes);

        return $namespace;
    }

}