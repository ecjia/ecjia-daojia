<?php

namespace Ecjia\App\Ucserver\Utilities;

class Xml
{
    protected $parser;
    protected $document;
    protected $stack;
    protected $data;
    protected $last_opened_tag;
    protected $isnormal;
    protected $attrs = array();
    protected $failed = FALSE;
    
    public function __construct($isnormal)
    {
        $this->isnormal = $isnormal;
        $this->parser = xml_parser_create('ISO-8859-1');
        xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);
        xml_set_object($this->parser, $this);
        xml_set_element_handler($this->parser, 'open','close');
        xml_set_character_data_handler($this->parser, 'data');
    }
    
    public function __destruct()
    {
        xml_parser_free($this->parser);
    }
    
    public function parse(& $data)
    {
        $this->document = array();
        $this->stack	= array();
        return xml_parse($this->parser, $data, true) && !$this->failed ? $this->document : '';
    }
    
    public function open(& $parser, $tag, $attributes)
    {
        $this->data = '';
        $this->failed = FALSE;
        if(!$this->isnormal) {
            if(isset($attributes['id']) && !is_string($this->document[$attributes['id']])) {
                $this->document  = &$this->document[$attributes['id']];
            } else {
                $this->failed = TRUE;
            }
        } else {
            if(!isset($this->document[$tag]) || !is_string($this->document[$tag])) {
                $this->document  = &$this->document[$tag];
            } else {
                $this->failed = TRUE;
            }
        }
        $this->stack[] = &$this->document;
        $this->last_opened_tag = $tag;
        $this->attrs = $attributes;
    }
    
    public function data(& $parser, $data)
    {
        if($this->last_opened_tag != NULL) {
            $this->data .= $data;
        }
    }
    
    public function close(& $parser, $tag)
    {
        if($this->last_opened_tag == $tag) {
            $this->document = $this->data;
            $this->last_opened_tag = NULL;
        }
        array_pop($this->stack);
        if($this->stack) {
            $this->document = &$this->stack[count($this->stack)-1];
        }
    }
}

//end