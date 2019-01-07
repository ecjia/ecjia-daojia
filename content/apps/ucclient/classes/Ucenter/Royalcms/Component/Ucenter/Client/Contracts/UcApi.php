<?php 

namespace Royalcms\Component\Ucenter\Client\Contracts;

interface UcApi
{
   
    /**
     * 此接口供仅测试连接。
     * 当 UCenter 发起 test 的接口请求时，如果成功获取到接口返回的 API_RETURN_SUCCEED 值，表示 UCenter 和应用通讯正常。
     */
    public  function test();

    /**
     * 删除用户
     * 当 UCenter 删除一个用户时，会发起 deleteuser 的接口请求，通知所有应用程序删除相应的用户。
     * 输入的参数放在 $get['ids'] 中，值为用逗号分隔的用户 ID。
     * 如果删除成功则输出 API_RETURN_SUCCEED。
     */
    public  function deleteuser();

    /**
     * 重命名用户
     * 当 UCenter 更改一个用户的用户名时，会发起 renameuser 的接口请求，通知所有应用程序改名。
     * 输入的参数 $get['uid'] 表示用户 ID，$get['oldusername'] 表示旧用户名，$get['newusername'] 表示新用户名。
     * 如果修改成功则输出 API_RETURN_SUCCEED。
     */
    public  function renameuser();

    /**
     * 更新密码
     * 当用户更改用户密码时，此接口负责接受 UCenter 发来的新密码。
     * 输入的参数 $get['username'] 表示用户名，$get['password'] 表示新密码。
     * 如果修改成功则输出 API_RETURN_SUCCEED。
     */
    public  function updatepw();

    /**
     * 同步登录
     * 如果应用程序需要和其他应用程序进行同步登录，此部分代码负责标记指定用户的登录状态。
     * 输入的参数放在 $get['uid'] 中，值为用户 ID。此接口为通知接口，无输出内容。
     * 同步登录需使用 P3P 标准。
     */
    public  function synlogin();

    /**
     * 同步退出
     * 如果应用程序需要和其他应用程序进行同步退出登录，此部分代码负责撤销用户的登录的状态。
     * 此接口为通知接口，无输入参数和输出内容。
     * 同步退出需使用 P3P 标准。
     */
    public  function synlogout();

}

// end
