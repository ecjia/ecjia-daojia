<?php

namespace Royalcms\Component\Mail;

use Aws\Ses\SesClient;
use Royalcms\Component\Support\Arr;
use Psr\Log\LoggerInterface;
use Royalcms\Component\Support\Manager;
use GuzzleHttp\Client as HttpClient;
use Swift_MailTransport as MailTransport;
use Swift_SmtpTransport as SmtpTransport;
use Royalcms\Component\Mail\Transport\LogTransport;
use Royalcms\Component\Mail\Transport\SesTransport;
use Royalcms\Component\Mail\Transport\ArrayTransport;
use Royalcms\Component\Mail\Transport\MailgunTransport;
use Royalcms\Component\Mail\Transport\MandrillTransport;
use Royalcms\Component\Mail\Transport\SparkPostTransport;
use Swift_SendmailTransport as SendmailTransport;

class TransportManager extends Manager
{
    /**
     * Create an instance of the SMTP Swift Transport driver.
     *
     * @return \Swift_SmtpTransport
     */
    protected function createSmtpDriver()
    {
        $config = $this->royalcms->make('config')->get('mail');

        // The Swift SMTP transport instance will allow us to use any SMTP backend
        // for delivering mail such as Sendgrid, Amazon SES, or a custom server
        // a developer has available. We will just pass this configured host.
        $transport = SmtpTransport::newInstance(
            $config['host'], $config['port']
        );

        if (isset($config['encryption'])) {
            $transport->setEncryption($config['encryption']);
        }

        // Once we have the transport we will check for the presence of a username
        // and password. If we have it we will set the credentials on the Swift
        // transporter instance so that we'll properly authenticate delivery.
        if (isset($config['username'])) {
            $transport->setUsername($config['username']);

            $transport->setPassword($config['password']);
        }

        // Next we will set any stream context options specified for the transport
        // and then return it. The option is not required any may not be inside
        // the configuration array at all so we'll verify that before adding.
        if (isset($config['stream'])) {
            $transport->setStreamOptions($config['stream']);
        }

        return $transport;
    }

    /**
     * Create an instance of the Sendmail Swift Transport driver.
     *
     * @return \Swift_SendmailTransport
     */
    protected function createSendmailDriver()
    {
        return SendmailTransport::newInstance(
            $this->royalcms['config']['mail']['sendmail']
        );
    }

    /**
     * Create an instance of the Amazon SES Swift Transport driver.
     *
     * @return \Swift_SendmailTransport
     */
    protected function createSesDriver()
    {
        $config = array_merge($this->royalcms['config']->get('services.ses', []), [
            'version' => 'latest', 'service' => 'email',
        ]);

        return new SesTransport(new SesClient(
            $this->addSesCredentials($config)
        ));
    }

    /**
     * Add the SES credentials to the configuration array.
     *
     * @param  array  $config
     * @return array
     */
    protected function addSesCredentials(array $config)
    {
        if ($config['key'] && $config['secret']) {
            $config['credentials'] = Arr::only($config, ['key', 'secret']);
        }

        return $config;
    }

    /**
     * Create an instance of the Mail Swift Transport driver.
     *
     * @return \Swift_MailTransport
     */
    protected function createMailDriver()
    {
        return MailTransport::newInstance();
    }

    /**
     * Create an instance of the Mailgun Swift Transport driver.
     *
     * @return \Royalcms\Component\Mail\Transport\MailgunTransport
     */
    protected function createMailgunDriver()
    {
        $config = $this->royalcms['config']->get('services.mailgun', []);

        return new MailgunTransport(
            $this->guzzle($config),
            $config['secret'], $config['domain']
        );
    }

    /**
     * Create an instance of the Mandrill Swift Transport driver.
     *
     * @return \Royalcms\Component\Mail\Transport\MandrillTransport
     */
    protected function createMandrillDriver()
    {
        $config = $this->royalcms['config']->get('services.mandrill', []);

        return new MandrillTransport(
            $this->guzzle($config), $config['secret']
        );
    }

    /**
     * Create an instance of the SparkPost Swift Transport driver.
     *
     * @return \Royalcms\Component\Mail\Transport\SparkPostTransport
     */
    protected function createSparkPostDriver()
    {
        $config = $this->royalcms['config']->get('services.sparkpost', []);

        return new SparkPostTransport(
            $this->guzzle($config), $config['secret'], Arr::get($config, 'options', [])
        );
    }

    /**
     * Create an instance of the Log Swift Transport driver.
     *
     * @return \Royalcms\Component\Mail\Transport\LogTransport
     */
    protected function createLogDriver()
    {
        return new LogTransport($this->royalcms->make(LoggerInterface::class));
    }

    /**
     * Create an instance of the Array Swift Transport Driver.
     *
     * @return \Royalcms\Component\Mail\Transport\ArrayTransport
     */
    protected function createArrayDriver()
    {
        return new ArrayTransport;
    }

    /**
     * Get a fresh Guzzle HTTP client instance.
     *
     * @param  array  $config
     * @return \GuzzleHttp\Client
     */
    protected function guzzle($config)
    {
        return new HttpClient(Arr::add(
            Arr::get($config, 'guzzle', []), 'connect_timeout', 60
        ));
    }

    /**
     * Get the default mail driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->royalcms['config']['mail.driver'];
    }

    /**
     * Set the default mail driver name.
     *
     * @param  string  $name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->royalcms['config']['mail.driver'] = $name;
    }

    public function resetDriver($driver)
    {
        // If the given driver has not been created before, we will create the instances
        // here and cache it so we can return it next time very quickly. If there is
        // already a driver created by this name, we'll just return that instance.
        if (isset($this->drivers[$driver])) {
            unset($this->drivers[$driver]);
            $this->drivers[$driver] = $this->createDriver($driver);
        }
    }
}
