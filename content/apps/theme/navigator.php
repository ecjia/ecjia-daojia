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
/**
 * ECJIA 程序说明
 */
defined('IN_ECJIA') or exit('No permission resources.');

class navigator extends ecjia_admin {
	private $db_nav;
	public function __construct() {
		parent::__construct();

		$this->db_nav = RC_Loader::load_model('nav_model');

		if (!ecjia::config('navigator_data',2)) {
			ecjia_config::instance()->insert_config('hidden', 'navigator_data', serialize(array(array('type'=>'top','name'=>'顶部'),array('type'=>'middle','name'=>'中间'),array('type'=>'bottom','name'=>'底部'))), array('type' => 'hidden'));
		}
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');

		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		
		RC_Script::enqueue_script('navigator', RC_App::apps_url('statics/js/navigator.js', __FILE__));
		
		$admin_nav_jslang = array(
				'confirm_delete_menu'	=> __('确定要移除这个菜单项吗？'),
				'ok'					=> __('确定'),
				'cancel'				=> __('取消')
		);
		RC_Script::localize_script('navigator', 'admin_nav_lang', $admin_nav_jslang );
		
	}


	/**
	 * 菜单列表
	 */
	public function init() {
	    $this->admin_priv('navigator');

		$type = !empty($_GET['type'])?strip_tags(htmlspecialchars($_GET['type'])):'';
		$showstate = !empty($_GET['showstate'])?strip_tags(htmlspecialchars($_GET['showstate'])):'';


		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('菜单管理')));
		$this->assign('ur_here', __('菜单管理'));


		$this->assign('full_page',  1);
		$this->assign('showstate', $showstate);
		$this->assign('_FILE_STATIC', RC_Uri::admin_url('statics/'));

		$nav_list = unserialize(ecjia::config('navigator_data'));

		// 获取菜单名称
		$nav_name = '';
		if (!empty($nav_list)) {
			foreach ($nav_list as $v) {
				if (empty($type)) {
					$type = $v['type'];
					$nav_name = $v['name'];
					break;
				}
				if ($v['type'] == $type) {
				    $nav_name = $v['name'];
				}
			}
		} else {
			$this->add_nav_list();die;
		}

		//如果菜单不存在，报错
		if (empty($nav_name)) {
		    die(__('没有这个菜单'));
		}

		$navdb = $this->get_nav();
		$tmp_navdb = array();
		foreach ($navdb['navdb'] as $v) {
			if ($v['type'] == $type) {
			    $tmp_navdb[] = $v;
			}
		}

		$pagenav = $this->get_pagenav();
		// $categorynav = $this->get_categorynav();

		$this->assign('nav_list',     $nav_list);
		$this->assign('nav_type',     $type);
		$this->assign('nav_name',     $nav_name);
		$this->assign('navdb',        $tmp_navdb);
		$this->assign('pagenav',      $pagenav);
		// $this->assign('categorynav',  $categorynav);
		$this->assign('filter',       $navdb['filter']);
		$this->assign('record_count', $navdb['record_count']);
		$this->assign('page_count',   $navdb['page_count']);

		$this->display('navigator.dwt');
	}

	/**
	 * 添加菜单列表
	 */
	public function add_nav_list() {
		$this->admin_priv('navigator');
		
		$pagenav = $this->get_pagenav();
		// $categorynav = $this->get_categorynav();
		$this->assign('pagenav',      $pagenav);
		// $this->assign('categorynav',  $categorynav);
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('菜单管理')));
		$this->assign('ur_here', __('菜单管理'));

		$this->assign('nav_list',     unserialize(ecjia::config('navigator_data')));
		$this->assign('form_action',     RC_Uri::url('theme/navigator/init'));

		$this->display('navigator_addlist.dwt');
	}

	/**
	 * 执行添加菜单栏列表
	 */
	public function update_nav_list() {
		$name = strip_tags(htmlspecialchars($_GET['nav_name']));
		$list = unserialize(ecjia::config('navigator_data'));

		if (empty($name))die(__('菜单名不能为空'));

		//判断是否重复
		foreach ($list as $v) {
			if ($name == $v['name'])die(__('重复了'));
		}

		//插入新菜单
		$tmp = 'nav'.substr(time(),-5).rand(0, 99);
		$list[] = array('type'=>$tmp,'name'=>$name);

		if (ecjia_config::instance()->write_config('navigator_data', serialize($list))) {
			$_GET['type'] = $tmp;
			$this->init();
		} else {
			echo __('失败');
		}

	}

	/**
	 * 编辑菜单内容
	 */
	public function edit_nav() {
		$navlist_del = strip_tags ( htmlspecialchars($_POST ['navlist_del']) );
		if (! empty ( $navlist_del )) {
			$nav_del = explode ( ',', $navlist_del );
			foreach ( $nav_del as $v ) {
				if (!empty($v)) $this->db_nav->where ('id='.$v.'')->delete();
			}
		}

		$navlist = $_POST['nav_list'];
		if (!empty($navlist)) {
			foreach ($navlist as $k=>$v) {
				if ($v['id'] == 'new') {
					unset($v['id']);
					$v['type'] = $_POST['nav_type'];
					$this->db_nav->insert($v);
				} else {
					$this->db_nav->where('id = '.$v['id'].'')->update($v);
				}
			}
		}

		$navlist_name = strip_tags(htmlspecialchars($_POST['navlist_name']));
		$type = strip_tags(htmlspecialchars($_POST['nav_type']));
		$list = unserialize(ecjia::config('navigator_data'));

		if (empty($type)) {
		    die(__('菜单名不能为空'));
		}

		//判断是否重复
		foreach ($list as $k => $v) {
			if ($type == $v['type'])$list[$k]['name'] = $navlist_name;
			if ($type == $v['name'] && $type != $v['type'])die(__('重复了'));
		}

		//插入新菜单
		if (ecjia_config::instance()->write_config('navigator_data', serialize($list))) {
			echo 1;
		} else {
			echo 0;
		}
	}

	/**
	 * 删除菜单内容
	 */
	public function del_nav() {
		$id = intval($_POST['del_id']);
		if (empty($id))die('0');
		$this->db_nav->where('id = '.$id.'')->delete();
		echo 1;
	}

	/**
	 * 删除菜单
	 */
	public function del_navlist() {
		$type = strip_tags(htmlspecialchars($_GET['del_type']));
		$list = unserialize(ecjia::config('navigator_data'));

		//直接删除
		foreach ($list as $k => $v) {
			if ($v['type'] == $type)unset($list[$k]);
		}

		if (empty($list)) {
		    ecjia_config::instance()->write_config('navigator_data', '');
		}
		if (ecjia_config::instance()->write_config('navigator_data', serialize($list))) {
			$this->db_nav->where("type = '".$type."'")->delete();
			$this->init();
		} else {
			echo 0;
		}

	}

	/**
	 * 菜单栏列表Ajax
	 */
	public function query() {
		global $ecs, $db, $_CFG, $sess;

		$navdb = $this->get_nav();

		$this->assign('navdb',    $navdb['navdb']);
		$this->assign('filter',       $navdb['filter']);
		$this->assign('record_count', $navdb['record_count']);
		$this->assign('page_count',   $navdb['page_count']);

        return $this->showmessage($this->fetch_string('navigator.dwt'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('filter' => $navdb['filter'], 'page_count' => $navdb['page_count']));
	}

	/**
	 * 菜单栏删除
	 */
	public function del() {
		$this->admin_priv('navigator');
		
		$id = intval($_GET['id']);

		$row = $this->db_nav->field('ctype,cid,type')->find(array('id' => $id));
		if ($row['type'] == 'middle' && $row['ctype'] && $row['cid']) {
			$this->set_show_in_nav($row['ctype'], $row['cid'], 0);
		}

		$this->db->where('id='.$id.'')->delete();
		return $this->redirect(RC_Uri::url('theme/navigator/init'));
	}

	/**
	 * 编辑排序
	 */
	public function edit_sort_order() {
		$this->admin_priv('navigator');

		$id    = intval($_POST['id']);
		$order = trim($_POST['val']);
	}

	private function get_nav() {
    	$db = RC_Loader::load_model('nav_model');
    	$filter['sort_by']      = empty($_REQUEST['sort_by']) ? 'type DESC, vieworder' : 'type DESC, '.trim($_REQUEST['sort_by']);
    	$filter['sort_order']   = empty($_REQUEST['sort_order']) ? 'ASC' : trim($_REQUEST['sort_order']);
    	$count = $db->count();
    	$filter['record_count'] = $count;
    	$sql = $db->field('id, name, ifshow, vieworder, opennew, url, type')->order($filter['sort_by'] . ' ' . $filter['sort_order'])->select();
    	$navdb = $sql;
    	$type = "";
    	$navdb2 = array();
    	if (!empty($navdb)) {
    		foreach($navdb as $k=>$v) {
    			if (!empty($type) && $type != $v['type']) {
    				$navdb2[] = array();
    			}
    			$navdb2[] = $v;
    			$type = $v['type'];
    		}
    	}

    	$arr = array('navdb' => $navdb2, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    	return $arr;
    }

    /**
     * 获得页面列表
     * @return multitype:multitype:string  multitype:string Ambigous <string, mixed>
     */
    private function get_pagenav() {
        return $sysmain = array(
            array(__('查看购物车'), 'flow.php'),
            array(__('选购中心'), 'pick_out.php'),
            array(__('团购商品'), 'group_buy.php'),
            array(__('夺宝奇兵'), 'snatch.php'),
            array(__('标签云'), 'tag_cloud.php'),
            array(__('用户中心'), 'user.php'),
            array(__('批发'), 'wholesale.php'),
            array(__('优惠活动'), 'activity.php'),
            array(__('配送方式'), 'myship.php'),
            array(__('留言板'), 'message.php'),
            array(__('报价单'), 'quotation.php'),
        );
    }

    /**
     * 获得分类列表
     * @return multitype:unknown mixed
     */
    private function get_categorynav() {
        RC_Loader::load_app_func('category','goods');
        RC_Loader::load_app_func('article','article');
        $cat_list = cat_list(0, 0, false) ? cat_list(0, 0, false) : array();
        $article_cat_list = article_cat_list(0, 0, false) ? article_cat_list(0, 0, false) : array();

        $catlist = array_merge($cat_list, $article_cat_list);
        if (!empty($catlist)) {
            foreach($catlist as $key => $val) {
                $val['view_name'] = $val['cat_name'];
                for($i=0;$i<$val['level'];$i++) {
                    $val['view_name'] = '&nbsp;&nbsp;&nbsp;&nbsp;' . $val['view_name'];
                }
                $val['url'] = str_replace( '&amp;', '&', $val['url']);
                $val['url'] = str_replace( '&', '&amp;', $val['url']);
                $sysmain[] = array($val['cat_name'], $val['url'], $val['view_name']);
            }
        }
        return $sysmain;
    }

    /**
     * 列表项修改
     * @param number $id
     * @param array $args
     * @return boolean
     */
    private function nav_update($id, $args) {
        $db = RC_Loader::load_model('nav_model');
        if (empty($args) || empty($id)) {
            return false;
        }
        return  $db->where('id = '.$id.'')->update($args);
    }

    /**
     * 根据URI对导航栏项目进行分析，确定其为商品分类还是文章分类
     * @param string $uri
     * @return multitype:string Ambigous <> |multitype:string multitype: |boolean
     */
    function analyse_uri($uri) {
        $uri = strtolower(str_replace('&amp;', '&', $uri));
        $arr = explode('-', $uri);
        switch ($arr[0]) {
        	case 'category' :
        	    return array('type' => 'c', 'id' => $arr[1]);
        	    break;
        	case 'article_cat' :
        	    return array('type' => 'a', 'id' => $arr[1]);
        	    break;
        	default:
        	    break;
        }

        list($fn, $pm) = explode('?', $uri);

        if (strpos($uri, '&') === false) {
            $arr = array($pm);
        } else {
            $arr = explode('&', $pm);
        }
        switch ($fn) {
        	case 'category.php' :
        	    //商品分类
        	    foreach ($arr as $k => $v) {
        	        list($key, $val) = explode('=', $v);
        	        if ($key == 'id') {
        	            return array('type' => 'c', 'id' => $val);
        	        }
        	    }
        	    break;
        	case 'article_cat.php'  :
        	    //文章分类
        	    foreach($arr as $k => $v) {
        	        list($key, $val) = explode('=', $v);
        	        if ($key == 'id') {
        	            return array('type' => 'a', 'id'=> $val);
        	        }
        	    }
        	    break;
        	default:
        	    //未知
        	    return false;
        	    break;
        }

    }

    /**
     * 是否显示
     * @param string $type
     * @param number $id
     */
    private function is_show_in_nav($type, $id) {
        if ($type == 'c') {
            $db = RC_Loader::load_app_model('category_model','goods');
        } else {
            $db = RC_Loader::load_app_model('article_cat_model','article');
        }

        return  $db->field('show_in_nav')->find('cat_id = '.$id.'');
    }

    /**
     * 设置是否显示
     * @param string $type
     * @param int $id
     * @param string $val
     */
    function set_show_in_nav($type, $id, $val) {
        if ($type == 'c') {
            $db = RC_Loader::load_app_model('category_model','goods');
        } else {
            $db = RC_Loader::load_app_model('article_cat_model','article');
        }
        $db->where('cat_id = '.$id.'')->update(array('show_in_nav' => $val));
    }
}

// end
