<?php namespace Royalcms\Component\Session;

use Symfony\Component\Finder\Finder;
use Royalcms\Component\Filesystem\Filesystem;

class FileSessionHandler implements \SessionHandlerInterface {

	/**
	 * The filesystem instance.
	 *
	 * @var \Royalcms\Component\Filesystem\Filesystem
	 */
	protected $files;

	/**
	 * The path where sessions should be stored.
	 *
	 * @var string
	 */
	protected $path;

	/**
	 * Create a new file driven handler instance.
	 *
	 * @param  \Royalcms\Component\Filesystem\Filesystem  $files
	 * @param  string  $path
	 * @return void
	 */
	public function __construct(Filesystem $files, $path)
	{
		$this->path = $path;
		$this->files = $files;
	}
	
	/**
	 * Create the file session directory if necessary.
	 *
	 * @param  string  $path
	 * @return void
	 */
	protected function createSessionDirectory($path)
	{
	    try
	    {
            if (! $this->files->isDirectory($path))
                $this->files->makeDirectory($path, 0777, true, true);
	    }
	    catch (\Exception $e)
	    {
	        //no throw
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function open($savePath, $sessionName)
	{
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function close()
	{
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function read($sessionId)
	{
		if ($this->files->exists($path = $this->path.'/'.$sessionId))
		{
			return $this->files->get($path);
		}
		else
		{
			return '';
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function write($sessionId, $data)
	{
        $this->createSessionDirectory($this->path);
	    
		$this->files->put($this->path.'/'.$sessionId, $data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function destroy($sessionId)
	{
		$this->files->delete($this->path.'/'.$sessionId);
	}

	/**
	 * {@inheritDoc}
	 */
	public function gc($lifetime)
	{
		$files = Finder::create()
					->in($this->path)
					->files()
					->ignoreDotFiles(true)
					->date('<= now - '.$lifetime.' seconds');

		foreach ($files as $file)
		{
			$this->files->delete($file->getRealPath());
		}
	}

}
