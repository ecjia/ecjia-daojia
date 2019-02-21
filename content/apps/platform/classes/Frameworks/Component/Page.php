<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
namespace Ecjia\App\Platform\Frameworks\Component;

use ecjia_page;
use RC_Config;

/**
 * 分页处理类
 * @package     Core
 */
class Page extends ecjia_page {

    /**
     * 分页文字描述
     */
    public function page_desc() {
    	$lang = array(
    		'total_records' => __('总计 ', 'platform'),
    		'total_pages' 	=> __('条记录，分为', 'platform'),
    		'page_current' 	=> __('页当前第', 'platform'),
    		'page_size' 	=> __('页，每页', 'platform'),
    		'page'			=> __(' 页', 'platform'),
    	);
    	
    	return <<< EOF
  		{$lang['total_records']} <span id="totalRecords">{$this->total_records}</span>
 		{$lang['total_pages']} <span id="totalPages">{$this->total_pages}{$lang['page']}</span>
EOF;
    }
    
    /**
     * 生成页面格式
     * @param 分页的html代码 $code
     */
    public function page_code($code, $page_desc = null/* , $style */) {
    	if (is_null($page_desc)) {
    		$page_desc = $this->page_desc();
    	}
    	
    	return <<<EOF
	    	<div class="card-body">
                <div class="row">
    				<div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="float-left my-1">
        					$page_desc
                        </div>
    				</div>
    				<div class="col-lg-8 col-md-6 col-sm-12">
                        <div class="float-right">
    	    			    $code
                        </div>
    				</div>
                </div>
			</div>
EOF;
    }
    
    /**
     * 输入框
     * @return string
     */
    public function input() {
        $str = "
        <div class='input-append input-group'>
        <input id='pagekeydown' type='text' name='page' value='{$this->current_page}' class='pageinput form-control' onkeydown = \"javascript:
        if(event.keyCode==13){
        location.href='{$this->get_url('B')}'+this.value+'{$this->get_url('A')}';
        }
        \"/>
        <span class='input-group-btn'>
        <button class='btn btn-primary' onclick = \"javascript:
        var input = document.getElementById('pagekeydown');
        location.href='{$this->get_url('B')}'+input.value+'{$this->get_url('A')}';
        \">GO</button></span>
        </div>
        ";
        return $str;
    }
    
    /**
     * 显示页码
     * @param string $style 风格
     * @param int $page_row 页码显示行数
     * @return string
     */
    public function show($style = '', $page_row = null) {
    	if (empty($style)) {
    		$style = RC_Config::get('system.page_style');
    	}
    	if($this->total_pages <= 1) {
    		return '';
    	}
    	
    	//页码显示行数
    	$this->page_row = is_null($page_row)? $this->page_row : $page_row - 1;
    	
    	switch ($style) {
    		case 1 :
    			return $this->page_code("<ul class='pagination justify-content-end'>{$this->first()}{$this->pre()}{$this->pres()}{$this->text_list()}{$this->nexts()}{$this->next()}{$this->end()}</ul>
    			<ul class='pagination justify-content-end'>{$this->now_page()}{$this->pic_list()}</ul>{$this->select()}",'');
    		case 2 :
    			return $this->page_code("<ul class='pagination justify-content-end'>" . $this->first() . $this->pre() . $this->text_list() . $this->next() . $this->end() . '</ul>');
    		case 3 :
    			return $this->page_code("<ul class='pagination justify-content-end'>" . $this->first() . $this->pre() . $this->text_list() . $this->next() . $this->end() . '</ul>');
    		case 4 :
    			return $this->page_code("<ul class='pagination justify-content-end'>" . $this->pic_list() . "</ul>" . $this->select() . '</ul>');
// 			case 6 : //白底灰色背景
// 			    return $this->page_code("<ul class='pagination'>" . $this->first() . $this->pre() . $this->text_list() . $this->next() . $this->end() . '</ul>', null, $style);
    		default:
    			return $this->page_code("<ul class='pagination pagination-separate pagination-curved'>" . $this->first() . $this->pre() . $this->text_list() . $this->next() . $this->end() . '</ul>');
    	}
    }
    
    /**
     * 首页
     * @return string
     */
    public function first() {
    	$first = $this->desc ['first'];
    	return $this->current_page - $this->page_row > 1 ? "<li class='page-item first'><a class='page-link data-pjax external_link' href='" . $this->get_url(1) . "'>{$first}</a></li>" : "";
    }
    
    /**
     * 上一页
     * @return string
     */
    public function pre() {
    	if ($this->current_page > 1 && $this->current_page <= $this->total_pages) {
    		return "<li class='page-item prev'><a class='page-link data-pjax external_link' href='" . $this->get_url($this->current_page - 1) . "'>{$this->desc['pre']}</a></li>";
    	}
    	return "<li class='page-item prev disabled'><a class='page-link'>{$this->desc['pre']}</a><li>";
    }
    
    /**
    * 下一页
    * @return string
    */
    public function next() {
	    $next = $this->desc ['next'];
	    if ($this->current_page < $this->total_pages) {
	    return "<li class='page-item next'><a class='page-link data-pjax external_link' href='" . $this->get_url($this->current_page + 1) . "'>{$next}</a></li>";
	    }
	    return "<li class='page-item next disabled'><a class='page-link'>{$next}</a></li>";
    }
    
    /**
     * 末页
     * @return string
     */
    public function end() {
    	$end = $this->desc ['end'];
    	return $this->current_page < $this->total_pages - $this->page_row ? "<li class='page-item last'><a class='page-link data-pjax external_link' href='" . $this->get_url($this->total_pages) . "'>{$end}</a></li>" : "";
    }
    
    /**
     * 文字页码列表
     * @return string
     */
    public function text_list() {
    	$arr = $this->page_list();
    	$str = "";
    	if (empty($arr))
    		return "<li class='page-item disabled'><a class='page-link'>1</a></li>";
    	foreach ($arr as $v) {
    		$str .= empty($v ['url']) ? "<li class='page-item'><a class='page-link'>" . $v ['str'] . "</a></li>" : "<li><a class='page-link data-pjax external_link' href={$v['url']}>{$v['str']}</a></li>";
    	}
    	return $str;
    }
}

// end