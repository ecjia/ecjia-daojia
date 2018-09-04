<?php
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


