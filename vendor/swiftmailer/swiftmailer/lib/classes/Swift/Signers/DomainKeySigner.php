<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * DomainKey Signer used to apply DomainKeys Signature to a message.
 *
<<<<<<< HEAD
 * @author Xavier De Cock <xdecock@gmail.com>
=======
 * @author     Xavier De Cock <xdecock@gmail.com>
>>>>>>> v2-test
 */
class Swift_Signers_DomainKeySigner implements Swift_Signers_HeaderSigner
{
    /**
     * PrivateKey.
     *
     * @var string
     */
<<<<<<< HEAD
    protected $_privateKey;
=======
    protected $privateKey;
>>>>>>> v2-test

    /**
     * DomainName.
     *
     * @var string
     */
<<<<<<< HEAD
    protected $_domainName;
=======
    protected $domainName;
>>>>>>> v2-test

    /**
     * Selector.
     *
     * @var string
     */
<<<<<<< HEAD
    protected $_selector;
=======
    protected $selector;
>>>>>>> v2-test

    /**
     * Hash algorithm used.
     *
     * @var string
     */
<<<<<<< HEAD
    protected $_hashAlgorithm = 'rsa-sha1';
=======
    protected $hashAlgorithm = 'rsa-sha1';
>>>>>>> v2-test

    /**
     * Canonisation method.
     *
     * @var string
     */
<<<<<<< HEAD
    protected $_canon = 'simple';
=======
    protected $canon = 'simple';
>>>>>>> v2-test

    /**
     * Headers not being signed.
     *
     * @var array
     */
<<<<<<< HEAD
    protected $_ignoredHeaders = array();
=======
    protected $ignoredHeaders = [];
>>>>>>> v2-test

    /**
     * Signer identity.
     *
     * @var string
     */
<<<<<<< HEAD
    protected $_signerIdentity;
=======
    protected $signerIdentity;
>>>>>>> v2-test

    /**
     * Must we embed signed headers?
     *
     * @var bool
     */
<<<<<<< HEAD
    protected $_debugHeaders = false;
=======
    protected $debugHeaders = false;
>>>>>>> v2-test

    // work variables
    /**
     * Headers used to generate hash.
     *
     * @var array
     */
<<<<<<< HEAD
    private $_signedHeaders = array();
=======
    private $signedHeaders = [];
>>>>>>> v2-test

    /**
     * Stores the signature header.
     *
     * @var Swift_Mime_Headers_ParameterizedHeader
     */
<<<<<<< HEAD
    protected $_domainKeyHeader;
=======
    protected $domainKeyHeader;
>>>>>>> v2-test

    /**
     * Hash Handler.
     *
     * @var resource|null
     */
<<<<<<< HEAD
    private $_hashHandler;

    private $_hash;

    private $_canonData = '';

    private $_bodyCanonEmptyCounter = 0;

    private $_bodyCanonIgnoreStart = 2;

    private $_bodyCanonSpace = false;

    private $_bodyCanonLastChar = null;

    private $_bodyCanonLine = '';

    private $_bound = array();
=======
    private $hashHandler;

    private $canonData = '';

    private $bodyCanonEmptyCounter = 0;

    private $bodyCanonIgnoreStart = 2;

    private $bodyCanonSpace = false;

    private $bodyCanonLastChar = null;

    private $bodyCanonLine = '';

    private $bound = [];
>>>>>>> v2-test

    /**
     * Constructor.
     *
     * @param string $privateKey
     * @param string $domainName
     * @param string $selector
     */
    public function __construct($privateKey, $domainName, $selector)
    {
<<<<<<< HEAD
        $this->_privateKey = $privateKey;
        $this->_domainName = $domainName;
        $this->_signerIdentity = '@'.$domainName;
        $this->_selector = $selector;
    }

    /**
     * Instanciate DomainKeySigner.
     *
     * @param string $privateKey
     * @param string $domainName
     * @param string $selector
     *
     * @return Swift_Signers_DomainKeySigner
     */
    public static function newInstance($privateKey, $domainName, $selector)
    {
        return new static($privateKey, $domainName, $selector);
=======
        $this->privateKey = $privateKey;
        $this->domainName = $domainName;
        $this->signerIdentity = '@'.$domainName;
        $this->selector = $selector;
>>>>>>> v2-test
    }

