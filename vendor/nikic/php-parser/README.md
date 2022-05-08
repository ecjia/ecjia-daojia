PHP Parser
==========

<<<<<<< HEAD
[![Build Status](https://travis-ci.org/nikic/PHP-Parser.svg?branch=master)](https://travis-ci.org/nikic/PHP-Parser) [![Coverage Status](https://coveralls.io/repos/github/nikic/PHP-Parser/badge.svg?branch=master)](https://coveralls.io/github/nikic/PHP-Parser?branch=master)

This is a PHP 5.2 to PHP 7.0 parser written in PHP. Its purpose is to simplify static code analysis and
manipulation.

[**Documentation for version 2.x**][doc_master] (stable; for running on PHP >= 5.4; for parsing PHP 5.2 to PHP 7.0).

[Documentation for version 1.x][doc_1_x] (unsupported; for running on PHP >= 5.3; for parsing PHP 5.2 to PHP 5.6).

In a Nutshell
-------------

The parser turns PHP source code into an abstract syntax tree. For example, if you pass the following code into the
parser:

```php
<?php
echo 'Hi', 'World';
hello\world('foo', 'bar' . 'baz');
```

You'll get a syntax tree looking roughly like this:

```php
array(
    0: Stmt_Echo(
        exprs: array(
            0: Scalar_String(
                value: Hi
            )
            1: Scalar_String(
                value: World
            )
        )
    )
    1: Expr_FuncCall(
        name: Name(
            parts: array(
                0: hello
                1: world
            )
        )
        args: array(
            0: Arg(
                value: Scalar_String(
                    value: foo
                )
                byRef: false
            )
            1: Arg(
                value: Expr_Concat(
                    left: Scalar_String(
                        value: bar
                    )
                    right: Scalar_String(
                        value: baz
                    )
                )
                byRef: false
            )
        )
=======
[![Coverage Status](https://coveralls.io/repos/github/nikic/PHP-Parser/badge.svg?branch=master)](https://coveralls.io/github/nikic/PHP-Parser?branch=master)

This is a PHP 5.2 to PHP 8.0 parser written in PHP. Its purpose is to simplify static code analysis and
manipulation.

[**Documentation for version 4.x**][doc_master] (stable; for running on PHP >= 7.0; for parsing PHP 5.2 to PHP 8.0).

[Documentation for version 3.x][doc_3_x] (unsupported; for running on PHP >= 5.5; for parsing PHP 5.2 to PHP 7.2).

Features
--------

The main features provided by this library are:

 * Parsing PHP 5, PHP 7, and PHP 8 code into an abstract syntax tree (AST).
   * Invalid code can be parsed into a partial AST.
   * The AST contains accurate location information.
 * Dumping the AST in human-readable form.
 * Converting an AST back to PHP code.
   * Experimental: Formatting can be preserved for partially changed ASTs.
 * Infrastructure to traverse and modify ASTs.
 * Resolution of namespaced names.
 * Evaluation of constant expressions.
 * Builders to simplify AST construction for code generation.
 * Converting an AST into JSON and back.

Quick Start
-----------

Install the library using [composer](https://getcomposer.org):

    php composer.phar require nikic/php-parser

Parse some PHP code into an AST and dump the result in human-readable form:

```php
<?php
use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;

$code = <<<'CODE'
<?php

function test($foo)
{
    var_dump($foo);
}
CODE;

$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
try {
    $ast = $parser->parse($code);
} catch (Error $error) {
    echo "Parse error: {$error->getMessage()}\n";
    return;
}

$dumper = new NodeDumper;
echo $dumper->dump($ast) . "\n";
```

This dumps an AST looking something like this:

```
array(
    0: Stmt_Function(
        byRef: false
        name: Identifier(
            name: test
        )
        params: array(
            0: Param(
                type: null
                byRef: false
                variadic: false
                var: Expr_Variable(
                    name: foo
                )
                default: null
            )
        )
        returnType: null
        stmts: array(
            0: Stmt_Expression(
                expr: Expr_FuncCall(
                    name: Name(
                        parts: array(
                            0: var_dump
                        )
                    )
                    args: array(
                        0: Arg(
                            value: Expr_Variable(
                                name: foo
                            )
                            byRef: false
                            unpack: false
                        )
                    )
                )
            )
        )
    )
)
```

Let's traverse the AST and perform some kind of modification. For example, drop all function bodies:

```php
use PhpParser\Node;
use PhpParser\Node\Stmt\Function_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

$traverser = new NodeTraverser();
$traverser->addVisitor(new class extends NodeVisitorAbstract {
    public function enterNode(Node $node) {
        if ($node instanceof Function_) {
            // Clean out the function body
            $node->stmts = [];
        }
    }
});

$ast = $traverser->traverse($ast);
echo $dumper->dump($ast) . "\n";
```

This gives us an AST where the `Function_::$stmts` are empty:

```
array(
    0: Stmt_Function(
        byRef: false
        name: Identifier(
            name: test
        )
        params: array(
            0: Param(
                type: null
                byRef: false
                variadic: false
                var: Expr_Variable(
                    name: foo
                )
                default: null
            )
        )
        returnType: null
        stmts: array(
        )
>>>>>>> v2-test
    )
)
```

<<<<<<< HEAD
You can then work with this syntax tree, for example to statically analyze the code (e.g. to find
programming errors or security issues).

Additionally, you can convert a syntax tree back to PHP code. This allows you to do code preprocessing
(like automatedly porting code to older PHP versions).

Installation
------------

The preferred installation method is [composer](https://getcomposer.org):

    php composer.phar require nikic/php-parser
=======
Finally, we can convert the new AST back to PHP code:

```php
use PhpParser\PrettyPrinter;

$prettyPrinter = new PrettyPrinter\Standard;
echo $prettyPrinter->prettyPrintFile($ast);
```

This gives us our original code, minus the `var_dump()` call inside the function:

```php
<?php

function test($foo)
{
}
```

For a more comprehensive introduction, see the documentation.
>>>>>>> v2-test

Documentation
-------------

 1. [Introduction](doc/0_Introduction.markdown)
 2. [Usage of basic components](doc/2_Usage_of_basic_components.markdown)
<<<<<<< HEAD
 3. [Other node tree representations](doc/3_Other_node_tree_representations.markdown)
 4. [Code generation](doc/4_Code_generation.markdown)

Component documentation:

 1. [Error](doc/component/Error.markdown)
 2. [Lexer](doc/component/Lexer.markdown)

 [doc_1_x]: https://github.com/nikic/PHP-Parser/tree/1.x/doc
=======

Component documentation:

 * [Walking the AST](doc/component/Walking_the_AST.markdown)
   * Node visitors
   * Modifying the AST from a visitor
   * Short-circuiting traversals
   * Interleaved visitors
   * Simple node finding API
   * Parent and sibling references
 * [Name resolution](doc/component/Name_resolution.markdown)
   * Name resolver options
   * Name resolution context
 * [Pretty printing](doc/component/Pretty_printing.markdown)
   * Converting AST back to PHP code
   * Customizing formatting
   * Formatting-preserving code transformations
 * [AST builders](doc/component/AST_builders.markdown)
   * Fluent builders for AST nodes
 * [Lexer](doc/component/Lexer.markdown)
   * Lexer options
   * Token and file positions for nodes
   * Custom attributes
 * [Error handling](doc/component/Error_handling.markdown)
   * Column information for errors
   * Error recovery (parsing of syntactically incorrect code)
 * [Constant expression evaluation](doc/component/Constant_expression_evaluation.markdown)
   * Evaluating constant/property/etc initializers
   * Handling errors and unsupported expressions
 * [JSON representation](doc/component/JSON_representation.markdown)
   * JSON encoding and decoding of ASTs
 * [Performance](doc/component/Performance.markdown)
   * Disabling XDebug
   * Reusing objects
   * Garbage collection impact
 * [Frequently asked questions](doc/component/FAQ.markdown)
   * Parent and sibling references

 [doc_3_x]: https://github.com/nikic/PHP-Parser/tree/3.x/doc
>>>>>>> v2-test
 [doc_master]: https://github.com/nikic/PHP-Parser/tree/master/doc
