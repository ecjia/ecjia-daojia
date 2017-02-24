<?php namespace Royalcms\Component\SmartyView;

use Royalcms\Component\Filesystem\Filesystem;
use Royalcms\Component\View\FileViewFinder as ViewFileViewFinder;

class FileViewFinder extends ViewFileViewFinder {
	/**
	 * Register a view extension with the finder.
	 *
	 * @var array
	 */
	protected $extensions = array('php');

	/**
	 * Create a new file view loader instance.
	 *
	 * @param  \Royalcms\Component\Filesystem\Filesystem  $files
	 * @param  array  $paths
	 * @param  array  $extensions
	 * @return void
	 */
	public function __construct(Filesystem $files, array $paths, array $extensions = null)
	{
		$this->files = $files;
		$this->paths = $paths;

		if (isset($extensions))
		{
			$this->extensions = $extensions;
		}
	}

	/**
	 * Get the fully qualified location of the view.
	 *
	 * @param  string  $name
	 * @return string
	 */
	public function find($name)
	{
		if (isset($this->views[$name])) return $this->views[$name];

		if (strpos($name, '::') !== false)
		{
			return $this->views[$name] = $this->findNamedPathView($name);
		}

		return $this->views[$name] = $this->findInPaths($name, $this->paths);
	}

	/**
	 * Get the path to a template with a named path.
	 *
	 * @param  string  $name
	 * @return string
	 */
	protected function findNamedPathView($name)
	{
		list($namespace, $view) = $this->getNamespaceSegments($name);
        
		return $this->findInPaths($view, $this->hints[$namespace]);
	}

	/**
	 * Find the given view in the list of paths.
	 *
	 * @param  string  $name
	 * @param  array   $paths
	 * @return string
	 *
	 * @throws \InvalidArgumentException
	 */
	protected function findInPaths($name, $paths)
	{
		foreach ((array) $paths as $path)
		{
			foreach ($this->getPossibleViewFiles($name) as $file)
			{
			    $viewPath = $path.'/'.$file;
				if ($this->files->exists($viewPath))
				{
					return $viewPath;
				}
			}
		}

		throw new \InvalidArgumentException("View [$name] not found.");
	}

	/**
	 * Get an array of possible view files.
	 *
	 * @param  string  $name
	 * @return array
	 */
	protected function getPossibleViewFiles($name)
	{
		return array_map(function($extension) use ($name)
		{
			return $name.'.'.$extension;

		}, $this->extensions);
	}

}
