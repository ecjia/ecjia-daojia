<?php


namespace Ecjia\Component\Notification\NotifiableType;


class NotifiableType
{
    /**
     * @var array
     */
    protected $notifiable = [];

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $type;

    /**
     * NotifiableType constructor.
     * @param $id
     * @param $type
     */
    public function __construct($id, $type)
    {
        $this->id = $id;
        $this->type = $type;

        $this->notifiable[$this->type] = $type;
    }

    /**
     * 添加通知对象别名
     * @param $alias
     * @return NotifiableType
     */
    public function addNotifiableAlias($alias): NotifiableType
    {
        $this->notifiable[$alias] = $this->type;
        return $this;
    }

    /**
     * @param $alias
     * @return $this
     */
    public function removeNotifiableAlias($alias)
    {
        unset($this->notifiable[$alias]);
        return $this;
    }

    /**
     * @return array
     */
    public function getNotifiable(): array
    {
        return $this->notifiable;
    }

    /**
     * @return array
     */
    public function getNotifiableAlias(): array
    {
        return array_keys($this->notifiable);
    }

    /**
     * @return mixed
     */
    public function getNotifiableClass()
    {
        return $this->notifiable[$this->type];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

}