<?php


namespace Royalcms\Component\Preloader;

use ClassPreloader\Exceptions\DirConstantException;
use ClassPreloader\Exceptions\FileConstantException;
use ClassPreloader\Exceptions\StrictTypesException;
use ClassPreloader\Parser\DirVisitor;
use ClassPreloader\Parser\FileVisitor;
use ClassPreloader\Parser\NodeTraverser;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Namespace_ as NamespaceNode;
use PhpParser\ParserFactory;
use PhpParser\Parser;
use Royalcms\Component\Foundation\Composer;
use Royalcms\Component\Foundation\Royalcms;
use Royalcms\Component\Support\Facades\Log;
use Royalcms\Component\Preloader\MyStandard as PrettyPrinter;

class ClassPreloader
{

    /**
     * The printer.
     *
     * @var \PhpParser\PrettyPrinter\Standard
     */
    protected $printer;

    /**
     * The parser.
     *
     * @var \PhpParser\Parser
     */
    protected $parser;

    /**
     * The traverser.
     *
     * @var \ClassPreloader\Parser\NodeTraverser
     */
    protected $traverser;

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
     * Prepare the output file and directory.
     *
     * @param string $output
     * @param bool   $strict
     *
     * @throws \RuntimeException
     *
     * @return resource
     */
    public function prepareOutput($output, $strict = false)
    {
        if ($strict && version_compare(PHP_VERSION, '7') < 1) {
            throw new RuntimeException('Strict mode requires PHP 7 or greater.');
        }

        $dir = dirname($output);

        if (!is_dir($dir) && !mkdir($dir, 0777, true)) {
            throw new RuntimeException("Unable to create directory $dir.");
        }

        $handle = fopen($output, 'w');

        if (!$handle) {
            throw new RuntimeException("Unable to open $output for writing.");
        }

        if ($strict) {
            fwrite($handle, "<?php declare(strict_types=1);\n");
        } else {
            fwrite($handle, "<?php\n");
        }

        return $handle;
    }

    /**
     * Get a pretty printed string of code from a file while applying visitors.
     *
     * @param string $file
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    public function getCode($file, $comments = true)
    {
        if (!is_string($file) || empty($file)) {
            throw new RuntimeException('Invalid filename provided.');
        }

        if (!is_readable($file)) {
            throw new RuntimeException("Cannot open $file for reading.");
        }

        if ($comments) {
            $content = file_get_contents($file);
        } else {
            $content = php_strip_whitespace($file);
        }

        $parsed = $this->parser->parse($content);
        $stmts = $this->traverser->traverseFile($parsed, $file);
        $pretty = $this->printer->prettyPrint($stmts);

        $pretty = preg_replace(
            '#^(<\?php)?[\s]*(/\*\*?.*?\*/)?[\s]*(declare[\s]*\([\s]*strict_types[\s]*=[\s]*1[\s]*\);)?#s',
            '',
            $pretty
        );

        return $this->getCodeWrappedIntoNamespace($parsed, $pretty);
    }

    /**
     * Check parsed code for having namespaces.
     *
     * @param array $parsed
     *
     * @return bool
     */
    protected function parsedCodeHasNamespaces(array $parsed)
    {
        // Namespaces can only be on first level in the code,
        // so we make only check on it.
        $node = array_filter(
            $parsed,
            function ($value) {
                return $value instanceof NamespaceNode;
            }
        );

        return !empty($node);
    }

    /**
     * Wrap the code into a namespace.
     *
     * @param array  $parsed
     * @param string $pretty
     *
     * @return string
     */
    protected function getCodeWrappedIntoNamespace(array $parsed, $pretty)
    {
        if ($this->parsedCodeHasNamespaces($parsed)) {
            $pretty = preg_replace('/^\s*(namespace.*);/im', '${1} {', $pretty, 1)."\n}\n";
        } else {
            $pretty = sprintf("namespace {\n%s\n}\n", $pretty);
        }

        return preg_replace('/(?<!.)[\r\n]+/', '', $pretty);
    }

    /**
     * @param $file
     * @return string
     */
    protected function getFileClassName($file)
    {
        $namespaces = $this->parseFile($file);

        if (empty($namespaces)) {
            return null;
        }

        $namespace = $namespaces[0][0];
        $namespaceName = $namespace->name->toString();

        $stmts = $namespace->stmts;

        $class = null;

        foreach ($stmts as $stmt) {
            if ($stmt instanceof \PhpParser\Node\Stmt\Interface_) {
                $class = $stmt;
                break;
            }
            elseif ($stmt instanceof \PhpParser\Node\Stmt\Class_) {
                $class = $stmt;
                break;
            }
        }

        $fullClassName = null;

        if ($class) {
            $className = $class->name->toString();
            $fullClassName = $namespaceName . '\\' . $className;
        }

        return $fullClassName;
    }

    protected function parseFile($path)
    {
        $code = php_strip_whitespace($path);
        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        $ast = $parser->parse($code);
        if (! count($ast)) {
            throw new Exception('No PHP code found.');
        }
        $namespaces = $this->parsePHPSegments($ast);

        return $namespaces;
    }

    protected function parsePHPSegments($segments)
    {
        $segments = array_filter($segments, function ($segment) {
            return $segment instanceof Namespace_;
        });

        $segments = array_map(function (Namespace_ $segment) {
            return [$segment, $this->parseNamespace($segment)];
        }, $segments);

        return $segments;
    }

    protected function parseNamespace(Namespace_ $namespace)
    {
        $classes = array_values(array_filter($namespace->stmts, function ($class) {
            return $class instanceof Class_;
        }));

        return $classes;
    }


}