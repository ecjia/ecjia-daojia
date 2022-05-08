<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Finder;

<<<<<<< HEAD
use Symfony\Component\Finder\Adapter\AdapterInterface;
use Symfony\Component\Finder\Adapter\GnuFindAdapter;
use Symfony\Component\Finder\Adapter\BsdFindAdapter;
use Symfony\Component\Finder\Adapter\PhpAdapter;
use Symfony\Component\Finder\Comparator\DateComparator;
use Symfony\Component\Finder\Comparator\NumberComparator;
use Symfony\Component\Finder\Exception\ExceptionInterface;
=======
use Symfony\Component\Finder\Comparator\DateComparator;
use Symfony\Component\Finder\Comparator\NumberComparator;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
>>>>>>> v2-test
use Symfony\Component\Finder\Iterator\CustomFilterIterator;
use Symfony\Component\Finder\Iterator\DateRangeFilterIterator;
use Symfony\Component\Finder\Iterator\DepthRangeFilterIterator;
use Symfony\Component\Finder\Iterator\ExcludeDirectoryFilterIterator;
use Symfony\Component\Finder\Iterator\FilecontentFilterIterator;
use Symfony\Component\Finder\Iterator\FilenameFilterIterator;
use Symfony\Component\Finder\Iterator\SizeRangeFilterIterator;
use Symfony\Component\Finder\Iterator\SortableIterator;

/**
 * Finder allows to build rules to find files and directories.
 *
 * It is a thin wrapper around several specialized iterator classes.
 *
 * All rules may be invoked several times.
 *
<<<<<<< HEAD
 * All methods return the current Finder object to allow easy chaining:
 *
 * $finder = Finder::create()->files()->name('*.php')->in(__DIR__);
=======
 * All methods return the current Finder object to allow chaining:
 *
 *     $finder = Finder::create()->files()->name('*.php')->in(__DIR__);
>>>>>>> v2-test
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Finder implements \IteratorAggregate, \Countable
{
<<<<<<< HEAD
    const IGNORE_VCS_FILES = 1;
    const IGNORE_DOT_FILES = 2;

    private $mode = 0;
    private $names = array();
    private $notNames = array();
    private $exclude = array();
    private $filters = array();
    private $depths = array();
    private $sizes = array();
    private $followLinks = false;
    private $sort = false;
    private $ignore = 0;
    private $dirs = array();
    private $dates = array();
    private $iterators = array();
    private $contains = array();
    private $notContains = array();
    private $adapters = array();
    private $paths = array();
    private $notPaths = array();
    private $ignoreUnreadableDirs = false;

    private static $vcsPatterns = array('.svn', '_svn', 'CVS', '_darcs', '.arch-params', '.monotone', '.bzr', '.git', '.hg');

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->ignore = static::IGNORE_VCS_FILES | static::IGNORE_DOT_FILES;

        $this
            ->addAdapter(new GnuFindAdapter())
            ->addAdapter(new BsdFindAdapter())
            ->addAdapter(new PhpAdapter(), -50)
            ->setAdapter('php')
        ;
=======
    public const IGNORE_VCS_FILES = 1;
    public const IGNORE_DOT_FILES = 2;
    public const IGNORE_VCS_IGNORED_FILES = 4;

    private $mode = 0;
    private $names = [];
    private $notNames = [];
    private $exclude = [];
    private $filters = [];
    private $depths = [];
    private $sizes = [];
    private $followLinks = false;
    private $reverseSorting = false;
    private $sort = false;
    private $ignore = 0;
    private $dirs = [];
    private $dates = [];
    private $iterators = [];
    private $contains = [];
    private $notContains = [];
    private $paths = [];
    private $notPaths = [];
    private $ignoreUnreadableDirs = false;

    private static $vcsPatterns = ['.svn', '_svn', 'CVS', '_darcs', '.arch-params', '.monotone', '.bzr', '.git', '.hg'];

    public function __construct()
    {
        $this->ignore = static::IGNORE_VCS_FILES | static::IGNORE_DOT_FILES;
>>>>>>> v2-test
    }

    /**
     * Creates a new Finder.
     *
<<<<<<< HEAD
     * @return Finder A new Finder instance
=======
     * @return static
>>>>>>> v2-test
     */
    public static function create()
    {
        return new static();
    }

    /**
<<<<<<< HEAD
     * Registers a finder engine implementation.
     *
     * @param AdapterInterface $adapter  An adapter instance
     * @param int              $priority Highest is selected first
     *
     * @return Finder The current Finder instance
     */
    public function addAdapter(AdapterInterface $adapter, $priority = 0)
    {
        $this->adapters[$adapter->getName()] = array(
            'adapter' => $adapter,
            'priority' => $priority,
            'selected' => false,
        );

        return $this->sortAdapters();
    }

    /**
     * Sets the selected adapter to the best one according to the current platform the code is run on.
     *
     * @return Finder The current Finder instance
     */
    public function useBestAdapter()
    {
        $this->resetAdapterSelection();

        return $this->sortAdapters();
    }

    /**
     * Selects the adapter to use.
     *
     * @param string $name
     *
     * @return Finder The current Finder instance
     *
     * @throws \InvalidArgumentException
     */
    public function setAdapter($name)
    {
        if (!isset($this->adapters[$name])) {
            throw new \InvalidArgumentException(sprintf('Adapter "%s" does not exist.', $name));
        }

        $this->resetAdapterSelection();
        $this->adapters[$name]['selected'] = true;

        return $this->sortAdapters();
    }

    /**
     * Removes all adapters registered in the finder.
     *
     * @return Finder The current Finder instance
     */
    public function removeAdapters()
    {
        $this->adapters = array();

        return $this;
    }

    /**
     * Returns registered adapters ordered by priority without extra information.
     *
     * @return AdapterInterface[]
     */
    public function getAdapters()
    {
        return array_values(array_map(function (array $adapter) {
            return $adapter['adapter'];
        }, $this->adapters));
    }

    /**
     * Restricts the matching to directories only.
     *
     * @return Finder|SplFileInfo[] The current Finder instance
=======
     * Restricts the matching to directories only.
     *
     * @return $this
>>>>>>> v2-test
     */
    public function directories()
    {
        $this->mode = Iterator\FileTypeFilterIterator::ONLY_DIRECTORIES;

        return $this;
    }

    /**
     * Restricts the matching to files only.
     *
<<<<<<< HEAD
     * @return Finder|SplFileInfo[] The current Finder instance
=======
     * @return $this
>>>>>>> v2-test
     */
    public function files()
    {
        $this->mode = Iterator\FileTypeFilterIterator::ONLY_FILES;

        return $this;
    }

    /**
     * Adds tests for the directory depth.
     *
     * Usage:
     *
<<<<<<< HEAD
     *   $finder->depth('> 1') // the Finder will start matching at level 1.
     *   $finder->depth('< 3') // the Finder will descend at most 3 levels of directories below the starting point.
     *
     * @param int $level The depth level expression
     *
     * @return Finder|SplFileInfo[] The current Finder instance
=======
     *     $finder->depth('> 1') // the Finder will start matching at level 1.
     *     $finder->depth('< 3') // the Finder will descend at most 3 levels of directories below the starting point.
     *     $finder->depth(['>= 1', '< 3'])
     *
     * @param string|int|string[]|int[] $levels The depth level expression or an array of depth levels
     *
     * @return $this
>>>>>>> v2-test
     *
     * @see DepthRangeFilterIterator
     * @see NumberComparator
     */
