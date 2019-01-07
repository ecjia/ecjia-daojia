<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/17
 * Time: 11:45 AM
 */

namespace Royalcms\Component\Ucenter\Client\Traits;


trait CompatibleTrait
{

    /**
     *
     */
    public function uc_app_ls()
    {

    }

    /**
     * @param $icon
     * @param $uid
     * @param $username
     * @param string $title_template
     * @param string $title_data
     * @param string $body_template
     * @param string $body_data
     * @param string $body_general
     * @param string $target_ids
     * @param array $images
     */
    public function uc_feed_add($icon, $uid, $username, $title_template = '', $title_data = '', $body_template = '', $body_data = '', $body_general = '', $target_ids = '', $images = array())
    {

    }

    /**
     * @param int $limit
     * @param bool $delete
     */
    public function uc_feed_get($limit = 100, $delete = TRUE)
    {

    }

    /**
     * @param $uid
     * @param $friendid
     * @param string $comment
     */
    public function uc_friend_add($uid, $friendid, $comment = '')
    {

    }

    /**
     * @param $uid
     * @param $friendids
     */
    public function uc_friend_delete($uid, $friendids)
    {

    }

    /**
     * @param $uid
     * @param int $direction
     */
    public function uc_friend_totalnum($uid, $direction = 0)
    {

    }

    /**
     * @param $uid
     * @param int $page
     * @param int $pagesize
     * @param int $totalnum
     * @param int $direction
     */
    public function uc_friend_ls($uid, $page = 1, $pagesize = 10, $totalnum = 10, $direction = 0)
    {

    }

    /**
     * @param $username
     * @param $password
     * @param $email
     * @param string $questionid
     * @param string $answer
     * @param string $regip
     */
    public function uc_user_register($username, $password, $email, $questionid = '', $answer = '', $regip = '')
    {
        return $this->ucUserRegister($username, $password, $email, $questionid, $answer, $regip);
    }

    /**
     * @param $username
     * @param $password
     * @param int $isuid
     * @param int $checkques
     * @param string $questionid
     * @param string $answer
     */
    public function uc_user_login($username, $password, $isuid = 0, $checkques = 0, $questionid = '', $answer = '')
    {
        return $this->ucUserLogin($username, $password, $isuid, $checkques, $questionid, $answer);
    }

    /**
     * @param $uid
     */
    public function uc_user_synlogin($uid)
    {
        return $this->ucUserSynlogin($uid);
    }

    /**
     *
     */
    public function uc_user_synlogout()
    {
        return $this->ucUserSynlogout();
    }

    /**
     * @param $username
     * @param $oldpw
     * @param $newpw
     * @param $email
     * @param int $ignoreoldpw
     * @param string $questionid
     * @param string $answer
     */
    public function uc_user_edit($username, $oldpw, $newpw, $email, $ignoreoldpw = 0, $questionid = '', $answer = '')
    {
        return $this->ucUserEdit($username, $oldpw, $newpw, $email, $ignoreoldpw, $questionid, $answer);
    }

    /**
     * @param $uid
     */
    public function uc_user_delete($uid)
    {
        return $this->ucUserDelete($uid);
    }

    /**
     * @param $uid
     */
    public function uc_user_deleteavatar($uid)
    {
        return $this->ucUserDeleteAvatar($uid);
    }

    /**
     * @param $username
     */
    public function uc_user_checkname($username)
    {
        return $this->ucUserCheckName($username);
    }

    /**
     * @param $email
     */
    public function uc_user_checkemail($email)
    {
        return $this->ucUserCheckEmail($email);
    }

    /**
     * @param $username
     * @param string $admin
     */
    public function uc_user_addprotected($username, $admin = '')
    {

    }

    /**
     * @param $username
     */
    public function uc_user_deleteprotected($username)
    {

    }

    /**
     *
     */
    public function uc_user_getprotected()
    {

    }

    /**
     * @param $username
     * @param int $isuid
     */
    public function uc_get_user($username, $isuid = 0)
    {
        return $this->ucGetUser($username, $isuid);
    }

    /**
     * @param $oldusername
     * @param $newusername
     * @param $uid
     * @param $password
     * @param $email
     */
    public function uc_user_merge($oldusername, $newusername, $uid, $password, $email)
    {
        return $this->ucUserMerge($oldusername, $newusername, $uid, $password, $email);
    }

    /**
     * @param $username
     */
    public function uc_user_merge_remove($username)
    {
        return $this->ucUserMergeRemove($username);
    }

    /**
     * @param $appid
     * @param $uid
     * @param $credit
     */
    public function uc_user_getcredit($appid, $uid, $credit)
    {

    }

