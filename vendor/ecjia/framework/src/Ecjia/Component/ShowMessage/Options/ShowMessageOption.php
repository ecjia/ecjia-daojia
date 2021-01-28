<?php


namespace Ecjia\Component\ShowMessage\Options;


use Ecjia\Component\ShowMessage\Contracts\ShowMessageOptionInterface;

class ShowMessageOption implements ShowMessageOptionInterface
{

    /**
     * default: ''
     * alert-success 成功提示条
     * alert-info 信息提示条
     * alert-danger 警告提示条
     * @var string|null
     */
    protected $page_state;

    protected $ur_here;

    protected $msg_detail;

    protected $msg_type;

    protected $url;

    protected $timeout;

    protected $template_file;

    /**
     * @return string|null
     */
    public function getPageState()
    {
        return $this->page_state;
    }

    public function getPageStateFormatted()
    {
        switch ($this->page_state) {
            case 1:
            case 'alert-success':
                $page_state = array('icon' => 'fontello-icon-ok-circled', 'msg' => __('操作成功', 'ecjia'), 'class' => 'alert-success');
                break;
            case 2:
            case 'alert-info':
                $page_state = array('icon' => 'fontello-icon-info-circled', 'msg' => __('操作提示', 'ecjia'), 'class' => 'alert-info');
                break;
            case 3:
            case '':
                $page_state = array('icon' => 'fontello-icon-attention-circled', 'msg' => __('操作警告', 'ecjia'), 'class' => '');
                break;
            case 'alert-danger':
            default:
                $page_state = array('icon' => 'fontello-icon-cancel-circled', 'msg' => __('操作错误', 'ecjia'), 'class' => 'alert-danger');
        }

        return $page_state;
    }

    /**
     * @param string|null $page_state
     * @return ShowMessageOption
     */
    public function setPageState($page_state)
    {
        $this->page_state = $page_state;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrHere()
    {
        return $this->ur_here;
    }

    /**
     * @param mixed $ur_here
     * @return ShowMessageOption
     */
    public function setUrHere($ur_here)
    {
        $this->ur_here = $ur_here;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMsgDetail()
    {
        return $this->msg_detail;
    }

    /**
     * @param mixed $msg_detail
     * @return ShowMessageOption
     */
    public function setMsgDetail($msg_detail)
    {
        $this->msg_detail = $msg_detail;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMsgType()
    {
        return $this->msg_type;
    }

    /**
     * @param mixed $msg_type
     * @return ShowMessageOption
     */
    public function setMsgType($msg_type)
    {
        $this->msg_type = $msg_type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        if (!empty($this->url)) {
            $this->url = "window.location.href='" . $this->url;
        } else {
            $this->url = "window.history.back(-1);";
        }

        return $this->url;
    }

    /**
     * @param mixed $url
     * @return ShowMessageOption
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param mixed $timeout
     * @return ShowMessageOption
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTemplateFile()
    {
        if (is_null($this->template_file)) {
            $this->template_file = __DIR__ . '/resources/message_template.php';
        }

        return $this->template_file;
    }

    /**
     * @param mixed $template_file
     * @return ShowMessageOption
     */
    public function setTemplateFile($template_file)
    {
        $this->template_file = $template_file;
        return $this;
    }


    public function toArray()
    {
        return [
            'page_state'           => $this->getPageState(),
            'page_state_formatted' => $this->getPageStateFormatted(),
            'ur_here'              => $this->getUrHere(),
            'msg_detail'           => $this->getMsgDetail(),
            'msg_type'             => $this->getMsgType(),
            'url'                  => $this->getUrl(),
            'timeout'              => $this->getTimeout(),
            'template_file'        => $this->getTemplateFile(),
        ];
    }

}