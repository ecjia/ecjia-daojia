<?php

declare(strict_types=1);

/*
 * This file is part of Class Preloader.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 * (c) Michael Dowling <mtdowling@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ClassPreloader;

use ClassPreloader\Exception\IOException;
use ClassPreloader\File\FileUtils;
use ClassPreloader\Parser\DirVisitor;
use ClassPreloader\Parser\FileVisitor;
use ClassPreloader\Parser\NodeTraverser;
use ClassPreloader\Parser\StrictTypesVisitor;
use PhpParser\Node\Stmt\Namespace_ as NamespaceNode;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard as PrettyPrinter;

/**
 * This is the code generator class.
 */
final class CodeGenerator
{
    /**
     * The printer.
     *
     * @var \PhpParser\PrettyPrinter\Standard
     */
    private $printer;

    /**
     * The parser.
     *
     * @var \PhpParser\Parser
     */
    private $parser;

    /**
     * The traverser.
     *
     * @var \ClassPreloader\Parser\NodeTraverser
     */
    private $traverser;

    /**
     * Create a new class preloader instance.
     *
     * @param \PhpParser\PrettyPrinter\Standard    $printer
     * @param \PhpParser\Parser                    $parser
     * @param \ClassPreloader\Parser\NodeTraverser $traverser
     *
     * @return void
     */
    public function __construct(PrettyPrinter $printer, Parser $parser, NodeTraverser $traverser)
    {
        $this->printer = $printer;
        $this->parser = $parser;
        $this->traverser = $traverser;
    }

    /**
     * Create a new class preloader instance.
     *
     * Any options provided determine how the node traverser is setup.
     *
     * @param bool[]                 $options
     * @param \PhpParser\Parser|null $parser
     *
     * @return self
     */
    public static function create(array $options = [], Parser $parser = null)
    {
        $printer = new PrettyPrinter();

        $parser = $parser === null ? self::getParser() : $parser;

        $options = array_merge(['dir' => true, 'file' => true, 'skip' => false, 'strict' => false], $options);

        $traverser = self::getTraverser($options['dir'], $options['file'], $options['skip'], $options['strict']);

        return new self($printer, $parser, $traverser);
    }

    /**
     * Get the parser to use.
     *
     * @return \PhpParser\Parser
     */
    private static function getParser()
    {
        return (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
    }

    /**
     * Get the node traverser to use.
     *
     * @param bool $dir
     * @param bool $file
     * @param bool $skip
     * @param bool $strict
     *
     * @return \ClassPreloader\Parser\NodeTraverser
     */
    private static function getTraverser(bool $dir, bool $file, bool $skip, bool $strict)
    {
        $traverser = new NodeTraverser();

        if ($dir) {
            $traverser->addVisitor(new DirVisitor($skip));
        }

        if ($file) {
            $traverser->addVisitor(new FileVisitor($skip));
        }

        if (!$strict) {
            $traverser->addVisitor(new StrictTypesVisitor());
        }

        return $traverser;
    }

    /**
     * Get a pretty printed string of code from a file while applying visitors.
     *
     * @param string $filePath
     * @param bool   $withComments
     *
     * @throws \ClassPreloader\Exception\IOException
     * @throws \PhpParser\Error
     *
     * @return string
     */
    public function getCode(string $filePath, bool $withComments = true)
    {
        $content = FileUtils::readPhpFile($filePath, $withComments);

        if ($content === false) {
            throw new IOException("Cannot open $filePath for reading.");
        }

        $parsed = $this->parser->parse($content);
        assert($parsed !== null);
        $stmts = $this->traverser->traverseFile($parsed, $filePath);
        $pretty = $this->printer->prettyPrint($stmts);

        $pretty = self::pregReplace(
            '#^(<\?php)?[\s]*(/\*\*?.*?\*/)?[\s]*(declare[\s]*\([\s]*strict_types[\s]*=[\s]*1[\s]*\);)?#s',
            '',
            $pretty
        );

        return self::getCodeWrappedIntoNamespace($parsed, $pretty);
    }

    /**
     * Perform a PREG replace, failing with an exception on error.
     *
     * @param string   $pattern
     * @param string   $replacement
     * @param string   $subject
     * @param int|null $limit
     *
     * @return string
     */
    private static function pregReplace(string $pattern, string $replacement, string $subject, int $limit = null)
    {
        $output = @preg_replace($pattern, $replacement, $subject, $limit === null ? -1 : $limit);

        assert($output !== null);

        return $output;
    }

    /**
     * Wrap the code into a namespace.
     *
     * @param \PhpParser\Node\Stmt[] $parsed
     * @param string                 $pretty
     *
     * @return string
     */
    private static function getCodeWrappedIntoNamespace(array $parsed, $pretty)
    {
        if (self::parsedCodeHasNamespaces($parsed)) {
            $pretty = self::pregReplace('/^\s*(namespace.*);/im', '${1} {', $pretty, 1)."\n}\n";
        } else {
            $pretty = sprintf("namespace {\n%s\n}\n", $pretty);
        }

        return self::pregReplace('/(?<!.)[\r\n]+/', '', $pretty);
    }

    /**
     * Check parsed code for having namespaces.
     *
     * @param \PhpParser\Node\Stmt[] $parsed
     *
     * @return bool
     */
    private static function parsedCodeHasNamespaces(array $parsed)
    {
        // Namespaces can only be on first level in the code,
        // so we make only check on it.
        foreach ($parsed as $node) {
            if ($node instanceof NamespaceNode) {
                return true;
            }
        }

        return false;
    }
}
