<?php 

namespace Royalcms\Component\Cache\Contracts;

interface Factory {

	/**
	 * Get a cache store instance by name.
	 *
	 * @param  string|null  $name
	 * @return mixed
	 */
	public function store($name = null);

}
