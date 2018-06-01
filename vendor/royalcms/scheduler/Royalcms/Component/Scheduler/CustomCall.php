<?php

namespace Royalcms\Component\Scheduler;

//自定义调用
Class CustomCall
{
	protected $callback;

	public function __construct(callable $callback)
	{
		$this->callback = $callback;
	}

	public function __invoke(Task $task, Scheduler $scheduler) 
	{
        $callback = $this->callback;
        return $callback($task, $scheduler);
    }

    public static function returnReust($data)
    {
    	return ['@result', $data];
    }
}