<?php namespace Royalcms\Component\Mail;

use Closure;
use Swift_Mailer;
use Swift_Message;
use Royalcms\Component\Log\Writer;
use Royalcms\Component\View\Environment;
use Royalcms\Component\Queue\QueueManager;
use Royalcms\Component\Container\Container;
use Royalcms\Component\Support\SerializableClosure;
use Royalcms\Component\Error\Error;
use Royalcms\Component\Support\Facades\Logger;

class Mailer {

	/**
	 * The view environment instance.
	 *
	 * @var \Royalcms\Component\View\Environment
	 */
	protected $views;

	/**
	 * The Swift Mailer instance.
	 *
	 * @var \Swift_Mailer
	 */
	protected $swift;

	/**
	 * The global from address and name.
	 *
	 * @var array
	 */
	protected $from;

	/**
	 * The log writer instance.
	 *
	 * @var \Royalcms\Component\Log\Writer
	 */
	protected $logger;

	/**
	 * The IoC container instance.
	 *
	 * @var \Royalcms\Component\Container\Container
	 */
	protected $container;

	/**
	 * Indicates if the actual sending is disabled.
	 *
	 * @var bool
	 */
	protected $pretending = false;

	/**
	 * Array of failed recipients.
	 *
	 * @var array
	 */
	protected $failedRecipients = array();

	/**
	 * The QueueManager instance.
	 *
	 * @var \Royalcms\Component\Queue\QueueManager
	 */
	protected $queue;

	/**
	 * Create a new Mailer instance.
	 *
	 * @param  \Royalcms\Component\View\Environment  $views
	 * @param  \Swift_Mailer  $swift
	 * @return void
	 */
	public function __construct(Environment $views, Swift_Mailer $swift)
	{
		$this->views = $views;
		$this->swift = $swift;
	}

	/**
	 * Set the global from address and name.
	 *
	 * @param  string  $address
	 * @param  string  $name
	 * @return void
	 */
	public function alwaysFrom($address, $name = null)
	{
		$this->from = compact('address', 'name');
	}

	/**
	 * Send a new message when only a plain part.
	 *
	 * @param  string  $view
	 * @param  array   $data
	 * @param  mixed   $callback
	 * @return int
	 */
	public function plain($view, array $data, $callback)
	{
		return $this->send(array('text' => $view), $data, $callback);
	}

	/**
	 * Send a new message using a view.
	 *
	 * @param  string|array  $view
	 * @param  array  $data
	 * @param  Closure|string  $callback
	 * @return int
	 */
	public function send($view, array $data, $callback)
	{
		// First we need to parse the view, which could either be a string or an array
		// containing both an HTML and plain text versions of the view which should
		// be used when sending an e-mail. We will extract both of them out here.
		list($view, $plain) = $this->parseView($view);

		$data['message'] = $message = $this->createMessage();

		$this->callMessageBuilder($callback, $message);

		// Once we have retrieved the view content for the e-mail we will set the body
		// of this message using the HTML type, which will provide a simple wrapper
		// to creating view based emails that are able to receive arrays of data.
		$this->addContent($message, $view, $plain, $data);

		$message = $message->getSwiftMessage();

		return $this->sendSwiftMessage($message);
	}
	
	/**
	 * Send a new message using a callback.
	 * 
	 * @param  string  $plain
	 * @param  Closure|string  $callback
	 * @return int
	 */
	public function sendMessage($callback) {
	    $message = $this->createMessage();
	    
	    $this->callMessageBuilder($callback, $message);
	    
	    $message = $message->getSwiftMessage();
	    
	    return $this->sendSwiftMessage($message);
	}

	/**
	 * Queue a new e-mail message for sending.
	 *
	 * @param  string|array  $view
	 * @param  array   $data
	 * @param  Closure|string  $callback
	 * @param  string  $queue
	 * @return void
	 */
	public function queue($view, array $data, $callback, $queue = null)
	{
		$callback = $this->buildQueueCallable($callback);

		$this->queue->push('mailer@handleQueuedMessage', compact('view', 'data', 'callback'), $queue);
	}

	/**
	 * Queue a new e-mail message for sending on the given queue.
	 *
	 * @param  string  $queue
	 * @param  string|array  $view
	 * @param  array   $data
	 * @param  Closure|string  $callback
	 * @return void
	 */
	public function queueOn($queue, $view, array $data, $callback)
	{
		$this->queue($view, $data, $callback, $queue);
	}