<<<<<<< HEAD
    public function depth($level)
    {
        $this->depths[] = new Comparator\NumberComparator($level);
=======
    public function depth($levels)
    {
        foreach ((array) $levels as $level) {
            $this->depths[] = new Comparator\NumberComparator($level);
        }
>>>>>>> v2-test

        return $this;
    }

    /**
     * Adds tests for file dates (last modified).
     *
     * The date must be something that strtotime() is able to parse:
     *
<<<<<<< HEAD
     *   $finder->date('since yesterday');
     *   $finder->date('until 2 days ago');
     *   $finder->date('> now - 2 hours');
     *   $finder->date('>= 2005-10-15');
     *
     * @param string $date A date range string
     *
     * @return Finder|SplFileInfo[] The current Finder instance
=======
     *     $finder->date('since yesterday');
     *     $finder->date('until 2 days ago');
     *     $finder->date('> now - 2 hours');
     *     $finder->date('>= 2005-10-15');
     *     $finder->date(['>= 2005-10-15', '<= 2006-05-27']);
     *
     * @param string|string[] $dates A date range string or an array of date ranges
     *
     * @return $this
>>>>>>> v2-test
     *
     * @see strtotime
     * @see DateRangeFilterIterator
     * @see DateComparator
     */
<<<<<<< HEAD
    public function date($date)
    {
        $this->dates[] = new Comparator\DateComparator($date);
=======
    public function date($dates)
    {
        foreach ((array) $dates as $date) {
            $this->dates[] = new Comparator\DateComparator($date);
        }
>>>>>>> v2-test

        return $this;
    }

    /**
     * Adds rules that files must match.
     *
     * You can use patterns (delimited with / sign), globs or simple strings.
     *
<<<<<<< HEAD
     * $finder->name('*.php')
     * $finder->name('/\.php$/') // same as above
     * $finder->name('test.php')
     *
     * @param string $pattern A pattern (a regexp, a glob, or a string)
     *
     * @return Finder|SplFileInfo[] The current Finder instance
     *
     * @see FilenameFilterIterator
     */
    public function name($pattern)
    {
        $this->names[] = $pattern;
=======
     *     $finder->name('*.php')
     *     $finder->name('/\.php$/') // same as above
     *     $finder->name('test.php')
     *     $finder->name(['test.py', 'test.php'])
     *
     * @param string|string[] $patterns A pattern (a regexp, a glob, or a string) or an array of patterns
     *
     * @return $this
     *
     * @see FilenameFilterIterator
     */
    public function name($patterns)
    {
        $this->names = array_merge($this->names, (array) $patterns);
>>>>>>> v2-test

        return $this;
    }

    /**
     * Adds rules that files must not match.
     *
<<<<<<< HEAD
     * @param string $pattern A pattern (a regexp, a glob, or a string)
     *
     * @return Finder|SplFileInfo[] The current Finder instance
     *
     * @see FilenameFilterIterator
     */
    public function notName($pattern)
    {
        $this->notNames[] = $pattern;
=======
     * @param string|string[] $patterns A pattern (a regexp, a glob, or a string) or an array of patterns
     *
     * @return $this
     *
     * @see FilenameFilterIterator
     */
    public function notName($patterns)
    {
        $this->notNames = array_merge($this->notNames, (array) $patterns);
>>>>>>> v2-test

        return $this;
    }

    /**
     * Adds tests that file contents must match.
     *
     * Strings or PCRE patterns can be used:
     *
<<<<<<< HEAD
     * $finder->contains('Lorem ipsum')
     * $finder->contains('/Lorem ipsum/i')
     *
     * @param string $pattern A pattern (string or regexp)
     *
     * @return Finder|SplFileInfo[] The current Finder instance
     *
     * @see FilecontentFilterIterator
     */
    public function contains($pattern)
    {
        $this->contains[] = $pattern;
=======
     *     $finder->contains('Lorem ipsum')
     *     $finder->contains('/Lorem ipsum/i')
     *     $finder->contains(['dolor', '/ipsum/i'])
     *
     * @param string|string[] $patterns A pattern (string or regexp) or an array of patterns
     *
     * @return $this
     *
     * @see FilecontentFilterIterator
     */
    public function contains($patterns)
    {
        $this->contains = array_merge($this->contains, (array) $patterns);
>>>>>>> v2-test

        return $this;
    }

    /**
     * Adds tests that file contents must not match.
     *
     * Strings or PCRE patterns can be used:
     *
<<<<<<< HEAD
     * $finder->notContains('Lorem ipsum')
     * $finder->notContains('/Lorem ipsum/i')
     *
     * @param string $pattern A pattern (string or regexp)
     *
     * @return Finder|SplFileInfo[] The current Finder instance
     *
     * @see FilecontentFilterIterator
     */
    public function notContains($pattern)
    {
        $this->notContains[] = $pattern;
=======
     *     $finder->notContains('Lorem ipsum')
     *     $finder->notContains('/Lorem ipsum/i')
     *     $finder->notContains(['lorem', '/dolor/i'])
     *
     * @param string|string[] $patterns A pattern (string or regexp) or an array of patterns
     *
     * @return $this
     *
     * @see FilecontentFilterIterator
     */
    public function notContains($patterns)
    {
        $this->notContains = array_merge($this->notContains, (array) $patterns);
>>>>>>> v2-test

        return $this;
    }

    /**
     * Adds rules that filenames must match.
     *
     * You can use patterns (delimited with / sign) or simple strings.
     *
<<<<<<< HEAD
     * $finder->path('some/special/dir')
     * $finder->path('/some\/special\/dir/') // same as above
     *
     * Use only / as dirname separator.
     *
     * @param string $pattern A pattern (a regexp or a string)
     *
     * @return Finder|SplFileInfo[] The current Finder instance
     *
     * @see FilenameFilterIterator
     */
    public function path($pattern)
    {
        $this->paths[] = $pattern;
=======
     *     $finder->path('some/special/dir')
     *     $finder->path('/some\/special\/dir/') // same as above
     *     $finder->path(['some dir', 'another/dir'])
     *
     * Use only / as dirname separator.
     *
     * @param string|string[] $patterns A pattern (a regexp or a string) or an array of patterns
     *
     * @return $this
     *
     * @see FilenameFilterIterator
     */
    public function path($patterns)
    {
        $this->paths = array_merge($this->paths, (array) $patterns);
>>>>>>> v2-test

        return $this;
    }

    /**
     * Adds rules that filenames must not match.
     *
     * You can use patterns (delimited with / sign) or simple strings.
     *
<<<<<<< HEAD
     * $finder->notPath('some/special/dir')
     * $finder->notPath('/some\/special\/dir/') // same as above
     *
     * Use only / as dirname separator.
     *
     * @param string $pattern A pattern (a regexp or a string)
     *
     * @return Finder|SplFileInfo[] The current Finder instance
     *
     * @see FilenameFilterIterator
     */
    public function notPath($pattern)
    {
        $this->notPaths[] = $pattern;
=======
     *     $finder->notPath('some/special/dir')
     *     $finder->notPath('/some\/special\/dir/') // same as above
     *     $finder->notPath(['some/file.txt', 'another/file.log'])
     *
     * Use only / as dirname separator.
     *
     * @param string|string[] $patterns A pattern (a regexp or a string) or an array of patterns
     *
     * @return $this
     *
     * @see FilenameFilterIterator
     */
    public function notPath($patterns)
    {
        $this->notPaths = array_merge($this->notPaths, (array) $patterns);
>>>>>>> v2-test

        return $this;
    }

    /**
     * Adds tests for file sizes.
     *
<<<<<<< HEAD
     * $finder->size('> 10K');
     * $finder->size('<= 1Ki');
     * $finder->size(4);
     *
     * @param string $size A size range string
     *
     * @return Finder|SplFileInfo[] The current Finder instance
=======
     *     $finder->size('> 10K');
     *     $finder->size('<= 1Ki');
     *     $finder->size(4);
     *     $finder->size(['> 10K', '< 20K'])
     *
     * @param string|int|string[]|int[] $sizes A size range string or an integer or an array of size ranges
     *
     * @return $this
>>>>>>> v2-test
     *
     * @see SizeRangeFilterIterator
     * @see NumberComparator
     */
<<<<<<< HEAD
    public function size($size)
    {
        $this->sizes[] = new Comparator\NumberComparator($size);
=======
    public function size($sizes)
    {
        foreach ((array) $sizes as $size) {
            $this->sizes[] = new Comparator\NumberComparator($size);
        }
>>>>>>> v2-test

        return $this;
    }

    /**
     * Excludes directories.
     *
<<<<<<< HEAD
     * @param string|array $dirs A directory path or an array of directories
     *
     * @return Finder|SplFileInfo[] The current Finder instance
=======
     * Directories passed as argument must be relative to the ones defined with the `in()` method. For example:
     *
     *     $finder->in(__DIR__)->exclude('ruby');
     *
     * @param string|array $dirs A directory path or an array of directories
     *
     * @return $this
>>>>>>> v2-test
     *
     * @see ExcludeDirectoryFilterIterator
     */
    public function exclude($dirs)
    {
        $this->exclude = array_merge($this->exclude, (array) $dirs);

        return $this;
    }

    /**
     * Excludes "hidden" directories and files (starting with a dot).
     *
<<<<<<< HEAD
     * @param bool $ignoreDotFiles Whether to exclude "hidden" files or not
     *
     * @return Finder|SplFileInfo[] The current Finder instance
     *
     * @see ExcludeDirectoryFilterIterator
     */
    public function ignoreDotFiles($ignoreDotFiles)
=======
     * This option is enabled by default.
     *
     * @return $this
     *
     * @see ExcludeDirectoryFilterIterator
     */
    public function ignoreDotFiles(bool $ignoreDotFiles)
>>>>>>> v2-test
    {
        if ($ignoreDotFiles) {
            $this->ignore |= static::IGNORE_DOT_FILES;
        } else {
            $this->ignore &= ~static::IGNORE_DOT_FILES;
        }

        return $this;
    }

    /**
     * Forces the finder to ignore version control directories.
     *
<<<<<<< HEAD
     * @param bool $ignoreVCS Whether to exclude VCS files or not
     *
     * @return Finder|SplFileInfo[] The current Finder instance
     *
     * @see ExcludeDirectoryFilterIterator
     */
    public function ignoreVCS($ignoreVCS)
=======
     * This option is enabled by default.
     *
     * @return $this
     *
     * @see ExcludeDirectoryFilterIterator
     */
    public function ignoreVCS(bool $ignoreVCS)
>>>>>>> v2-test
    {
        if ($ignoreVCS) {
            $this->ignore |= static::IGNORE_VCS_FILES;
        } else {
            $this->ignore &= ~static::IGNORE_VCS_FILES;
        }

        return $this;
    }

    /**
<<<<<<< HEAD
=======
     * Forces Finder to obey .gitignore and ignore files based on rules listed there.
     *
     * This option is disabled by default.
     *
     * @return $this
     */
    public function ignoreVCSIgnored(bool $ignoreVCSIgnored)
    {
        if ($ignoreVCSIgnored) {
            $this->ignore |= static::IGNORE_VCS_IGNORED_FILES;
        } else {
            $this->ignore &= ~static::IGNORE_VCS_IGNORED_FILES;
        }

        return $this;
    }

    /**
>>>>>>> v2-test
     * Adds VCS patterns.
     *
     * @see ignoreVCS()
     *
     * @param string|string[] $pattern VCS patterns to ignore
     */
    public static function addVCSPattern($pattern)
    {
        foreach ((array) $pattern as $p) {
            self::$vcsPatterns[] = $p;
        }

        self::$vcsPatterns = array_unique(self::$vcsPatterns);
    }

    /**
     * Sorts files and directories by an anonymous function.
     *
     * The anonymous function receives two \SplFileInfo instances to compare.
     *
     * This can be slow as all the matching files and directories must be retrieved for comparison.
     *
<<<<<<< HEAD
     * @param \Closure $closure An anonymous function
     *
     * @return Finder|SplFileInfo[] The current Finder instance
=======
     * @return $this
>>>>>>> v2-test
     *
     * @see SortableIterator
     */
    public function sort(\Closure $closure)
    {
        $this->sort = $closure;

        return $this;
    }

    /**
     * Sorts files and directories by name.
     *
     * This can be slow as all the matching files and directories must be retrieved for comparison.
     *
<<<<<<< HEAD
     * @return Finder|SplFileInfo[] The current Finder instance
     *
     * @see SortableIterator
     */
    public function sortByName()
    {
        $this->sort = Iterator\SortableIterator::SORT_BY_NAME;
=======
     * @return $this
     *
     * @see SortableIterator
     */
    public function sortByName(bool $useNaturalSort = false)
    {
        $this->sort = $useNaturalSort ? Iterator\SortableIterator::SORT_BY_NAME_NATURAL : Iterator\SortableIterator::SORT_BY_NAME;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Sorts files and directories by type (directories before files), then by name.
     *
     * This can be slow as all the matching files and directories must be retrieved for comparison.
     *
<<<<<<< HEAD
     * @return Finder|SplFileInfo[] The current Finder instance
=======
     * @return $this
>>>>>>> v2-test
     *
     * @see SortableIterator
     */
    public function sortByType()
    {
        $this->sort = Iterator\SortableIterator::SORT_BY_TYPE;

        return $this;
    }

    /**
     * Sorts files and directories by the last accessed time.
     *
     * This is the time that the file was last accessed, read or written to.
     *
     * This can be slow as all the matching files and directories must be retrieved for comparison.
     *
<<<<<<< HEAD
     * @return Finder|SplFileInfo[] The current Finder instance
=======
     * @return $this
>>>>>>> v2-test
     *
     * @see SortableIterator
     */
    public function sortByAccessedTime()
    {
        $this->sort = Iterator\SortableIterator::SORT_BY_ACCESSED_TIME;

        return $this;
    }

    /**
<<<<<<< HEAD
=======
     * Reverses the sorting.
     *
     * @return $this
     */
    public function reverseSorting()
    {
        $this->reverseSorting = true;

        return $this;
    }

    /**
>>>>>>> v2-test
     * Sorts files and directories by the last inode changed time.
     *
     * This is the time that the inode information was last modified (permissions, owner, group or other metadata).
     *
     * On Windows, since inode is not available, changed time is actually the file creation time.
     *
     * This can be slow as all the matching files and directories must be retrieved for comparison.
     *
<<<<<<< HEAD
     * @return Finder|SplFileInfo[] The current Finder instance
=======
     * @return $this
>>>>>>> v2-test
     *
     * @see SortableIterator
     */
    public function sortByChangedTime()
    {
        $this->sort = Iterator\SortableIterator::SORT_BY_CHANGED_TIME;

        return $this;
    }

    /**
     * Sorts files and directories by the last modified time.
     *
     * This is the last time the actual contents of the file were last modified.
     *
     * This can be slow as all the matching files and directories must be retrieved for comparison.
     *
<<<<<<< HEAD
     * @return Finder|SplFileInfo[] The current Finder instance
=======
     * @return $this
>>>>>>> v2-test
     *
     * @see SortableIterator
     */
    public function sortByModifiedTime()
    {
        $this->sort = Iterator\SortableIterator::SORT_BY_MODIFIED_TIME;

        return $this;
    }

    /**
     * Filters the iterator with an anonymous function.
     *
     * The anonymous function receives a \SplFileInfo and must return false
     * to remove files.
     *
<<<<<<< HEAD
     * @param \Closure $closure An anonymous function
     *
     * @return Finder|SplFileInfo[] The current Finder instance
=======
     * @return $this
>>>>>>> v2-test
     *
     * @see CustomFilterIterator
     */
    public function filter(\Closure $closure)
    {
        $this->filters[] = $closure;

        return $this;
    }

    /**
     * Forces the following of symlinks.
     *
<<<<<<< HEAD
     * @return Finder|SplFileInfo[] The current Finder instance
=======
     * @return $this
>>>>>>> v2-test
     */
    public function followLinks()
    {
        $this->followLinks = true;

        return $this;
    }

    /**
     * Tells finder to ignore unreadable directories.
     *
     * By default, scanning unreadable directories content throws an AccessDeniedException.
     *
<<<<<<< HEAD
     * @param bool $ignore
     *
     * @return Finder|SplFileInfo[] The current Finder instance
     */
    public function ignoreUnreadableDirs($ignore = true)
    {
        $this->ignoreUnreadableDirs = (bool) $ignore;
=======
     * @return $this
     */
    public function ignoreUnreadableDirs(bool $ignore = true)
    {
        $this->ignoreUnreadableDirs = $ignore;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Searches files and directories which match defined rules.
     *
<<<<<<< HEAD
     * @param string|array $dirs A directory path or an array of directories
     *
     * @return Finder|SplFileInfo[] The current Finder instance
     *
     * @throws \InvalidArgumentException if one of the directories does not exist
     */
    public function in($dirs)
    {
        $resolvedDirs = array();

        foreach ((array) $dirs as $dir) {
            if (is_dir($dir)) {
                $resolvedDirs[] = $dir;
            } elseif ($glob = glob($dir, (defined('GLOB_BRACE') ? GLOB_BRACE : 0) | GLOB_ONLYDIR)) {
                $resolvedDirs = array_merge($resolvedDirs, $glob);
            } else {
                throw new \InvalidArgumentException(sprintf('The "%s" directory does not exist.', $dir));
=======
     * @param string|string[] $dirs A directory path or an array of directories
     *
     * @return $this
     *
     * @throws DirectoryNotFoundException if one of the directories does not exist
     */
    public function in($dirs)
    {
        $resolvedDirs = [];

        foreach ((array) $dirs as $dir) {
            if (is_dir($dir)) {
                $resolvedDirs[] = $this->normalizeDir($dir);
            } elseif ($glob = glob($dir, (\defined('GLOB_BRACE') ? \GLOB_BRACE : 0) | \GLOB_ONLYDIR | \GLOB_NOSORT)) {
                sort($glob);
                $resolvedDirs = array_merge($resolvedDirs, array_map([$this, 'normalizeDir'], $glob));
            } else {
                throw new DirectoryNotFoundException(sprintf('The "%s" directory does not exist.', $dir));
>>>>>>> v2-test
            }
        }

        $this->dirs = array_merge($this->dirs, $resolvedDirs);

        return $this;
    }

    /**
     * Returns an Iterator for the current Finder configuration.
     *
     * This method implements the IteratorAggregate interface.
     *
     * @return \Iterator|SplFileInfo[] An iterator
     *
     * @throws \LogicException if the in() method has not been called
     */
    public function getIterator()
    {
<<<<<<< HEAD
        if (0 === count($this->dirs) && 0 === count($this->iterators)) {
            throw new \LogicException('You must call one of in() or append() methods before iterating over a Finder.');
        }

        if (1 === count($this->dirs) && 0 === count($this->iterators)) {
            return $this->searchInDirectory($this->dirs[0]);
=======
        if (0 === \count($this->dirs) && 0 === \count($this->iterators)) {
            throw new \LogicException('You must call one of in() or append() methods before iterating over a Finder.');
        }

        if (1 === \count($this->dirs) && 0 === \count($this->iterators)) {
            $iterator = $this->searchInDirectory($this->dirs[0]);

            if ($this->sort || $this->reverseSorting) {
                $iterator = (new Iterator\SortableIterator($iterator, $this->sort, $this->reverseSorting))->getIterator();
            }

            return $iterator;
>>>>>>> v2-test
        }

        $iterator = new \AppendIterator();
        foreach ($this->dirs as $dir) {
            $iterator->append($this->searchInDirectory($dir));
        }

        foreach ($this->iterators as $it) {
            $iterator->append($it);
        }

<<<<<<< HEAD
=======
        if ($this->sort || $this->reverseSorting) {
            $iterator = (new Iterator\SortableIterator($iterator, $this->sort, $this->reverseSorting))->getIterator();
        }

>>>>>>> v2-test
        return $iterator;
    }

    /**
     * Appends an existing set of files/directories to the finder.
     *
     * The set can be another Finder, an Iterator, an IteratorAggregate, or even a plain array.
     *
<<<<<<< HEAD
     * @param mixed $iterator
     *
     * @return Finder|SplFileInfo[] The finder
     *
     * @throws \InvalidArgumentException When the given argument is not iterable.
     */
    public function append($iterator)
=======
     * @return $this
     *
     * @throws \InvalidArgumentException when the given argument is not iterable
     */
    public function append(iterable $iterator)
>>>>>>> v2-test
    {
        if ($iterator instanceof \IteratorAggregate) {
            $this->iterators[] = $iterator->getIterator();
        } elseif ($iterator instanceof \Iterator) {
            $this->iterators[] = $iterator;
<<<<<<< HEAD
        } elseif ($iterator instanceof \Traversable || is_array($iterator)) {
=======
        } elseif ($iterator instanceof \Traversable || \is_array($iterator)) {
>>>>>>> v2-test
            $it = new \ArrayIterator();
            foreach ($iterator as $file) {
                $it->append($file instanceof \SplFileInfo ? $file : new \SplFileInfo($file));
            }
            $this->iterators[] = $it;
        } else {
            throw new \InvalidArgumentException('Finder::append() method wrong argument type.');
        }

        return $this;
    }

    /**
<<<<<<< HEAD
     * Counts all the results collected by the iterators.
     *
     * @return int
     */
    public function count()
    {
        return iterator_count($this->getIterator());
    }

    /**
     * @return Finder The current Finder instance
     */
    private function sortAdapters()
    {
        uasort($this->adapters, function (array $a, array $b) {
            if ($a['selected'] || $b['selected']) {
                return $a['selected'] ? -1 : 1;
            }

            return $a['priority'] > $b['priority'] ? -1 : 1;
        });

        return $this;
    }

    /**
     * @param $dir
     *
     * @return \Iterator
     *
     * @throws \RuntimeException When none of the adapters are supported
     */
    private function searchInDirectory($dir)
    {
        if (static::IGNORE_VCS_FILES === (static::IGNORE_VCS_FILES & $this->ignore)) {
            $this->exclude = array_merge($this->exclude, self::$vcsPatterns);
        }

        if (static::IGNORE_DOT_FILES === (static::IGNORE_DOT_FILES & $this->ignore)) {
            $this->notPaths[] = '#(^|/)\..+(/|$)#';
        }

        foreach ($this->adapters as $adapter) {
            if ($adapter['adapter']->isSupported()) {
                try {
                    return $this
                        ->buildAdapter($adapter['adapter'])
                        ->searchInDirectory($dir);
                } catch (ExceptionInterface $e) {
                }
            }
        }

        throw new \RuntimeException('No supported adapter found.');
    }

    /**
     * @param AdapterInterface $adapter
     *
     * @return AdapterInterface
     */
    private function buildAdapter(AdapterInterface $adapter)
    {
        return $adapter
            ->setFollowLinks($this->followLinks)
            ->setDepths($this->depths)
            ->setMode($this->mode)
            ->setExclude($this->exclude)
            ->setNames($this->names)
            ->setNotNames($this->notNames)
            ->setContains($this->contains)
            ->setNotContains($this->notContains)
            ->setSizes($this->sizes)
            ->setDates($this->dates)
            ->setFilters($this->filters)
            ->setSort($this->sort)
            ->setPath($this->paths)
            ->setNotPath($this->notPaths)
            ->ignoreUnreadableDirs($this->ignoreUnreadableDirs);
    }

    /**
     * Unselects all adapters.
     */
    private function resetAdapterSelection()
    {
        $this->adapters = array_map(function (array $properties) {
            $properties['selected'] = false;

            return $properties;
        }, $this->adapters);
=======
     * Check if any results were found.
     *
     * @return bool
     */
    public function hasResults()
    {
        foreach ($this->getIterator() as $_) {
            return true;
        }

        return false;
    }

    /**
     * Counts all the results collected by the iterators.
     *
     * @return int
     */
    public function count()
    {
        return iterator_count($this->getIterator());
    }

    private function searchInDirectory(string $dir): \Iterator
    {
        $exclude = $this->exclude;
        $notPaths = $this->notPaths;

        if (static::IGNORE_VCS_FILES === (static::IGNORE_VCS_FILES & $this->ignore)) {
            $exclude = array_merge($exclude, self::$vcsPatterns);
        }

        if (static::IGNORE_DOT_FILES === (static::IGNORE_DOT_FILES & $this->ignore)) {
            $notPaths[] = '#(^|/)\..+(/|$)#';
        }

        if (static::IGNORE_VCS_IGNORED_FILES === (static::IGNORE_VCS_IGNORED_FILES & $this->ignore)) {
            $gitignoreFilePath = sprintf('%s/.gitignore', $dir);
            if (!is_readable($gitignoreFilePath)) {
                throw new \RuntimeException(sprintf('The "ignoreVCSIgnored" option cannot be used by the Finder as the "%s" file is not readable.', $gitignoreFilePath));
            }
            $notPaths = array_merge($notPaths, [Gitignore::toRegex(file_get_contents($gitignoreFilePath))]);
        }

        $minDepth = 0;
        $maxDepth = \PHP_INT_MAX;

        foreach ($this->depths as $comparator) {
            switch ($comparator->getOperator()) {
                case '>':
                    $minDepth = $comparator->getTarget() + 1;
                    break;
                case '>=':
                    $minDepth = $comparator->getTarget();
                    break;
                case '<':
                    $maxDepth = $comparator->getTarget() - 1;
                    break;
                case '<=':
                    $maxDepth = $comparator->getTarget();
                    break;
                default:
                    $minDepth = $maxDepth = $comparator->getTarget();
            }
        }

        $flags = \RecursiveDirectoryIterator::SKIP_DOTS;

        if ($this->followLinks) {
            $flags |= \RecursiveDirectoryIterator::FOLLOW_SYMLINKS;
        }

        $iterator = new Iterator\RecursiveDirectoryIterator($dir, $flags, $this->ignoreUnreadableDirs);

        if ($exclude) {
            $iterator = new Iterator\ExcludeDirectoryFilterIterator($iterator, $exclude);
        }

        $iterator = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::SELF_FIRST);

        if ($minDepth > 0 || $maxDepth < \PHP_INT_MAX) {
            $iterator = new Iterator\DepthRangeFilterIterator($iterator, $minDepth, $maxDepth);
        }

        if ($this->mode) {
            $iterator = new Iterator\FileTypeFilterIterator($iterator, $this->mode);
        }

        if ($this->names || $this->notNames) {
            $iterator = new Iterator\FilenameFilterIterator($iterator, $this->names, $this->notNames);
        }

        if ($this->contains || $this->notContains) {
            $iterator = new Iterator\FilecontentFilterIterator($iterator, $this->contains, $this->notContains);
        }

        if ($this->sizes) {
            $iterator = new Iterator\SizeRangeFilterIterator($iterator, $this->sizes);
        }

        if ($this->dates) {
            $iterator = new Iterator\DateRangeFilterIterator($iterator, $this->dates);
        }

        if ($this->filters) {
            $iterator = new Iterator\CustomFilterIterator($iterator, $this->filters);
        }

        if ($this->paths || $notPaths) {
            $iterator = new Iterator\PathFilterIterator($iterator, $this->paths, $notPaths);
        }

        return $iterator;
    }

    /**
     * Normalizes given directory names by removing trailing slashes.
     *
     * Excluding: (s)ftp:// or ssh2.(s)ftp:// wrapper
     */
    private function normalizeDir(string $dir): string
    {
        if ('/' === $dir) {
            return $dir;
        }

        $dir = rtrim($dir, '/'.\DIRECTORY_SEPARATOR);

        if (preg_match('#^(ssh2\.)?s?ftp://#', $dir)) {
            $dir .= '/';
        }

        return $dir;
>>>>>>> v2-test
    }
}
