<?php

namespace Ecjia\System\Frameworks\Meta;

use RC_DB;
use Exception;

class MetaAbstract
{
    protected $meta_key;
    
    protected $object_type;
    
    protected $object_group;
    
    protected $object_id;
    
    public function __construct($id)
    {
        $this->object_id = $id;
    }
    
    
    protected function validateProperty()
    {
        if (!$this->meta_key || !$this->object_type || !$this->object_group || !$this->object_id) {
            throw new Exception("The class property must be setted.");
        }
    }
    
    public function save($value)
    {
        $this->validateProperty();
        
        //如果存在，则更新
        if ($this->exists())
        {
            $data = [
                'meta_value'    => $value,
            ];
            
            return RC_DB::table('term_meta')->where('object_type', $this->object_type)
            ->where('object_group', $this->object_group)
            ->where('object_id', $this->object_id)
            ->where('meta_key', $this->meta_key)
            ->update($data);
        }
        //如果不存在，则插入新值
        else
        {
            $data = [
                'object_type'   => $this->object_type,
                'object_group'  => $this->object_group,
                'object_id'     => $this->object_id,
                'meta_key'      => $this->meta_key,
                'meta_value'    => $value,
            ];
            
            return RC_DB::table('term_meta')->insert($data);
        }
    }
    
    
    public function exists()
    {
        $this->validateProperty();
        
        return RC_DB::table('term_meta')->select('meta_id')->where('object_type', $this->object_type)
        ->where('object_group', $this->object_group)
        ->where('object_id', $this->object_id)
        ->where('meta_key', $this->meta_key)
        ->pluck('meta_id');
    }
    
    
    public function get()
    {
        $this->validateProperty();
        
        return RC_DB::table('term_meta')->select('meta_value')->where('object_type', $this->object_type)
        ->where('object_group', $this->object_group)
        ->where('object_id', $this->object_id)
        ->where('meta_key', $this->meta_key)
        ->pluck('meta_value');
    }
    
}
