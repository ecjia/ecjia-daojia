<?php

namespace Royalcms\Component\Scheduler;

use \SplQueue;
use \Generator;
use \Closure;

//调度程序
Class Scheduler {
    protected $maxTaskId = 0;
    protected $taskMap = []; // taskId => task
    protected $taskCall = [];
    protected $taskQueue;
 
    public function __construct() {
        $this->taskQueue = new SplQueue();
    }

    public function newTask(Generator $coroutine, $callback = null) {
        $tid = ++$this->maxTaskId;
        $task = new Task($tid, $coroutine);
        $this->taskMap[$tid] = $task;
        if (!empty($callback) && $callback instanceof Closure) {
        	$this->taskCall[$tid] = $callback;
        }
        $this->schedule($task);
        return $tid;
    }
 	
 	//入队列
    public function schedule(Task $task) {
        $this->taskQueue->enqueue($task);
    }

    //与调度器之间通信
    public function run() {
		while (!$this->taskQueue->isEmpty()) {
		    $task = $this->taskQueue->dequeue();
		    $taskId = $task->getTaskId();
		    $retval = $task->run();

		    if ($retval instanceof CustomCall) {
		        $retval($task, $this);
		        continue;
		    } elseif (is_array($retval) && $retval['0'] == '@result') {
		    	//如果存在回调函数
		    	if (!empty($this->taskCall[$taskId])) {
		    		$callback = $this->taskCall[$taskId];
		    		$callback($retval['1'], $this);
		    	}		
		    }

		    if ($task->isFinished()) {
		    	$this->killTask($taskId);
		    } else {
		    	$this->schedule($task);
		    }
		}
	}

	/**
	 *	删除任务
	 */
	public function killTask($tid, $delQueue = false) {
	    if (!isset($this->taskMap[$tid])) {
	        return false;
	    }
	 
	    unset($this->taskMap[$tid]);
	 	unset($this->taskCall[$tid]);

	 	if (!$delQueue) {
	 		return true;
	 	}
	    // This is a bit ugly and could be optimized so it does not have to walk the queue,
	    // but assuming that killing tasks is rather rare I won't bother with it now
	    foreach ($this->taskQueue as $i => $task) {
	        if ($task->getTaskId() === $tid) {
	            unset($this->taskQueue[$i]);
	            break;
	        }
	    }
	 
	    return true;
	}
}