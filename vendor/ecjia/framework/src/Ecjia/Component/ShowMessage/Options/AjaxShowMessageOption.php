<?php


namespace Ecjia\Component\ShowMessage\Options;


use Ecjia\Component\ShowMessage\Contracts\ShowMessageOptionInterface;

class AjaxShowMessageOption implements ShowMessageOptionInterface
{

    protected $message;

    protected $state;

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    public function getStateFormatted()
    {
        if ($this->state === 0) {
            $state = 'error';
        }
        elseif ($this->state === 1) {
            $state = 'success';
        }

        return $state;
    }

    /**
     * @param mixed $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    public function toArray()
    {
        return [
            'message' => $this->getMessage(),
            'state'   => $this->getStateFormatted(),
        ];
    }
}