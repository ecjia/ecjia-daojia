<?php namespace Royalcms\Component\Mail;

use Closure;
use Swift_Mailer;
use Swift_Transport;
use Swift_SmtpTransport as SmtpTransport;
use Swift_MailTransport as MailTransport;
use Swift_SendmailTransport as SendmailTransport;

class MailManager {
    /**
     * The application instance.
     *
     * @var \Royalcms\Component\Support\Contracts\Foundation\Royalcms
     */
    protected $royalcms;
    
    /**
     * The array of resolved filesystem drivers.
     *
     * @var array
     */
    protected $drive = array();
    
    /**
     * The registered custom driver creators.
     *
     * @var array
     */
    protected $customCreators = array();
    
    /**
     * Create a new filesystem manager instance.
     *
     * @param  \Royalcms\Component\Support\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        $this->royalcms = $royalcms;
    }
    
    /**
     * Get a filesystem instance.
     *
     * @param  string  $name
     * @return \Swift_Transport
     */
    public function drive($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();
        
		return $this->drive[$name] = $this->get($name);
    }
    
    /**
     * Attempt to get the disk from the local cache.
     *
     * @param  string  $name
     * @return \Swift_Transport
     */
    protected function get($name)
    {
        return isset($this->drive[$name]) ? $this->drive[$name] : $this->resolve($name);
    }
    
    /**
     * Resolve the given driver.
     *
     * @param  string  $driver
     * @return \Swift_Transport
     */
    protected function resolve($driver)
    {
        $config = $this->royalcms['config']['mail'];

        $method = "create".ucfirst($driver)."Transport";
    
        if (isset($this->customCreators[$driver]))
        {
            return $this->callCustomCreator($config);
        }
        elseif (method_exists($this, $method))
		{
			return $this->$method($config);
		}
		
        throw new \InvalidArgumentException("Driver [$driver] not supported.");
    }
    
    
    /**
     * Register the SMTP Swift Transport instance.
     *
     * @param  array  $config
     * @return \SmtpTransport
     */
    public function createSmtpTransport(array $config)
    {
        $host = $port = $username = $password = $encryption = null;
        extract($config);
        
        // The Swift SMTP transport instance will allow us to use any SMTP backend
        // for delivering mail such as Sendgrid, Amazon SMS, or a custom server
        // a developer has available. We will just pass this configured host.
        $transport = SmtpTransport::newInstance($host, $port);
        
        if (isset($encryption))
        {
            $transport->setEncryption($encryption);
        }
        
        // Once we have the transport we will check for the presence of a username
        // and password. If we have it we will set the credentials on the Swift
        // transporter instance so that we'll properly authenticate delivery.
        if (isset($username))
        {
            $transport->setUsername($username);
        
            $transport->setPassword($password);
        }
        
        return $transport;
    }
    
    /**
     * Register the Sendmail Swift Transport instance.
     *
     * @param  array  $config
     * @return \SendmailTransport
     */
    public function createSendmailTransport(array $config)
    {
        return SendmailTransport::newInstance($config['sendmail']);
    }
    
    /**
     * Register the Mail Swift Transport instance.
     *
     * @param  array  $config
     * @return \MailTransport
     */
    public function createMailTransport(array $config)
    {
        return MailTransport::newInstance();
    }
    
    /**
     * Call a custom driver creator.
     *
     * @param  array  $config
     * @return \Swift_Transport
     */
    protected function callCustomCreator(array $config)
    {
        $driver = $this->customCreators[$config['driver']]($this->royalcms, $config);
    
        if ($driver instanceof Swift_Transport)
        {
            return $driver;
        }
        
        return null;
    }
    
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->royalcms['config']['mail.driver'];
    }
    
    /**
     * Register a custom driver creator Closure.
     *
     * @param  string    $driver
     * @param  \Closure  $callback
     * @return $this
     */
    public function extend($driver, Closure $callback)
    {
        $this->customCreators[$driver] = $callback;
    
        return $this;
    }
    
    /**
     * Dynamically call the default driver instance.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->drive(), $method), $parameters);
    }
}

// end
