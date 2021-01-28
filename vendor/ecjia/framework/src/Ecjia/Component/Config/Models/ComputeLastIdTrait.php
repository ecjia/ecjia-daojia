<?php


namespace Ecjia\Component\Config\Models;


trait ComputeLastIdTrait
{

    /**
     * Get the next group id number.
     *
     * @return int
     */
    public function getNextGroupId()
    {
        return $this->getLastGroupId() + 1;
    }

    /**
     * Get the last group id number.
     *
     * @return int
     */
    protected function getLastGroupId()
    {
        $groups = $this->loadGroups();
        $max = $groups->values()->max();
        return $max;
    }


    protected function getLastItemIdByGroup($group_id)
    {
        $id = $this->getMaxItemIdByGroup($group_id);
        $id = $id ?: '00';
        return substr($id, -2);
    }

    public function getNextItemIdByGroup($group_id)
    {
        $group_id = strval($group_id) . strval($this->getLastItemIdByGroup($group_id) + 1);

        return intval($group_id);
    }

    /**
     * Get current group max id.
     * @param $group_id
     * @return mixed
     */
    public function getMaxItemIdByGroup($group_id)
    {
        $id = $this->where('parent_id', $group_id)->max('id');

        return $id;
    }

}