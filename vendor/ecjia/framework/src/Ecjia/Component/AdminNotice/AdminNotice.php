<?php

namespace Ecjia\Component\AdminNotice;


class AdminNotice
{
    use CompatibleTrait;

    private $content;

    /**
     * @var string
     * 默认为空 黄色条
     * alert-error 红色条
     * alert-success 绿色条
     * alert-info 蓝色条
     */
    private $type;

    /**
     * 是否允许关闭
     * @var bool
     */
    private $allow_close = true;

    public function __construct($content, $type = '', $allow_close = true)
    {
        $this->content     = $content;
        $this->type        = $type;
        $this->allow_close = $allow_close;
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
     * @return AdminNotice
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return AdminNotice
     */
    public function setType(string $type): AdminNotice
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAllowClose(): bool
    {
        return $this->allow_close;
    }

    /**
     * @param bool $allow_close
     * @return AdminNotice
     */
    public function setAllowClose(bool $allow_close): AdminNotice
    {
        $this->allow_close = $allow_close;
        return $this;
    }

}