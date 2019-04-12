<?php

namespace Royalcms\Component\SmartyView;

use Royalcms\Component\View\FileViewFinder as ViewFileViewFinder;

class FileViewFinder extends ViewFileViewFinder
{
	/**
	 * Register a view extension with the finder.
	 *
	 * @var array
	 */
	protected $extensions = array('php');


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
			return $this->views[$name] = $this->findNamespacedView($name);
		}

		return $this->views[$name] = $this->findInPaths($name, $this->paths);
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

    /**
     * Flush the cache of located views.
     *
     * @return void
     */
    public function flush()
    {
        parent::flush();
    }

    /**
     * Replace the namespace hints for the given namespace.
     *
     * @param  string  $namespace
     * @param  string|array  $hints
     * @return void
     */
    public function replaceNamespace($namespace, $hints)
    {
        parent::replaceNamespace($namespace, $hints);
    }

}
