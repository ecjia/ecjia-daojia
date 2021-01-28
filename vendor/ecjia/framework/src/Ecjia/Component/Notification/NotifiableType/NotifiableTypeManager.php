<?php


namespace Ecjia\Component\Notification\NotifiableType;


class NotifiableTypeManager
{

    /**
     * @var NotifiableType[]
     */
    protected $types = [];

    public function __construct()
    {

    }

    /**
     * @param NotifiableType $notifiable
     * @return $this
     */
    public function register(NotifiableType $notifiable)
    {
        $this->types[$notifiable->getType()] = $notifiable;
        return $this;
    }

    /**
     * @param NotifiableType $notifiable
     * @return $this
     */
    public function unRegister(NotifiableType $notifiable)
    {
        unset($this->types[$notifiable->getType()]);
        return $this;
    }

    /**
     * 使用type注销类型
     * @param string $type
     * @return $this
     */
    public function unRegisterByType($type)
    {
        if (isset($this->types[$type])) {
            unset($this->types[$type]);
        }
        return $this;
    }

    /**
     * @param string $type
     * @return NotifiableType|null
     */
    public function getType($type)
    {
        if (isset($this->types[$type])) {
            return $this->types[$type];
        }
        return null;
    }

}