<?php

namespace Ecjia\Component\CaptchaScreen;

use RC_Hook;

class CaptchaScreenManager
{
    /**
     * 验证码场景值
     * @return array
     */
    protected $screens = [];

    public function __construct($screens = [])
    {
        $this->screens = $screens;
    }

    /**
     * @param CaptchaScreen $screen
     * @return $this
     */
    public function addScreen(CaptchaScreen $screen)
    {
        $this->screens[] = $screen;

        return $this;
    }

    /**
     * @param CaptchaScreen $screen
     * @return $this
     */
    public function removeScreen(CaptchaScreen $screen)
    {
        $this->screens = collect($this->screens)->map(function (CaptchaScreen $item) use ($screen) {
            if ($item === $screen) {
                return null;
            }
            return $item;
        })->filter()->toArray();

        return $this;
    }

    /**
     * @param CaptchaScreen $name
     * @return $this
     */
    public function removeScreenWithName($name)
    {
        $this->screens = collect($this->screens)->filter(function (CaptchaScreen $item) use ($name) {
            if ($item->getName() === $name) {
                return null;
            }
            return $item;
        })->toArray();

        return $this;
    }

    /**
     * @param array $screens
     * @return CaptchaScreenManager
     */
    public function setScreens(array $screens): CaptchaScreenManager
    {
        $this->screens = $screens;
        return $this;
    }

    /**
     * @return array
     */
    public function getScreens(): array
    {
        return RC_Hook::apply_filters('captcha_screens_filter', $this->screens);
    }

    /**
     * 获取选中的场景
     * @param $value
     * @return \Illuminate\Support\Collection|\Royalcms\Component\Support\Collection
     */
    public function getSelectedScreens($value)
    {
        return collect($this->getScreens())->filter(function (CaptchaScreen $item) use ($value) {
            return $item->checkSelected($value);
        });
    }

    /**
     * 判断指定场景是否被选中
     * @param $name
     * @param $value
     * @return bool
     */
    public function hasSelectedScreen($name, $value)
    {
        return $this->getSelectedScreens($value)->contains(function ($item) use ($name) {
            return $item->getName() === $name;
        });
    }

    /**
     * @param null $value
     * @param CaptchaScreenRenderInterface $render
     * @return string
     */
    public function render($value = null, ?CaptchaScreenRenderInterface $render = null)
    {
        if (is_null($render)) {
            $render = new CaptchaScreenRenderTemplate($this);
        }

        return $render->render($value);
    }

}