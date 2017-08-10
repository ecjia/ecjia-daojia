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
defined('IN_ECJIA') or exit('No permission resources.');

class platform_account {
    protected static $uuid_pool = array();
    
    protected $uuid;
    protected $row;
    
    public static function make($uuid) {
        if (isset(self::$uuid_pool[$uuid]) && self::$uuid_pool[$uuid]) {
            return self::$uuid_pool[$uuid];
        } else {
            return new static($uuid);
        }
    }
    
    public function __construct($uuid) {
        $this->uuid = $uuid;
        $this->row = $this->getAccountRow();
        self::$uuid_pool[$uuid] = $this;
    }
    
    protected function getAccountRow() {
        //查询数据库
        $db_platform_command = RC_Loader::load_app_model('platform_account_model', 'platform');
        $row = $db_platform_command->where(array('uuid' => $this->uuid))->find();
        if (empty($row)) {
            return new ecjia_error('platform_not_found_uuid', RC_Lang::get('platform::platform.unidentification_uuid'));
        }
        return $row;
    }
    
    public function getAccountID() {
        if (is_ecjia_error($this->row)) {
            return $this->row;
        }
        return $this->row['id'];
    }
    
    public function getAccountName() {
        if (is_ecjia_error($this->row)) {
            return $this->row;
        }
        return $this->row['name'];
    }
    
    /**
     * 获取当前帐号的基本信息
     * @return unknown|multitype:unknown
     */
    public function getAccount() {
        if (is_ecjia_error($this->row)) {
            return $this->row;
        }
        
        $data = array(
            'uuid'      => $this->row['uuid'],
            'name'      => $this->row['name'],
            'type'      => $this->row['type'],
            'token'     => $this->row['token'],
            'appid'     => $this->row['appid'],
            'appsecret' => $this->row['appsecret'],
            'aeskey'    => $this->row['aeskey'],
        );
        return $data;
    }
    
