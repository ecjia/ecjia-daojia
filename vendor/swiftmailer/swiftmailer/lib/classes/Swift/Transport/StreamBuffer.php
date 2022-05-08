<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A generic IoBuffer implementation supporting remote sockets and local processes.
 *
<<<<<<< HEAD
 * @author Chris Corbyn
=======
 * @author     Chris Corbyn
>>>>>>> v2-test
 */
class Swift_Transport_StreamBuffer extends Swift_ByteStream_AbstractFilterableInputStream implements Swift_Transport_IoBuffer
{
    /** A primary socket */
<<<<<<< HEAD
    private $_stream;

    /** The input stream */
    private $_in;

    /** The output stream */
    private $_out;

    /** Buffer initialization parameters */
    private $_params = array();

    /** The ReplacementFilterFactory */
    private $_replacementFactory;

    /** Translations performed on data being streamed into the buffer */
    private $_translations = array();

    /**
     * Create a new StreamBuffer using $replacementFactory for transformations.
     *
     * @param Swift_ReplacementFilterFactory $replacementFactory
     */
    public function __construct(Swift_ReplacementFilterFactory $replacementFactory)
    {
        $this->_replacementFactory = $replacementFactory;
=======
    private $stream;

    /** The input stream */
    private $in;

    /** The output stream */
    private $out;

    /** Buffer initialization parameters */
    private $params = [];

    /** The ReplacementFilterFactory */
    private $replacementFactory;

    /** Translations performed on data being streamed into the buffer */
    private $translations = [];

    /**
     * Create a new StreamBuffer using $replacementFactory for transformations.
     */
    public function __construct(Swift_ReplacementFilterFactory $replacementFactory)
    {
        $this->replacementFactory = $replacementFactory;
>>>>>>> v2-test
    }

    /**
     * Perform any initialization needed, using the given $params.
     *
     * Parameters will vary depending upon the type of IoBuffer used.
<<<<<<< HEAD
     *
     * @param array $params
     */
    public function initialize(array $params)
    {
        $this->_params = $params;
        switch ($params['type']) {
            case self::TYPE_PROCESS:
                $this->_establishProcessConnection();
                break;
            case self::TYPE_SOCKET:
            default:
                $this->_establishSocketConnection();
=======
     */
    public function initialize(array $params)
    {
        $this->params = $params;
        switch ($params['type']) {
            case self::TYPE_PROCESS:
                $this->establishProcessConnection();
                break;
            case self::TYPE_SOCKET:
            default:
                $this->establishSocketConnection();
>>>>>>> v2-test
                break;
        }
    }

    /**
     * Set an individual param on the buffer (e.g. switching to SSL).
     *
     * @param string $param
     * @param mixed  $value
     */
    public function setParam($param, $value)
    {
<<<<<<< HEAD
        if (isset($this->_stream)) {
            switch ($param) {
                case 'timeout':
                    if ($this->_stream) {
                        stream_set_timeout($this->_stream, $value);
=======
        if (isset($this->stream)) {
            switch ($param) {
                case 'timeout':
                    if ($this->stream) {
                        stream_set_timeout($this->stream, $value);
>>>>>>> v2-test
                    }
                    break;

                case 'blocking':
<<<<<<< HEAD
                    if ($this->_stream) {
                        stream_set_blocking($this->_stream, 1);
                    }

            }
        }
        $this->_params[$param] = $value;
=======
                    if ($this->stream) {
                        stream_set_blocking($this->stream, 1);
                    }
            }
        }
        $this->params[$param] = $value;
>>>>>>> v2-test
    }

    public function startTLS()
    {
<<<<<<< HEAD
        return stream_socket_enable_crypto($this->_stream, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
=======
        // STREAM_CRYPTO_METHOD_TLS_CLIENT only allow tls1.0 connections (some php versions)
        // To support modern tls we allow explicit tls1.0, tls1.1, tls1.2
        // Ssl3 and older are not allowed because they are vulnerable
        // @TODO make tls arguments configurable
        return stream_socket_enable_crypto($this->stream, true, STREAM_CRYPTO_METHOD_TLSv1_0_CLIENT | STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT | STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT);
>>>>>>> v2-test
    }

    /**
     * Perform any shutdown logic needed.
     */
    public function terminate()
    {
<<<<<<< HEAD
        if (isset($this->_stream)) {
            switch ($this->_params['type']) {
                case self::TYPE_PROCESS:
                    fclose($this->_in);
                    fclose($this->_out);
                    proc_close($this->_stream);
                    break;
                case self::TYPE_SOCKET:
                default:
                    fclose($this->_stream);
                    break;
            }
        }
        $this->_stream = null;
        $this->_out = null;
        $this->_in = null;
=======
        if (isset($this->stream)) {
            switch ($this->params['type']) {
                case self::TYPE_PROCESS:
                    fclose($this->in);
                    fclose($this->out);
                    proc_close($this->stream);
                    break;
                case self::TYPE_SOCKET:
                default:
                    fclose($this->stream);
                    break;
            }
        }
        $this->stream = null;
        $this->out = null;
        $this->in = null;
>>>>>>> v2-test
    }

    /**
     * Set an array of string replacements which should be made on data written
     * to the buffer.
     *
     * This could replace LF with CRLF for example.
     *
     * @param string[] $replacements
     */
    public function setWriteTranslations(array $replacements)
    {
<<<<<<< HEAD
        foreach ($this->_translations as $search => $replace) {
            if (!isset($replacements[$search])) {
                $this->removeFilter($search);
                unset($this->_translations[$search]);
=======
        foreach ($this->translations as $search => $replace) {
            if (!isset($replacements[$search])) {
                $this->removeFilter($search);
                unset($this->translations[$search]);
>>>>>>> v2-test
            }
        }

        foreach ($replacements as $search => $replace) {
<<<<<<< HEAD
            if (!isset($this->_translations[$search])) {
                $this->addFilter(
                    $this->_replacementFactory->createFilter($search, $replace), $search
                    );
                $this->_translations[$search] = true;
=======
            if (!isset($this->translations[$search])) {
                $this->addFilter(
                    $this->replacementFactory->createFilter($search, $replace), $search
                    );
                $this->translations[$search] = true;
>>>>>>> v2-test
            }
        }
    }

    /**
     * Get a line of output (including any CRLF).
     *
     * The $sequence number comes from any writes and may or may not be used
     * depending upon the implementation.
     *
     * @param int $sequence of last write to scan from
     *
<<<<<<< HEAD
     * @throws Swift_IoException
     *
     * @return string
     */
    public function readLine($sequence)
    {
        if (isset($this->_out) && !feof($this->_out)) {
            $line = fgets($this->_out);
            if (strlen($line) == 0) {
                $metas = stream_get_meta_data($this->_out);
                if ($metas['timed_out']) {
                    throw new Swift_IoException(
                        'Connection to '.
                            $this->_getReadConnectionDescription().
                        ' Timed Out'
                    );
=======
     * @return string
     *
     * @throws Swift_IoException
     */
    public function readLine($sequence)
    {
        if (isset($this->out) && !feof($this->out)) {
            $line = fgets($this->out);
            if (0 == \strlen($line)) {
                $metas = stream_get_meta_data($this->out);
                if ($metas['timed_out']) {
                    throw new Swift_IoException('Connection to '.$this->getReadConnectionDescription().' Timed Out');
>>>>>>> v2-test
                }
            }

            return $line;
        }
    }

    /**
     * Reads $length bytes from the stream into a string and moves the pointer
     * through the stream by $length.
     *
     * If less bytes exist than are requested the remaining bytes are given instead.
     * If no bytes are remaining at all, boolean false is returned.
     *
     * @param int $length
     *
<<<<<<< HEAD
     * @throws Swift_IoException
     *
     * @return string|bool
     */
    public function read($length)
    {
        if (isset($this->_out) && !feof($this->_out)) {
            $ret = fread($this->_out, $length);
            if (strlen($ret) == 0) {
                $metas = stream_get_meta_data($this->_out);
                if ($metas['timed_out']) {
                    throw new Swift_IoException(
                        'Connection to '.
                            $this->_getReadConnectionDescription().
                        ' Timed Out'
                    );
=======
     * @return string|bool
     *
     * @throws Swift_IoException
     */
    public function read($length)
    {
        if (isset($this->out) && !feof($this->out)) {
            $ret = fread($this->out, $length);
            if (0 == \strlen($ret)) {
                $metas = stream_get_meta_data($this->out);
                if ($metas['timed_out']) {
                    throw new Swift_IoException('Connection to '.$this->getReadConnectionDescription().' Timed Out');
>>>>>>> v2-test
                }
            }

            return $ret;
        }
    }

    /** Not implemented */
    public function setReadPointer($byteOffset)
    {
    }

    /** Flush the stream contents */
<<<<<<< HEAD
    protected function _flush()
    {
        if (isset($this->_in)) {
            fflush($this->_in);
=======
    protected function flush()
    {
        if (isset($this->in)) {
            fflush($this->in);
>>>>>>> v2-test
        }
    }

    /** Write this bytes to the stream */
<<<<<<< HEAD
    protected function _commit($bytes)
    {
        if (isset($this->_in)) {
            $bytesToWrite = strlen($bytes);
            $totalBytesWritten = 0;

            while ($totalBytesWritten < $bytesToWrite) {
                $bytesWritten = fwrite($this->_in, substr($bytes, $totalBytesWritten));
=======
    protected function doCommit($bytes)
    {
        if (isset($this->in)) {
            $bytesToWrite = \strlen($bytes);
            $totalBytesWritten = 0;

            while ($totalBytesWritten < $bytesToWrite) {
                $bytesWritten = fwrite($this->in, substr($bytes, $totalBytesWritten));
>>>>>>> v2-test
                if (false === $bytesWritten || 0 === $bytesWritten) {
                    break;
                }

                $totalBytesWritten += $bytesWritten;
            }

            if ($totalBytesWritten > 0) {
<<<<<<< HEAD
                return ++$this->_sequence;
=======
                return ++$this->sequence;
>>>>>>> v2-test
            }
        }
    }

    /**
     * Establishes a connection to a remote server.
     */
<<<<<<< HEAD
    private function _establishSocketConnection()
    {
        $host = $this->_params['host'];
        if (!empty($this->_params['protocol'])) {
            $host = $this->_params['protocol'].'://'.$host;
        }
        $timeout = 15;
        if (!empty($this->_params['timeout'])) {
            $timeout = $this->_params['timeout'];
        }
        $options = array();
        if (!empty($this->_params['sourceIp'])) {
            $options['socket']['bindto'] = $this->_params['sourceIp'].':0';
        }
        if (isset($this->_params['stream_context_options'])) {
            $options = array_merge($options, $this->_params['stream_context_options']);
        }
        $streamContext = stream_context_create($options);
        $this->_stream = @stream_socket_client($host.':'.$this->_params['port'], $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $streamContext);
        if (false === $this->_stream) {
            throw new Swift_TransportException(
                'Connection could not be established with host '.$this->_params['host'].
                ' ['.$errstr.' #'.$errno.']'
                );
        }
        if (!empty($this->_params['blocking'])) {
            stream_set_blocking($this->_stream, 1);
        } else {
            stream_set_blocking($this->_stream, 0);
        }
        stream_set_timeout($this->_stream, $timeout);
        $this->_in = &$this->_stream;
        $this->_out = &$this->_stream;
=======
    private function establishSocketConnection()
    {
        $host = $this->params['host'];
        if (!empty($this->params['protocol'])) {
            $host = $this->params['protocol'].'://'.$host;
        }
        $timeout = 15;
        if (!empty($this->params['timeout'])) {
            $timeout = $this->params['timeout'];
        }
        $options = [];
        if (!empty($this->params['sourceIp'])) {
            $options['socket']['bindto'] = $this->params['sourceIp'].':0';
        }

        if (isset($this->params['stream_context_options'])) {
            $options = array_merge($options, $this->params['stream_context_options']);
        }
        $streamContext = stream_context_create($options);

        set_error_handler(function ($type, $msg) {
            throw new Swift_TransportException('Connection could not be established with host '.$this->params['host'].' :'.$msg);
        });
        try {
            $this->stream = stream_socket_client($host.':'.$this->params['port'], $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $streamContext);
        } finally {
            restore_error_handler();
        }

        if (!empty($this->params['blocking'])) {
            stream_set_blocking($this->stream, 1);
        } else {
            stream_set_blocking($this->stream, 0);
        }
        stream_set_timeout($this->stream, $timeout);
        $this->in = &$this->stream;
        $this->out = &$this->stream;
>>>>>>> v2-test
    }

    /**
     * Opens a process for input/output.
     */
<<<<<<< HEAD
    private function _establishProcessConnection()
    {
        $command = $this->_params['command'];
        $descriptorSpec = array(
            0 => array('pipe', 'r'),
            1 => array('pipe', 'w'),
            2 => array('pipe', 'w'),
            );
        $this->_stream = proc_open($command, $descriptorSpec, $pipes);
        stream_set_blocking($pipes[2], 0);
        if ($err = stream_get_contents($pipes[2])) {
            throw new Swift_TransportException(
                'Process could not be started ['.$err.']'
                );
        }
        $this->_in = &$pipes[0];
        $this->_out = &$pipes[1];
    }

    private function _getReadConnectionDescription()
    {
        switch ($this->_params['type']) {
            case self::TYPE_PROCESS:
                return 'Process '.$this->_params['command'];
=======
    private function establishProcessConnection()
    {
        $command = $this->params['command'];
        $descriptorSpec = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
            ];
        $pipes = [];
        $this->stream = proc_open($command, $descriptorSpec, $pipes);
        stream_set_blocking($pipes[2], 0);
        if ($err = stream_get_contents($pipes[2])) {
            throw new Swift_TransportException('Process could not be started ['.$err.']');
        }
        $this->in = &$pipes[0];
        $this->out = &$pipes[1];
    }

    private function getReadConnectionDescription()
    {
        switch ($this->params['type']) {
            case self::TYPE_PROCESS:
                return 'Process '.$this->params['command'];
>>>>>>> v2-test
                break;

            case self::TYPE_SOCKET:
            default:
<<<<<<< HEAD
                $host = $this->_params['host'];
                if (!empty($this->_params['protocol'])) {
                    $host = $this->_params['protocol'].'://'.$host;
                }
                $host .= ':'.$this->_params['port'];
=======
                $host = $this->params['host'];
                if (!empty($this->params['protocol'])) {
                    $host = $this->params['protocol'].'://'.$host;
                }
                $host .= ':'.$this->params['port'];
>>>>>>> v2-test

                return $host;
                break;
        }
    }
}