    /**
     * @param $uid
     * @param int $newpm
     */
    public function uc_pm_location($uid, $newpm = 0)
    {

    }

    /**
     * @param $uid
     * @param int $more
     */
    public function uc_pm_checknew($uid, $more = 0)
    {

    }

    /**
     * @param $fromuid
     * @param $msgto
     * @param $subject
     * @param $message
     * @param int $instantly
     * @param int $replypmid
     * @param int $isusername
     * @param int $type
     */
    public function uc_pm_send($fromuid, $msgto, $subject, $message, $instantly = 1, $replypmid = 0, $isusername = 0, $type = 0)
    {

    }

    /**
     * @param $uid
     * @param $folder
     * @param $pmids
     */
    public function uc_pm_delete($uid, $folder, $pmids)
    {

    }

    /**
     * @param $uid
     * @param $touids
     */
    public function uc_pm_deleteuser($uid, $touids)
    {


    }

    /**
     * @param $uid
     * @param $plids
     * @param int $type
     */
    public function uc_pm_deletechat($uid, $plids, $type = 0)
    {

    }

    /**
     * @param $uid
     * @param $uids
     * @param array $plids
     * @param int $status
     */
    public function uc_pm_readstatus($uid, $uids, $plids = array(), $status = 0)
    {

    }

    /**
     * @param $uid
     * @param int $page
     * @param int $pagesize
     * @param string $folder
     * @param string $filter
     * @param int $msglen
     */
    public function uc_pm_list($uid, $page = 1, $pagesize = 10, $folder = 'inbox', $filter = 'newpm', $msglen = 0)
    {

    }

    /**
     * @param $uid
     */
    public function uc_pm_ignore($uid)
    {

    }

    /**
     * @param $uid
     * @param int $pmid
     * @param int $touid
     * @param int $daterange
     * @param int $page
     * @param int $pagesize
     * @param int $type
     * @param int $isplid
     */
    public function uc_pm_view($uid, $pmid = 0, $touid = 0, $daterange = 1, $page = 0, $pagesize = 10, $type = 0, $isplid = 0)
    {

    }

    /**
     * @param $uid
     * @param $touid
     * @param $isplid
     */
    public function uc_pm_view_num($uid, $touid, $isplid)
    {

    }

    /**
     * @param $uid
     * @param $type
     * @param $pmid
     */
    public function uc_pm_viewnode($uid, $type, $pmid)
    {

    }

    /**
     * @param $uid
     * @param int $plid
     */
    public function uc_pm_chatpmmemberlist($uid, $plid = 0)
    {

    }

    /**
     * @param $plid
     * @param $uid
     * @param $touid
     */
    public function uc_pm_kickchatpm($plid, $uid, $touid)
    {

    }

    /**
     * @param $plid
     * @param $uid
     * @param $touid
     */
    public function uc_pm_appendchatpm($plid, $uid, $touid)
    {

    }

    /**
     * @param $uid
     */
    public function uc_pm_blackls_get($uid)
    {

    }

    /**
     * @param $uid
     * @param $blackls
     */
    public function uc_pm_blackls_set($uid, $blackls)
    {

    }

    /**
     * @param $uid
     * @param $username
     */
    public function uc_pm_blackls_add($uid, $username)
    {

    }

    /**
     * @param $uid
     * @param $username
     */
    public function uc_pm_blackls_delete($uid, $username)
    {

    }

    /**
     *
     */
    public function uc_domain_ls()
    {

    }

    /**
     * @param $uid
     * @param $from
     * @param $to
     * @param $toappid
     * @param $amount
     */
    public function uc_credit_exchange_request($uid, $from, $to, $toappid, $amount)
    {

    }

    /**
     * @param $tagname
     * @param int $nums
     */
    public function uc_tag_get($tagname, $nums = 0)
    {

    }

    /**
     * @param $uid
     * @param string $type
     * @param int $returnhtml
     */
    public function uc_avatar($uid, $type = 'virtual', $returnhtml = 1)
    {

    }

    /**
     * @param $uids
     * @param $emails
     * @param $subject
     * @param $message
     * @param string $frommail
     * @param string $charset
     * @param bool $htmlon
     * @param int $level
     */
    public function uc_mail_queue($uids, $emails, $subject, $message, $frommail = '', $charset = 'utf-8', $htmlon = FALSE, $level = 1)
    {

    }

    /**
     * @param $uid
     * @param string $size
     * @param string $type
     */
    public function uc_check_avatar($uid, $size = 'middle', $type = 'virtual')
    {
        return $this->ucCheckAvatar($uid, $size, $type);
    }

    /**
     *
     */
    public function uc_check_version()
    {
        return $this->ucCheckVersion();
    }

}