    /**
     * 获取当前帐号的状态
     * @return unknown|boolean
     */
    public function getStatus() {
        if (is_ecjia_error($this->row)) {
            return $this->row;
        }
        
        if ($this->row['status']) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 获取当前帐号的平台类型
     */
    public function getPlatform() {
        if (is_ecjia_error($this->row)) {
            return $this->row;
        }
        
        return $this->row['platform'];
    }
    
    /**
     * 获取指定平台的公众号列表
     * @param string $platform
     */
    public static function getAccountList($platform, $shopid = 0) {
        $db_platform_account = RC_Loader::load_app_model('platform_account_model', 'platform');
        $accountlist = $db_platform_account->where(array('platform' => $platform, 'shop_id' => $shopid, 'status'=>1))->order('sort DESC, id DESC')->select();
        return $accountlist;
    }
    
    /**
     * 判断UUID是否属于账号的
     * @param string $platform
     * @param string $uuid
     * @param number $shopid
     * @return boolean
     */
    public static function hasAccountUUID($platform, $uuid, $shopid = 0) {
    	$account_list = self::getAccountList($platform, $shopid);
		if(!empty($account_list)) {
			foreach ($account_list as $item => $val) {
				$uuids[] = $val['uuid'];
			}
			if (in_array($uuid, $uuids)) {
				return true;
			}
			return false;
		}
    }
    
    /**
     * 获取当前选择的公众号列表
     * @param string $platform
     */
    public static function getCurrentUUID($platform, $shopid = 0) {
        $db = RC_Loader::load_model('term_meta_model');
        $meta_key       = $platform . '_current_account';
        $object_type    = 'ecjia.system';
        $object_group   = 'admin_user';
        $object_id      = $_SESSION['admin_id'];
        
        $data = array(
            'object_id'     => $object_id,
            'object_type'   => $object_type,
            'object_group'  => $object_group,
            'meta_key'      => $meta_key,
        );
        $row = $db->where($data)->find();
        if ($row) {
            $uuid = $row['meta_value'];
            if (self::hasAccountUUID($platform, $uuid, $shopid)) {
            	return $uuid;
            }
        }
       
        $accountlist = self::getAccountList($platform, $shopid);
        $uuid = $accountlist[0]['uuid'];
        self::setCurrentUUID($platform, $uuid);
        return $uuid;
    }
    
    /**
     * 切换当前公众号
     * @param string $platform
     * @param string $uuid
     */
    public static function setCurrentUUID($platform, $uuid) {
    	if (!$_SESSION['admin_id']) {
    		return new ecjia_error('is_not_admin_id', RC_Lang::get('platform::platform.must_root_operation'));
    	}
        $db = RC_Loader::load_model('term_meta_model');
        $meta_key       = $platform . '_current_account';
        $object_type    = 'ecjia.system';
        $object_group   = 'admin_user';
        $object_id      = $_SESSION['admin_id'];
        
        $data = array(
            'object_id'     => $object_id,
            'object_type'   => $object_type,
            'object_group'  => $object_group,
            'meta_key'      => $meta_key,
        );
        $row = $db->where($data)->find();
        
        if ($row && $uuid) {
            $where_data = array(
                'meta_id'     => $row['meta_id'],
            );
            $update_data = array(
                'meta_value'    => $uuid,
            );
            $db->where($where_data)->update($update_data);
        } else {
            $data = array(
                'object_id'     => $object_id,
                'object_type'   => $object_type,
                'object_group'  => $object_group,
                'meta_key'      => $meta_key,
                'meta_value'    => $uuid,
            );
            $db->insert($data);
        }
        
    }
    
    public static function getAccountSwtichDisplay($platform, $shopid = 0) {
        $account_list = platform_account::getAccountList($platform, $shopid);
        $current_uuid = platform_account::getCurrentUUID($platform, $shopid);
        $platform = trim($platform);
        
        echo <<<EOF
        <div>
        <div class="btn-group">
EOF;
        
        if (empty($account_list)) {
        	if ($platform == 'weapp') {
        		echo '<button data-toggle="dropdown" class="btn dropdown-toggle">请先添加小程序 <span class="caret"></span></button>';
        	} else {
        		echo '<button data-toggle="dropdown" class="btn dropdown-toggle">请先添加公众号 <span class="caret"></span></button>';
        	}
            
        } else {
        	$new_account_list = array();
            foreach ($account_list as $item => $val) {
                $new_account_list[$val['uuid']] = $val;
            }
            $uuids = array_keys($new_account_list);
            if (in_array($current_uuid, $uuids)) {
            	echo '<button data-toggle="dropdown" class="btn dropdown-toggle">' . $new_account_list[$current_uuid]['name'] . ' <span class="caret"></span></button>';
            } else {
            	if ($platform == 'weapp') {
            		echo '<button data-toggle="dropdown" class="btn dropdown-toggle">请先选择小程序 <span class="caret"></span></button>';
            	} else {
            		echo '<button data-toggle="dropdown" class="btn dropdown-toggle">请先选择公众号 <span class="caret"></span></button>';
            	}
            }
        }

		echo <<<EOF
			<ul class="dropdown-menu">
EOF;
    	
        foreach ($account_list as $item => $val) {
			if ($platform == 'weapp') {
				$url_first_pra = 'weapp/admin_switch/init';
			} else {
				$url_first_pra = 'platform/admin_switch/init';
			}
			
            if ($val['uuid'] == $current_uuid) {
                $url = RC_Uri::url($url_first_pra, array('platform' => $platform, 'uuid' => $val['uuid']));
                echo '<li><a>' . $val['name'] . ' <i class=" fontello-icon-ok"></i></a></li>';
            } else {
                $url = RC_Uri::url($url_first_pra, array('platform' => $platform, 'uuid' => $val['uuid']));
                echo '<li><a class="ajaxswitch" href="' . $url . '">' . $val['name'] . '</a></li>';
            }
        }
        
        if (!empty($account_list)) {
            echo '<li class="divider"></li>';
        }

        if (trim($platform) == 'weapp') {
        	$list_url = RC_Uri::url('weapp/admin/init');
        	$add_url = RC_Uri::url('weapp/admin/add');
        	echo <<<EOF
				<li><a href="{$list_url}" target="_blank">小程序管理</a></li>
				<li><a href="{$add_url}" target="_blank">添加小程序</a></li>
			</ul>
		</div>
    </div>
	<br>
EOF;
        } else {
        	$list_url = RC_Uri::url('platform/admin/init');
        	$add_url = RC_Uri::url('platform/admin/add');
        	echo <<<EOF
				<li><a href="{$list_url}" target="_blank">公众号管理</a></li>
				<li><a href="{$add_url}" target="_blank">添加公众号</a></li>
			</ul>
		</div>
    </div>
	<br>
EOF;
	   } 
    }
}

// end