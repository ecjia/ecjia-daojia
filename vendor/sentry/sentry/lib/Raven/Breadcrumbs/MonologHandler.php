<?php

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class Raven_Breadcrumbs_MonologHandler extends AbstractProcessingHandler
{
    /**
     * Translates Monolog log levels to Raven log levels.
     */
<<<<<<< HEAD
    private $logLevels = array(
=======
    protected $logLevels = array(
>>>>>>> v2-test
        Logger::DEBUG     => Raven_Client::DEBUG,
        Logger::INFO      => Raven_Client::INFO,
        Logger::NOTICE    => Raven_Client::INFO,
        Logger::WARNING   => Raven_Client::WARNING,
        Logger::ERROR     => Raven_Client::ERROR,
        Logger::CRITICAL  => Raven_Client::FATAL,
        Logger::ALERT     => Raven_Client::FATAL,
        Logger::EMERGENCY => Raven_Client::FATAL,
    );

<<<<<<< HEAD
    private $excMatch = '/^exception \'([^\']+)\' with message \'(.+)\' in .+$/s';
=======
    protected $excMatch = '/^exception \'([^\']+)\' with message \'(.+)\' in .+$/s';
>>>>>>> v2-test

    /**
     * @var Raven_Client the client object that sends the message to the server
     */
    protected $ravenClient;

    /**
     * @param Raven_Client $ravenClient
     * @param int          $level       The minimum logging level at which this handler will be triggered
<<<<<<< HEAD
     * @param Boolean      $bubble      Whether the messages that are handled can bubble up the stack or not
=======
     * @param bool         $bubble      Whether the messages that are handled can bubble up the stack or not
>>>>>>> v2-test
     */
    public function __construct(Raven_Client $ravenClient, $level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->ravenClient = $ravenClient;
    }

<<<<<<< HEAD
    protected function parseException($message)
    {
        if (!preg_match($this->excMatch, $message, $matches)) {
            return;
        }

        return array($matches[1], $matches[2]);
=======
    /**
     * @param string $message
     * @return array|null
     */
    protected function parseException($message)
    {
        if (preg_match($this->excMatch, $message, $matches)) {
            return array($matches[1], $matches[2]);
        }

        return null;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        // sentry uses the 'nobreadcrumb' attribute to skip reporting
        if (!empty($record['context']['nobreadcrumb'])) {
            return;
        }

<<<<<<< HEAD
        if (isset($record['context']['exception']) && $record['context']['exception'] instanceof \Exception) {
=======
        if (isset($record['context']['exception']) && ($record['context']['exception'] instanceof \Exception || (PHP_VERSION_ID >= 70000 && $record['context']['exception'] instanceof \Throwable))) {
            /**
             * @var \Exception|\Throwable $exc
             */
>>>>>>> v2-test
            $exc = $record['context']['exception'];
            $crumb = array(
                'type' => 'error',
                'level' => $this->logLevels[$record['level']],
                'category' => $record['channel'],
                'data' => array(
                    'type' => get_class($exc),
                    'value' => $exc->getMessage(),
                ),
            );
        } else {
            // TODO(dcramer): parse exceptions out of messages and format as above
            if ($error = $this->parseException($record['message'])) {
                $crumb = array(
                    'type' => 'error',
                    'level' => $this->logLevels[$record['level']],
                    'category' => $record['channel'],
                    'data' => array(
                        'type' => $error[0],
                        'value' => $error[1],
                    ),
                );
            } else {
                $crumb = array(
                    'level' => $this->logLevels[$record['level']],
                    'category' => $record['channel'],
                    'message' => $record['message'],
<<<<<<< HEAD
=======
                    'data' => $record['context'],
>>>>>>> v2-test
                );
            }
        }

        $this->ravenClient->breadcrumbs->record($crumb);
    }
}
