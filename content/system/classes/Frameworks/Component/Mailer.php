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
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/8/31
 * Time: 11:59 AM
 */

namespace Ecjia\System\Frameworks\Component;

use Closure;
use Royalcms\Component\Mail\Mailer as RoyalcmsMailer;
use Royalcms\Component\Mail\TransportManager;
use RC_Error;
use RC_Logger;
use RC_Hook;
use ecjia;

class Mailer
{

    protected $royalcms_mailer;

    protected static $swift_mailer;

    public function __construct(RoyalcmsMailer $mailer)
    {
        $this->royalcms_mailer = $mailer;

        if (is_null(self::$swift_mailer)) {
            if (config('mail.driver') == 'smtp') {
                $driver = 'smtp';
            } else {
                $driver = 'sendmail';
            }
            $this->registerSwiftMailer($driver);
        }

    }

    /**
     * Send a new message using a callback.
     *
     * @param  string  $plain
     * @param  Closure|string  $callback
     * @return int
     */
    public function sendMessage($callback) {
        $message = $this->royalcms_mailer->createMessage();

        $this->callMessageBuilder($callback, $message);

        $message = $message->getSwiftMessage();

        return $this->royalcms_mailer->sendSwiftMessage($message);
    }


    /**
     * Call the provided message builder.
     *
     * @param  Closure|string  $callback
     * @param  \Royalcms\Component\Mail\Message  $message
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    protected function callMessageBuilder($callback, $message)
    {
        return call_user_func($callback, $message);
    }

    /**
     * 邮件发送
     *
     * @param string    $name           接收人姓名
     * @param string    $email          接收人邮件地址
     * @param string    $subject        邮件标题
     * @param string    $content        邮件内容
     * @param int       $type           0 普通邮件， 1 HTML邮件
     * @param bool      $notification   true 要求回执， false 不用回执
     *
     * @return boolean
     */
    public function send_mail($name, $email, $subject, $content, $type = 0, $notification = false) {

        $config = royalcms('config');

        try {
            $recipients = $this->sendMessage(function($message) use ($config, $email, $name, $subject, $content, $type, $notification) {
                $message->from($config->get('mail.from.address'), $config->get('mail.from.name'));
                $message->sender($config->get('mail.from.address'), $config->get('mail.from.name'));
                $message->to($email, $name);
                $message->subject($subject);

                if ($config->has('mail.charset')) {
                    $message->charset($config->get('mail.charset'));
                }

                // Set email format to HTML
                if ($type) {
                    $message->setBody($content, 'text/html');
                } else {
                    $message->setBody($content, 'text/plain');
                }

                if ($notification) {
                    $message->setReadReceiptTo($config->get('mail.from.address'));
                }
            });

            if ($recipients) {
                return true;
            } else {
                return RC_Error::make('send_mail_failed', 'Failed to send mail message!');
            }
        }
        catch (\Swift_TransportException $exception) {
            $err = array(
                'file'      => $exception->getFile(),
                'line'      => $exception->getLine(),
                'code'      => $exception->getCode(),
                'url'       => royalcms('request')->fullUrl(),
            );
            RC_Logger::getLogger(RC_Logger::LOG_ERROR)->error($exception->getMessage(), $err);
            return RC_Error::make('send_mail_transport_exception', 'Mailer Error: ' . $exception->getMessage());
        }
        catch (\Exception $exception) {
            $err = array(
                'file'      => $exception->getFile(),
                'line'      => $exception->getLine(),
                'code'      => $exception->getCode(),
                'url'       => royalcms('request')->fullUrl(),
            );
            RC_Logger::getLogger(RC_Logger::LOG_ERROR)->error($exception->getMessage(), $err);
            return RC_Error::make('send_mail_error', 'Mailer Error: ' . $exception->getMessage());
        }
    }


    public static function ecjia_mail_config($config = [])
    {

        if (empty($config)) {
            $config = [
                'smtp_host'     => ecjia::config('smtp_host'),
                'smtp_port'     => ecjia::config('smtp_port'),
                'smtp_mail'     => ecjia::config('smtp_mail'),
                'shop_name'     => ecjia::config('shop_name'),
                'smtp_user'     => ecjia::config('smtp_user'),
                'smtp_pass'     => ecjia::config('smtp_pass'),
                'smtp_ssl'      => ecjia::config('smtp_ssl'),
                'mail_charset'  => ecjia::config('mail_charset'),
                'mail_service'  => ecjia::config('mail_service'),
            ];
        }

        if (empty($config['shop_name'])) {
            $config['shop_name'] = ecjia::config('shop_name');
        }

        royalcms('config')->set('mail.host',        array_get($config, 'smtp_host'));
        royalcms('config')->set('mail.port',        array_get($config, 'smtp_port'));
        royalcms('config')->set('mail.from.address', array_get($config, 'smtp_mail'));
        royalcms('config')->set('mail.from.name',   array_get($config, 'shop_name'));
        royalcms('config')->set('mail.username',    array_get($config, 'smtp_user'));
        royalcms('config')->set('mail.password',    array_get($config, 'smtp_pass'));
        royalcms('config')->set('mail.charset',     array_get($config, 'mail_charset'));

        if (intval(array_get($config, 'smtp_ssl')) === 1) {
            royalcms('config')->set('mail.encryption', 'ssl');
        } else {
            royalcms('config')->set('mail.encryption', 'tcp');
        }

        if (intval(array_get($config, 'mail_service')) === 1) {
            royalcms('config')->set('mail.driver', 'smtp');
        } else {
            royalcms('config')->set('mail.driver', 'mail');
        }

    }

    /**
     * Register the Swift Transport instance.
     *
     * @return void
     */
    protected function registerSwiftMailer($driver)
    {
        RC_Hook::do_action('reset_mail_config');

        $royalcms = royalcms();

        $royalcms['swift.transport']->resetDriver($driver);

        $royalcms->bindShared('swift.mailer', function ($royalcms) {
            return \Swift_Mailer::newInstance($royalcms['swift.transport']->driver());
        });

        $this->royalcms_mailer->setSwiftMailer($royalcms['swift.mailer']);

        self::$swift_mailer = $royalcms['swift.mailer'];
    }

}


