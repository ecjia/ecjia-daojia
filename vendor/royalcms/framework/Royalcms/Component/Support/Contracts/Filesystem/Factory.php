<?php namespace Royalcms\Component\Support\Contracts\Filesystem;

interface Factory {

	/**
	 * Get a filesystem implementation.
	 *
	 * @param  string  $name
	 * @return \Royalcms\Component\Support\Contracts\Filesystem\Filesystem
	 */
	public function disk($name = null);

}