    /**
     * Resets internal states.
     *
<<<<<<< HEAD
     * @return Swift_Signers_DomainKeySigner
     */
    public function reset()
    {
        $this->_hash = null;
        $this->_hashHandler = null;
        $this->_bodyCanonIgnoreStart = 2;
        $this->_bodyCanonEmptyCounter = 0;
        $this->_bodyCanonLastChar = null;
        $this->_bodyCanonSpace = false;
=======
     * @return $this
     */
    public function reset()
    {
        $this->hashHandler = null;
        $this->bodyCanonIgnoreStart = 2;
        $this->bodyCanonEmptyCounter = 0;
        $this->bodyCanonLastChar = null;
        $this->bodyCanonSpace = false;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Writes $bytes to the end of the stream.
     *
     * Writing may not happen immediately if the stream chooses to buffer.  If
     * you want to write these bytes with immediate effect, call {@link commit()}
     * after calling write().
     *
     * This method returns the sequence ID of the write (i.e. 1 for first, 2 for
     * second, etc etc).
     *
     * @param string $bytes
     *
<<<<<<< HEAD
     * @throws Swift_IoException
     *
     * @return int
     * @return Swift_Signers_DomainKeySigner
     */
    public function write($bytes)
    {
        $this->_canonicalizeBody($bytes);
        foreach ($this->_bound as $is) {
=======
     * @return int
     *
     * @throws Swift_IoException
     *
     * @return $this
     */
    public function write($bytes)
    {
        $this->canonicalizeBody($bytes);
        foreach ($this->bound as $is) {
>>>>>>> v2-test
            $is->write($bytes);
        }

        return $this;
    }

    /**
     * For any bytes that are currently buffered inside the stream, force them
     * off the buffer.
     *
     * @throws Swift_IoException
     *
<<<<<<< HEAD
     * @return Swift_Signers_DomainKeySigner
=======
     * @return $this
>>>>>>> v2-test
     */
    public function commit()
    {
        // Nothing to do
        return $this;
    }

    /**
     * Attach $is to this stream.
<<<<<<< HEAD
     * The stream acts as an observer, receiving all data that is written.
     * All {@link write()} and {@link flushBuffers()} operations will be mirrored.
     *
     * @param Swift_InputByteStream $is
     *
     * @return Swift_Signers_DomainKeySigner
=======
     *
     * The stream acts as an observer, receiving all data that is written.
     * All {@link write()} and {@link flushBuffers()} operations will be mirrored.
     *
     * @return $this
>>>>>>> v2-test
     */
    public function bind(Swift_InputByteStream $is)
    {
        // Don't have to mirror anything
<<<<<<< HEAD
        $this->_bound[] = $is;
=======
        $this->bound[] = $is;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Remove an already bound stream.
<<<<<<< HEAD
=======
     *
>>>>>>> v2-test
     * If $is is not bound, no errors will be raised.
     * If the stream currently has any buffered data it will be written to $is
     * before unbinding occurs.
     *
<<<<<<< HEAD
     * @param Swift_InputByteStream $is
     *
     * @return Swift_Signers_DomainKeySigner
=======
     * @return $this
>>>>>>> v2-test
     */
    public function unbind(Swift_InputByteStream $is)
    {
        // Don't have to mirror anything
<<<<<<< HEAD
        foreach ($this->_bound as $k => $stream) {
            if ($stream === $is) {
                unset($this->_bound[$k]);

                return;
=======
        foreach ($this->bound as $k => $stream) {
            if ($stream === $is) {
                unset($this->bound[$k]);

                break;
>>>>>>> v2-test
            }
        }

        return $this;
    }

    /**
     * Flush the contents of the stream (empty it) and set the internal pointer
     * to the beginning.
     *
     * @throws Swift_IoException
     *
<<<<<<< HEAD
     * @return Swift_Signers_DomainKeySigner
=======
     * @return $this
>>>>>>> v2-test
     */
    public function flushBuffers()
    {
        $this->reset();

        return $this;
    }

    /**
     * Set hash_algorithm, must be one of rsa-sha256 | rsa-sha1 defaults to rsa-sha256.
     *
     * @param string $hash
     *
<<<<<<< HEAD
     * @return Swift_Signers_DomainKeySigner
     */
    public function setHashAlgorithm($hash)
    {
        $this->_hashAlgorithm = 'rsa-sha1';
=======
     * @return $this
     */
    public function setHashAlgorithm($hash)
    {
        $this->hashAlgorithm = 'rsa-sha1';
>>>>>>> v2-test

        return $this;
    }

    /**
     * Set the canonicalization algorithm.
     *
     * @param string $canon simple | nofws defaults to simple
     *
<<<<<<< HEAD
     * @return Swift_Signers_DomainKeySigner
     */
    public function setCanon($canon)
    {
        if ($canon == 'nofws') {
            $this->_canon = 'nofws';
        } else {
            $this->_canon = 'simple';
=======
     * @return $this
     */
    public function setCanon($canon)
    {
        if ('nofws' == $canon) {
            $this->canon = 'nofws';
        } else {
            $this->canon = 'simple';
>>>>>>> v2-test
        }

        return $this;
    }

    /**
     * Set the signer identity.
     *
     * @param string $identity
     *
<<<<<<< HEAD
     * @return Swift_Signers_DomainKeySigner
     */
    public function setSignerIdentity($identity)
    {
        $this->_signerIdentity = $identity;
=======
     * @return $this
     */
    public function setSignerIdentity($identity)
    {
        $this->signerIdentity = $identity;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Enable / disable the DebugHeaders.
     *
     * @param bool $debug
     *
<<<<<<< HEAD
     * @return Swift_Signers_DomainKeySigner
     */
    public function setDebugHeaders($debug)
    {
        $this->_debugHeaders = (bool) $debug;
=======
     * @return $this
     */
    public function setDebugHeaders($debug)
    {
        $this->debugHeaders = (bool) $debug;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Start Body.
     */
    public function startBody()
    {
    }

    /**
     * End Body.
     */
    public function endBody()
    {
<<<<<<< HEAD
        $this->_endOfBody();
=======
        $this->endOfBody();
>>>>>>> v2-test
    }

    /**
     * Returns the list of Headers Tampered by this plugin.
     *
     * @return array
     */
    public function getAlteredHeaders()
    {
<<<<<<< HEAD
        if ($this->_debugHeaders) {
            return array('DomainKey-Signature', 'X-DebugHash');
        }

        return array('DomainKey-Signature');
=======
        if ($this->debugHeaders) {
            return ['DomainKey-Signature', 'X-DebugHash'];
        }

        return ['DomainKey-Signature'];
>>>>>>> v2-test
    }

    /**
     * Adds an ignored Header.
     *
     * @param string $header_name
     *
<<<<<<< HEAD
     * @return Swift_Signers_DomainKeySigner
     */
    public function ignoreHeader($header_name)
    {
        $this->_ignoredHeaders[strtolower($header_name)] = true;
=======
     * @return $this
     */
    public function ignoreHeader($header_name)
    {
        $this->ignoredHeaders[strtolower($header_name)] = true;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Set the headers to sign.
     *
<<<<<<< HEAD
     * @param Swift_Mime_HeaderSet $headers
     *
     * @return Swift_Signers_DomainKeySigner
     */
    public function setHeaders(Swift_Mime_HeaderSet $headers)
    {
        $this->_startHash();
        $this->_canonData = '';
=======
     * @return $this
     */
    public function setHeaders(Swift_Mime_SimpleHeaderSet $headers)
    {
        $this->startHash();
        $this->canonData = '';
>>>>>>> v2-test
        // Loop through Headers
        $listHeaders = $headers->listAll();
        foreach ($listHeaders as $hName) {
            // Check if we need to ignore Header
<<<<<<< HEAD
            if (!isset($this->_ignoredHeaders[strtolower($hName)])) {
                if ($headers->has($hName)) {
                    $tmp = $headers->getAll($hName);
                    foreach ($tmp as $header) {
                        if ($header->getFieldBody() != '') {
                            $this->_addHeader($header->toString());
                            $this->_signedHeaders[] = $header->getFieldName();
=======
            if (!isset($this->ignoredHeaders[strtolower($hName)])) {
                if ($headers->has($hName)) {
                    $tmp = $headers->getAll($hName);
                    foreach ($tmp as $header) {
                        if ('' != $header->getFieldBody()) {
                            $this->addHeader($header->toString());
                            $this->signedHeaders[] = $header->getFieldName();
>>>>>>> v2-test
                        }
                    }
                }
            }
        }
<<<<<<< HEAD
        $this->_endOfHeaders();
=======
        $this->endOfHeaders();
>>>>>>> v2-test

        return $this;
    }

    /**
     * Add the signature to the given Headers.
     *
<<<<<<< HEAD
     * @param Swift_Mime_HeaderSet $headers
     *
     * @return Swift_Signers_DomainKeySigner
     */
    public function addSignature(Swift_Mime_HeaderSet $headers)
    {
        // Prepare the DomainKey-Signature Header
        $params = array('a' => $this->_hashAlgorithm, 'b' => chunk_split(base64_encode($this->_getEncryptedHash()), 73, ' '), 'c' => $this->_canon, 'd' => $this->_domainName, 'h' => implode(': ', $this->_signedHeaders), 'q' => 'dns', 's' => $this->_selector);
=======
     * @return $this
     */
    public function addSignature(Swift_Mime_SimpleHeaderSet $headers)
    {
        // Prepare the DomainKey-Signature Header
        $params = ['a' => $this->hashAlgorithm, 'b' => chunk_split(base64_encode($this->getEncryptedHash()), 73, ' '), 'c' => $this->canon, 'd' => $this->domainName, 'h' => implode(': ', $this->signedHeaders), 'q' => 'dns', 's' => $this->selector];
>>>>>>> v2-test
        $string = '';
        foreach ($params as $k => $v) {
            $string .= $k.'='.$v.'; ';
        }
        $string = trim($string);
        $headers->addTextHeader('DomainKey-Signature', $string);

        return $this;
    }

    /* Private helpers */

<<<<<<< HEAD
    protected function _addHeader($header)
    {
        switch ($this->_canon) {
            case 'nofws' :
=======
    protected function addHeader($header)
    {
        switch ($this->canon) {
            case 'nofws':
>>>>>>> v2-test
                // Prepare Header and cascade
                $exploded = explode(':', $header, 2);
                $name = strtolower(trim($exploded[0]));
                $value = str_replace("\r\n", '', $exploded[1]);
                $value = preg_replace("/[ \t][ \t]+/", ' ', $value);
                $header = $name.':'.trim($value)."\r\n";
<<<<<<< HEAD
            case 'simple' :
                // Nothing to do
        }
        $this->_addToHash($header);
    }

    protected function _endOfHeaders()
    {
        $this->_bodyCanonEmptyCounter = 1;
    }

    protected function _canonicalizeBody($string)
    {
        $len = strlen($string);
        $canon = '';
        $nofws = ($this->_canon == 'nofws');
        for ($i = 0; $i < $len; ++$i) {
            if ($this->_bodyCanonIgnoreStart > 0) {
                --$this->_bodyCanonIgnoreStart;
                continue;
            }
            switch ($string[$i]) {
                case "\r" :
                    $this->_bodyCanonLastChar = "\r";
                    break;
                case "\n" :
                    if ($this->_bodyCanonLastChar == "\r") {
                        if ($nofws) {
                            $this->_bodyCanonSpace = false;
                        }
                        if ($this->_bodyCanonLine == '') {
                            ++$this->_bodyCanonEmptyCounter;
                        } else {
                            $this->_bodyCanonLine = '';
=======
                // no break
            case 'simple':
                // Nothing to do
        }
        $this->addToHash($header);
    }

    protected function endOfHeaders()
    {
        $this->bodyCanonEmptyCounter = 1;
    }

    protected function canonicalizeBody($string)
    {
        $len = \strlen($string);
        $canon = '';
        $nofws = ('nofws' == $this->canon);
        for ($i = 0; $i < $len; ++$i) {
            if ($this->bodyCanonIgnoreStart > 0) {
                --$this->bodyCanonIgnoreStart;
                continue;
            }
            switch ($string[$i]) {
                case "\r":
                    $this->bodyCanonLastChar = "\r";
                    break;
                case "\n":
                    if ("\r" == $this->bodyCanonLastChar) {
                        if ($nofws) {
                            $this->bodyCanonSpace = false;
                        }
                        if ('' == $this->bodyCanonLine) {
                            ++$this->bodyCanonEmptyCounter;
                        } else {
                            $this->bodyCanonLine = '';
>>>>>>> v2-test
                            $canon .= "\r\n";
                        }
                    } else {
                        // Wooops Error
                        throw new Swift_SwiftException('Invalid new line sequence in mail found \n without preceding \r');
                    }
                    break;
<<<<<<< HEAD
                case ' ' :
                case "\t" :
                case "\x09": //HTAB
                    if ($nofws) {
                        $this->_bodyCanonSpace = true;
                        break;
                    }
                default :
                    if ($this->_bodyCanonEmptyCounter > 0) {
                        $canon .= str_repeat("\r\n", $this->_bodyCanonEmptyCounter);
                        $this->_bodyCanonEmptyCounter = 0;
                    }
                    $this->_bodyCanonLine .= $string[$i];
                    $canon .= $string[$i];
            }
        }
        $this->_addToHash($canon);
    }

    protected function _endOfBody()
    {
        if (strlen($this->_bodyCanonLine) > 0) {
            $this->_addToHash("\r\n");
        }
        $this->_hash = hash_final($this->_hashHandler, true);
    }

    private function _addToHash($string)
    {
        $this->_canonData .= $string;
        hash_update($this->_hashHandler, $string);
    }

    private function _startHash()
    {
        // Init
        switch ($this->_hashAlgorithm) {
            case 'rsa-sha1' :
                $this->_hashHandler = hash_init('sha1');
                break;
        }
        $this->_bodyCanonLine = '';
=======
                case ' ':
                case "\t":
                case "\x09": //HTAB
                    if ($nofws) {
                        $this->bodyCanonSpace = true;
                        break;
                    }
                    // no break
                default:
                    if ($this->bodyCanonEmptyCounter > 0) {
                        $canon .= str_repeat("\r\n", $this->bodyCanonEmptyCounter);
                        $this->bodyCanonEmptyCounter = 0;
                    }
                    $this->bodyCanonLine .= $string[$i];
                    $canon .= $string[$i];
            }
        }
        $this->addToHash($canon);
    }

    protected function endOfBody()
    {
        if (\strlen($this->bodyCanonLine) > 0) {
            $this->addToHash("\r\n");
        }
    }

    private function addToHash($string)
    {
        $this->canonData .= $string;
        hash_update($this->hashHandler, $string);
    }

    private function startHash()
    {
        // Init
        switch ($this->hashAlgorithm) {
            case 'rsa-sha1':
                $this->hashHandler = hash_init('sha1');
                break;
        }
        $this->bodyCanonLine = '';
>>>>>>> v2-test
    }

    /**
     * @throws Swift_SwiftException
     *
     * @return string
     */
<<<<<<< HEAD
    private function _getEncryptedHash()
    {
        $signature = '';
        $pkeyId = openssl_get_privatekey($this->_privateKey);
        if (!$pkeyId) {
            throw new Swift_SwiftException('Unable to load DomainKey Private Key ['.openssl_error_string().']');
        }
        if (openssl_sign($this->_canonData, $signature, $pkeyId, OPENSSL_ALGO_SHA1)) {
=======
    private function getEncryptedHash()
    {
        $signature = '';
        $pkeyId = openssl_get_privatekey($this->privateKey);
        if (!$pkeyId) {
            throw new Swift_SwiftException('Unable to load DomainKey Private Key ['.openssl_error_string().']');
        }
        if (openssl_sign($this->canonData, $signature, $pkeyId, OPENSSL_ALGO_SHA1)) {
>>>>>>> v2-test
            return $signature;
        }
        throw new Swift_SwiftException('Unable to sign DomainKey Hash  ['.openssl_error_string().']');
    }
}
