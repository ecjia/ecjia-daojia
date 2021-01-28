<?php

namespace Ecjia\Component\ActionLink;

class ActionLink
{

    /**
     * 连接地址
     * @var string
     */
    private $href;

    /**
     * 连接文本
     * @var string
     */
    private $text;

    /**
     * 连接图标
     * @var string|null
     */
    private $icon;

    /**
     * 是否PJAX请求
     * @var bool
     */
    private $pjax;

    public function __construct($href, $text, $icon = null, $is_pjax = false)
    {
        $this->href = $href;
        $this->text = $text;
        $this->icon = $icon;
        $this->pjax = $is_pjax;
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @param string $href
     * @return ActionLink
     */
    public function setHref(string $href): ActionLink
    {
        $this->href = $href;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return ActionLink
     */
    public function setText(string $text): ActionLink
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string|null $icon
     * @return ActionLink
     */
    public function setIcon(?string $icon): ActionLink
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPjax(): bool
    {
        return $this->pjax;
    }

    /**
     * @param bool $pjax
     * @return ActionLink
     */
    public function setPjax(bool $pjax): ActionLink
    {
        $this->pjax = $pjax;
        return $this;
    }







}