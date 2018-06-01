<?php

namespace Royalcms\Component\WebSocket\QueueHandles;

use RC_Queue;

class RedisQueueHandle
{

    private $inQueue = '';
    private $outQueue = '';

    public function setQueueName($name)
    {
        $this->inQueue = $name . '_in';
        $this->outQueue = $name . '_out';
    }

    public function pushInQueue($connectionId, $userID, $data, $handle)
    {
        RC_Queue::pushRaw(json_encode([
            'connection_id' => $connectionId,
            'user_id' => $userID,
            'data' => $data,
            'handle' => $handle,
            'meta' => [
                'time' => time()
            ]
        ]), $this->inQueue);
    }

    public function popInQueue()
    {
        $a = new \Predis\Command\ListPopFirstBlocking();
        $a->setRawArguments(['queues:' . $this->inQueue, 1]);
        $work = RC_Queue::getRedis()->connection()->client()->executeCommand($a);

        if (!empty($work[1]) && $work = json_decode($work[1], true)) {
            if (!empty($work['connection_id']) && class_exists($work['handle'])) {
                return $work;
            }
        }
        return false;
    }

    public function pushOutQueue($to, $action, $data)
    {
        RC_Queue::pushRaw(json_encode([
            'to' => $to,
            'action' => $action,
            'data' => $data,
            'meta' => [
                'time' => time()
            ]
        ]), $this->outQueue);
    }

    public function popOutQueue()
    {
        $a = new \Predis\Command\ListPopFirst();
        $a->setRawArguments(['queues:' . $this->outQueue]);
        $work = RC_Queue::getRedis()->connection()->client()->executeCommand($a);

        $work = json_decode($work, true);

        if (!empty($work['to']) && !empty($work['action'])) {
            return $work;
        }
        return false;
    }

    // Helper chaining functions
    public function to($connectionId)
    {
        $this->to = [ 'connection_id' => $connectionId ];
        return $this;
    }

    public function toUser($userId)
    {
        $this->to = [ 'user_id' => $userId ];
        return $this;
    }

    public function all()
    {
        $this->to = [ 'broadcast' => true ];
        return $this;
    }

    public function broadcast($action, $data)
    {
        $this->to = [ 'broadcast' => true ];
        $this->pushOutQueue($this->to, $action, $data);
    }

    public function send($action, $data)
    {
        $this->pushOutQueue($this->to, $action, $data);
    }

}

// end