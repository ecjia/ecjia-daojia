<?php

namespace Ecjia\App\Printer;

use Royalcms\Component\Foundation\Object;
use ecjia_error;
use ecjia_printer;
use Ecjia\App\Printer\Models\PrinterTemplateModel;
use Ecjia\App\Printer\Models\PrinterPrintlistModel;
use RC_Hook;
use RC_Time;

class EventPrint extends Object
{
    
    protected $model;
    protected $event;
    
    public function setTemplateModel(PrinterTemplateModel $model)
    {
        $this->model = $model;
        return $this;
    }
    
    public function getTemplateModel()
    {
        return $this->model;
    }
    
    public function setEvent(EventAbstract $event)
    {
        $this->event = $event;
        return $this;
    }
    
    public function getEvent()
    {
        return $this->event;
    }
    
    
    /** 发送短消息
     *
     * @access  public
     * @param   string  $machine         设备终端号
     * @param   string  $template        事件code
     * @param   string  $template_var    模板变量，数组格式
     */
    public function send($machine, array $template_var)
    {
        if (!$this->model || !$this->event) {
            return new ecjia_error('not_found_object', '请先使用setTemplateModel或setEvent方法设置参数');
        }
        
        $this->event->setPrintNumber($this->model->print_number);
        $this->event->setGoodsLists($template_var['goods_lists']);
        $this->event->setGoodsSubtotal($template_var['goods_subtotal']);
        $this->event->setTailContent($this->model->tail_content);
        $this->event->setContentByCustomVar($template_var);
        $content = $this->event->getContent();
        
        $result = ecjia_printer::printSend($machine, $content, $template_var['order_sn']);
        
        $this->addRecord($this->model->store_id, $machine, $this->model->template_code, $template_var['order_sn'], $template_var['order_type'], $content, $result);

        if (is_ecjia_error($result)) {
            return $result;
        }

        return $result;
    }
    
    /**
     * 重新打印此条订单
     */
    public function resend($id)
    {
        $model = PrinterPrintlistModel::find($id);
        if (empty($model)) {
            return new ecjia_error('not_found_print_id', '没有找到此打印记录');
        }
        
        $tips = '提示：此单为重新打印订单';
        if (!strpos($model->content, $tips)) {
            $content = $model->content . "\r\r<center>$tips</center>";
        } else {
            $content = $model->content;
        }
        
        $result = ecjia_printer::printSend($model->machine_code, $content, $model->order_sn);
        
        $this->addRecord($model->store_id, $model->machine_code, $model->template_code, $model->order_sn, $model->order_type, $content, $result);
        
        if (is_ecjia_error($result)) {
            return $result;
        }
        
        return $result;
    }
    
    
    public function addRecord($store_id, $machine, $template_code, $order_sn, $order_type, $content, $result, $priority = 1)
    {
        $data = array(
            'store_id'          => $store_id,
            'order_sn'          => $order_sn,
            'order_type'        => $order_type,
            'machine_code'      => $machine,//设备终端号
            'template_code'     => $template_code,//短信模板ID
            'content'           => $content,//短信内容
            'priority'          => $priority,//优先级高低（0，1）
            'status'            => 0,//是否出错（0，1）
            'last_error_message'=> '',
            'last_send'         => RC_Time::gmtime(),//最后发送时间
        );
    
        if (is_ecjia_error($result))
        {
            $data['last_error_message'] = $result->get_error_message();
            $data['status'] = 2;
        } else {
            $data['print_order_id']    = $result['id'];
        }
        
        PrinterPrintlistModel::create($data);
    }
}