	/**
	 * Queue a new e-mail message for sending after (n) seconds.
	 *
	 * @param  int  $delay
	 * @param  string|array  $view
	 * @param  array  $data
	 * @param  Closure|string  $callback
	 * @param  string  $queue
	 * @return void
	 */
	public function later($delay, $view, array $data, $callback, $queue = null)
	{
		$callback = $this->buildQueueCallable($callback);

		$this->queue->later($delay, 'mailer@handleQueuedMessage', compact('view', 'data', 'callback'), $queue);
	}

	/**
	 * Queue a new e-mail message for sending after (n) seconds on the given queue.
	 *
	 * @param  string  $queue
	 * @param  int  $delay
	 * @param  string|array  $view
	 * @param  array  $data
	 * @param  Closure|string  $callback
	 * @return void
	 */
	public function laterOn($queue, $delay, $view, array $data, $callback)
	{
		$this->later($delay, $view, $data, $callback, $queue);
	}

	/**
	 * Build the callable for a queued e-mail job.
	 *
	 * @param  mixed  $callback
	 * @return mixed
	 */
	protected function buildQueueCallable($callback)
	{
		if ( ! $callback instanceof Closure) return $callback;

		return serialize(new SerializableClosure($callback));
	}

	/**
	 * Handle a queued e-mail message job.
	 *
	 * @param  \Royalcms\Component\Queue\Jobs\Job  $job
	 * @param  array  $data
	 * @return void
	 */
	public function handleQueuedMessage($job, $data)
	{
		$this->send($data['view'], $data['data'], $this->getQueuedCallable($data));

		$job->delete();
	}

	/**
	 * Get the true callable for a queued e-mail message.
	 *
	 * @param  array  $data
	 * @return mixed
	 */
	protected function getQueuedCallable(array $data)
	{
		if (str_contains($data['callback'], 'SerializableClosure'))
		{
			return with(unserialize($data['callback']))->getClosure();
		}

		return $data['callback'];
	}

	/**
	 * Add the content to a given message.
	 *
	 * @param  \Royalcms\Component\Mail\Message  $message
	 * @param  string  $view
	 * @param  string  $plain
	 * @param  array   $data
	 * @return void
	 */
	protected function addContent($message, $view, $plain, $data)
	{
		if (isset($view))
		{
			$message->setBody($this->getView($view, $data), 'text/html');
		}

		if (isset($plain))
		{
			$message->addPart($this->getView($plain, $data), 'text/plain');
		}
	}

	/**
	 * Parse the given view name or array.
	 *
	 * @param  string|array  $view
	 * @return array
	 *
	 * @throws \InvalidArgumentException
	 */
	protected function parseView($view)
	{
		if (is_string($view)) return array($view, null);

		// If the given view is an array with numeric keys, we will just assume that
		// both a "pretty" and "plain" view were provided, so we will return this
		// array as is, since must should contain both views with numeric keys.
		if (is_array($view) && isset($view[0]))
		{
			return $view;
		}

		// If the view is an array, but doesn't contain numeric keys, we will assume
		// the the views are being explicitly specified and will extract them via
		// named keys instead, allowing the developers to use one or the other.
		elseif (is_array($view))
		{
			return array(
				array_get($view, 'html'), array_get($view, 'text')
			);
		}

		throw new \InvalidArgumentException("Invalid view.");
	}

	/**
	 * Send a Swift Message instance.
	 *
	 * @param  \Swift_Message  $message
	 * @return int
	 */
	protected function sendSwiftMessage($message)
	{
		if ( ! $this->pretending)
		{
			return $this->swift->send($message, $this->failedRecipients);
		}
		elseif (isset($this->logger))
		{
			$this->logMessage($message);

			return 1;
		}
	}

	/**
	 * Log that a message was sent.
	 *
	 * @param  \Swift_Message  $message
	 * @return void
	 */
	protected function logMessage($message)
	{
		$emails = implode(', ', array_keys((array) $message->getTo()));

		$this->logger->info("Pretending to mail message to: {$emails}");
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
		if ($callback instanceof Closure)
		{
			return call_user_func($callback, $message);
		}
		elseif (is_string($callback))
		{
			return $this->container[$callback]->mail($message);
		}

		throw new \InvalidArgumentException("Callback is not valid.");
	}

