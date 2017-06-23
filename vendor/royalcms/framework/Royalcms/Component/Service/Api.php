<?php

namespace Royalcms\Component\Service;

use Royalcms\Component\Service\Contracts\InputInterface;

/**
 * API事件基类
 *
 * @subpackage core
 */

abstract class Api
{

    /**
     * The Royalcms application instance.
     *
     * @var \Royalcms\Component\Foundation\Royalcms
     */
    protected $royalcms;
    
    /**
     * The input interface implementation.
     *
     * @var \Royalcms\Component\Service\Contracts\InputInterface
     */
    protected $input;
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name;
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description;
    
    /**
     * API参数
     *
     * @var array $options
     */
    protected $options = array();

    /**
	 * Create a new console command instance.
	 *
	 * @return void
	 */
    public function __construct()
    {
        // We will go ahead and set the name, description, and parameters on console
		// commands just to make things a little easier on the developer. This is
		// so they don't have to all be manually specified in the constructors.
		$this->setDescription($this->description);

		$this->specifyParameters();
    }
    
    /**
     * Specify the arguments and options on the command.
     *
     * @return void
     */
    protected function specifyParameters()
    {
        // We will loop through all of the arguments and options for the command and
        // set them all on the base command instance. This specifies what can get
        // passed into these commands as "parameters" to control the execution.
        foreach ($this->getArguments() as $arguments)
        {
            call_user_func_array(array($this, 'addArgument'), $arguments);
        }
    
        foreach ($this->getOptions() as $options)
        {
            call_user_func_array(array($this, 'addOption'), $options);
        }
    }
    
    /**
     * Run the console command.
     *
     * @param  \Royalcms\Component\Service\Contracts\InputInterface  $input
     * @return integer
     */
    public function run(InputInterface $input)
    {
        $this->input = $input;
    }
    
    /**
     * Execute the console command.
     *
     * @param  \Royalcms\Component\Service\Contracts\InputInterface  $input
     * @return mixed
     */
    protected function execute(InputInterface $input)
    {
        return $this->fire();
    }
    
    abstract public function fire();
    
    /**
     * Call another console command.
     *
     * @param  string  $command
     * @param  array   $arguments
     * @return integer
     */
    public function call($api, array $arguments = array())
    {
        $instance = $this->getApplication()->find($api);
    
        $arguments['api'] = $api;
    
        return $instance->run(new ArrayInput($arguments), $this->output);
    }
    
    /**
     * Get the value of a command argument.
     *
     * @param  string  $key
     * @return string|array
     */
    public function argument($key = null)
    {
        if (is_null($key)) return $this->input->getArguments();
    
        return $this->input->getArgument($key);
    }

    /**
     * Get the value of a command option.
     *
     * @param  string  $key
     * @return string|array
     */
    public function option($key = null)
    {
        if (is_null($key)) return $this->input->getOptions();
    
        return $this->input->getOption($key);
    }
    
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array();
    }
    
    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }
    
    /**
     * Set the Royalcms application instance.
     *
     * @return \Royalcms\Component\Foundation\Royalcms
     */
    public function getRoyalcms()
    {
        return $this->royalcms;
    }
    
    /**
     * Set the Royalcms application instance.
     *
     * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function setRoyalcms($royalcms)
    {
        $this->royalcms = $royalcms;
    }
    
}

// end