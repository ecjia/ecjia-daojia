<?php


namespace Ecjia\Component\ShowMessage;


use ecjia;
use Ecjia\Component\ShowMessage\Responses\AlterResponse;
use Ecjia\Component\ShowMessage\Responses\HtmlResponse;
use Ecjia\Component\ShowMessage\Responses\JsonResponse;
use Ecjia\Component\ShowMessage\Responses\XmlResponse;
use Ecjia\Component\ShowMessage\Contracts\ShowMessageOptionInterface;

class ShowMessage
{

    protected $content;
    protected $type;

    protected $msg_type;
    protected $msg_state;

    /**
     * @var ShowMessageOptionInterface
     */
    protected $option;

    /**
     * ShowMessage constructor.
     * @param int $type 消息类型， (0:html, 1:alert, 2:json, 3:xml)(0:错误，1:成功，2:消息, 3:询问)
     */
    public function __construct($content, $type, ShowMessageOptionInterface $option = null)
    {
        $this->content = $content;
        $this->type = $type;
        $this->option = $option;

        $this->msg_state = $type & 0x0F;
        $this->msg_type = $type & 0xF0;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return ShowMessage
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @return ShowMessage
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int
     */
    public function getMsgType()
    {
        return $this->msg_type;
    }

    /**
     * @param int $msg_type
     * @return ShowMessage
     */
    public function setMsgType($msg_type)
    {
        $this->msg_type = $msg_type;
        return $this;
    }

    /**
     * @return int
     */
    public function getMsgState()
    {
        return $this->msg_state;
    }

    /**
     * @param int $msg_state
     * @return ShowMessage
     */
    public function setMsgState($msg_state)
    {
        $this->msg_state = $msg_state;
        return $this;
    }

    /**
     * @return ShowMessageOptionInterface
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * @param ShowMessageOptionInterface $option
     * @return ShowMessage
     */
    public function setOption($option)
    {
        $this->option = $option;
        return $this;
    }

    /**
     * 响应
     */
    public function getResponse()
    {
        // HTML消息提醒
        if ($this->msg_type === ecjia::MSGTYPE_HTML) {
            $response = new HtmlResponse($this);
        }
        // ALERT消息提醒
        elseif ($this->msg_type === ecjia::MSGTYPE_ALERT) {
            $response = new AlterResponse($this);
        }
        // JSON消息提醒
        elseif ($this->msg_type === ecjia::MSGTYPE_JSON) {
            $response = new JsonResponse($this);
        }
        // XML消息提醒
        elseif ($this->msg_type === ecjia::MSGTYPE_XML) {
            $response = new XmlResponse($this);
        }
        else {
            $response = new HtmlResponse($this);
        }

        return $response();
    }



}