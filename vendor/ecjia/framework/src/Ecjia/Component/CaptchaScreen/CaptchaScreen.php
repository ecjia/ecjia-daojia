<?php

namespace Ecjia\Component\CaptchaScreen;

class CaptchaScreen
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $label;

    /**
     * @var bool
     */
    private $selected;

    /**
     * CaptchaScreen constructor.
     * @param $name
     * @param $value
     * @param $label
     * @param $selected
     */
    public function __construct($name, $value, $label, $selected = false)
    {
        $this->name     = $name;
        $this->value    = $value;
        $this->label    = $label;
        $this->selected = $selected;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return CaptchaScreen
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return CaptchaScreen
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     * @return CaptchaScreen
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSelected(): bool
    {
        return $this->selected;
    }

    /**
     * @param bool $selected
     * @return CaptchaScreen
     */
    public function setSelected(bool $selected): CaptchaScreen
    {
        $this->selected = $selected;
        return $this;
    }

    /**
     * @param $value
     * @return CaptchaScreen
     */
    public function checkSelected($value): CaptchaScreen
    {
        if (($value & $this->value) === $this->value) {
            $this->setSelected(true);
        }

        return $this;
    }




}