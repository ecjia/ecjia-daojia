<?php 

namespace Royalcms\Component\Ucenter\Controllers;

use App\Http\Controllers\Controller;
use Binaryoung\Ucenter\Contracts\Api;
use Request,Config;
use Binaryoung\Ucenter\Services\Help;

class ApiController extends Controller 
{
    use Help;

	public function __construct()
	{
        if (!defined('UC_KEY')) {
    		define('UC_CLIENT_VERSION', '1.6.0');    //note UCenter 版本标识
    		define('UC_CLIENT_RELEASE', '20110501');

    		define('API_RETURN_SUCCEED', 1);
    		define('API_RETURN_FAILED', -1);
    		define('API_RETURN_FORBIDDEN', -2);

    		define('UC_KEY', Config::get('ucenter.key'));

    		define('API_ROOT', __DIR__.'/../');
        }
	}

	public function run(Api $api)
	{
        $code = Request::input('code');
        parse_str(self::authcode($code, 'DECODE', UC_KEY), $get);

        if (empty($get)) {
            return 'Invalid Request';
        } elseif (time() - $get['time'] > 3600) {
            return 'Authracation has expiried';
        }
        
        $action = $get['action'];
        
        $actionList = [
            'test',
            'deleteuser',
            'renameuser',
            'updatepw',
            'gettag',
            'synlogin',
            'synlogout',
            'updatebadwords',
            'updatehosts',
            'updateapps',
            'updateclient',
            'updatecredit',
            'getcreditsettings',
            'updatecreditsettings',
            'getcredit',
        ];
        
        if (in_array($action, $actionList) && method_exists($api, $action)) {
        	
            $post = self::unserialize(file_get_contents('php://input'));

            $api->get = $get;
            $api->post = $post;

            return $api->$action();
        } else {
            return API_RETURN_FAILED;
        }
	}
}