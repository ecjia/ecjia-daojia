<?php

class Raven_Breadcrumbs_ErrorHandler
{
<<<<<<< HEAD
    private $existingHandler;
=======
    protected $existingHandler;
>>>>>>> v2-test

    /**
     * @var Raven_Client the client object that sends the message to the server
     */
    protected $ravenClient;

    /**
     * @param Raven_Client $ravenClient
<<<<<<< HEAD
     * @param int          $level       The minimum logging level at which this handler will be triggered
     * @param Boolean      $bubble      Whether the messages that are handled can bubble up the stack or not
=======
>>>>>>> v2-test
     */
    public function __construct(Raven_Client $ravenClient)
    {
        $this->ravenClient = $ravenClient;
    }

<<<<<<< HEAD
    public function handleError($code, $message, $file = '', $line = 0, $context=array())
=======
    public function handleError($code, $message, $file = '', $line = 0, $context = array())
>>>>>>> v2-test
    {
        $this->ravenClient->breadcrumbs->record(array(
            'category' => 'error_reporting',
            'message' => $message,
            'level' => $this->ravenClient->translateSeverity($code),
            'data' => array(
                'code' => $code,
                'line' => $line,
                'file' => $file,
            ),
        ));

        if ($this->existingHandler !== null) {
            return call_user_func($this->existingHandler, $code, $message, $file, $line, $context);
        } else {
            return false;
        }
    }

    public function install()
    {
        $this->existingHandler = set_error_handler(array($this, 'handleError'), E_ALL);
        return $this;
    }
}