	/**
	 * Create a new message instance.
	 *
	 * @return \Royalcms\Component\Mail\Message
	 */
	protected function createMessage()
	{
		$message = new Message(new Swift_Message);

		// If a global from address has been specified we will set it on every message
		// instances so the developer does not have to repeat themselves every time
		// they create a new message. We will just go ahead and push the address.
		if (isset($this->from['address']))
		{
			$message->from($this->from['address'], $this->from['name']);
		}

		return $message;
	}

	/**
	 * Render the given view.
	 *
	 * @param  string  $view
	 * @param  array   $data
	 * @return \Royalcms\Component\View\View
	 */
	protected function getView($view, $data)
	{
		return $this->views->make($view, $data)->render();
	}

	/**
	 * Tell the mailer to not really send messages.
	 *
	 * @param  bool  $value
	 * @return void
	 */
	public function pretend($value = true)
	{
		$this->pretending = $value;
	}

	/**
	 * Get the view environment instance.
	 *
	 * @return \Royalcms\Component\View\Environment
	 */
	public function getViewEnvironment()
	{
		return $this->views;
	}

	/**
	 * Get the Swift Mailer instance.
	 *
	 * @return \Swift_Mailer
	 */
	public function getSwiftMailer()
	{
		return $this->swift;
	}

	/**
	 * Get the array of failed recipients.
	 *
	 * @return array
	 */
	public function failures()
	{
		return $this->failedRecipients;
	}

	/**
	 * Set the Swift Mailer instance.
	 *
	 * @param  \Swift_Mailer  $swift
	 * @return void
	 */
	public function setSwiftMailer($swift)
	{
		$this->swift = $swift;
	}

	/**
	 * Set the log writer instance.
	 *
	 * @param  \Royalcms\Component\Log\Writer  $logger
	 * @return \Royalcms\Component\Mail\Mailer 
	 */
	public function setLogger(Writer $logger)
	{
		$this->logger = $logger;

		return $this;
	}

	/**
	 * Set the queue manager instance.
	 *
	 * @param  \Royalcms\Component\Queue\QueueManager  $queue
	 * @return \Royalcms\Component\Mail\Mailer
	 */
	public function setQueue(QueueManager $queue)
	{
		$this->queue = $queue;

		return $this;
	}

	/**
	 * Set the IoC container instance.
	 *
	 * @param  \Royalcms\Component\Container\Container  $container
	 * @return void
	 */
	public function setContainer(Container $container)
	{
		$this->container = $container;
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
	        $recipients = $this->sendMessage(function($m) use ($config, $email, $name, $subject, $content, $type, $notification) {
	            $m->from($config->get('mail.from.address'), $config->get('mail.from.name'));
	            $m->to($email, $name)->subject($subject);
	
	            if ($config->has('mail.charset')) {
	                $m->charset($config->get('mail.charset'));
	            }
	
	            // Set email format to HTML
	            if ($type) {
	                $m->body($content, 'text/html');
	            } else {
	                $m->body($content, 'text/plain');
	            }
	
	            if ($notification) {
	                $m->setReadReceiptTo($config->get('mail.from.address'));
	            }
	        });

	        if ($recipients) {
	            return true;
	        } else {
	            return new Error('send_mail_failed', 'Failed to send mail message!');
	        }        
	    }
	    catch (\Swift_TransportException $exception) {
	        $err = array(
	            'file'      => $exception->getFile(),
	            'line'      => $exception->getLine(),
	            'code'      => $exception->getCode(),
	            'url'       => royalcms('request')->fullUrl(),
	        );
	        Logger::getLogger(Logger::LOG_ERROR)->error($exception->getMessage(), $err);
	        return new Error('send_mail_transport_exception', 'Mailer Error: ' . $exception->getMessage());
	    }
	    catch (\Exception $exception) {
	        $err = array(
	            'file'      => $exception->getFile(),
	            'line'      => $exception->getLine(),
	            'code'      => $exception->getCode(),
	            'url'       => royalcms('request')->fullUrl(),
	        );
	        Logger::getLogger(Logger::LOG_ERROR)->error($exception->getMessage(), $err);
	        return new Error('send_mail_error', 'Mailer Error: ' . $exception->getMessage());
	    }
	}

}
