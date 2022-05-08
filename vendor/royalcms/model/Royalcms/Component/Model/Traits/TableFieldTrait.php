<?php


namespace Royalcms\Component\Model\Traits;


trait TableFieldTrait
{

    /**
     * 检查不存在的字段
     *
     * @param $array 要检查的字段列表
     * @return array
     */
    public function check_fields($array)
    {
        $fields   = $this->db->fields;
        $nofields = array();
        foreach ($array as $v) {
            if (!array_key_exists($v, $fields)) {
                $nofields[] = $v;
            }
        }
        return $nofields;
    }

    /**
     * 判断表中字段是否在存在
     *
     * @param string $field_name 字段名
     * @return bool
     */
    public function field_exists($field_name)
    {
        $fields = $this->db->opt['fields'];
        if (in_array($field_name, $fields)) {
            return true;
        }
        return false;
    }

}