<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * DKIM Signer used to apply DKIM Signature to a message.
 *
<<<<<<< HEAD
 * @author Xavier De Cock <xdecock@gmail.com>
=======
 * @author     Xavier De Cock <xdecock@gmail.com>
>>>>>>> v2-test
 */
class Swift_Signers_DKIMSigner implements Swift_Signers_HeaderSigner
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

    private $passphrase = '';
>>>>>>> v2-test

    /**
     * Hash algorithm used.
     *
<<<<<<< HEAD
     * @var string
     */
    protected $_hashAlgorithm = 'rsa-sha1';
=======
     * @see RFC6376 3.3: Signers MUST implement and SHOULD sign using rsa-sha256.
     *
     * @var string
     */
    protected $hashAlgorithm = 'rsa-sha256';
>>>>>>> v2-test

    /**
     * Body canon method.
     *
     * @var string
     */
<<<<<<< HEAD
    protected $_bodyCanon = 'simple';
=======
    protected $bodyCanon = 'simple';
>>>>>>> v2-test

    /**
     * Header canon method.
     *
     * @var string
     */
<<<<<<< HEAD
    protected $_headerCanon = 'simple';
=======
    protected $headerCanon = 'simple';
>>>>>>> v2-test

    /**
     * Headers not being signed.
     *
     * @var array
     */
<<<<<<< HEAD
    protected $_ignoredHeaders = array('return-path' => true);
=======
    protected $ignoredHeaders = ['return-path' => true];
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
     * BodyLength.
     *
     * @var int
     */
<<<<<<< HEAD
    protected $_bodyLen = 0;
=======
    protected $bodyLen = 0;
>>>>>>> v2-test

    /**
     * Maximum signedLen.
     *
     * @var int
     */
<<<<<<< HEAD
    protected $_maxLen = PHP_INT_MAX;
=======
    protected $maxLen = PHP_INT_MAX;
>>>>>>> v2-test

    /**
     * Embbed bodyLen in signature.
     *
     * @var bool
     */
<<<<<<< HEAD
    protected $_showLen = false;
=======
    protected $showLen = false;
>>>>>>> v2-test

    /**
     * When the signature has been applied (true means time()), false means not embedded.
     *
     * @var mixed
     */
<<<<<<< HEAD
    protected $_signatureTimestamp = true;

    /**
     * When will the signature expires false means not embedded, if sigTimestamp is auto
     * Expiration is relative, otherwhise it's absolute.
     *
     * @var int
     */
    protected $_signatureExpiration = false;
=======
    protected $signatureTimestamp = true;

    /**
     * When will the signature expires false means not embedded, if sigTimestamp is auto
     * Expiration is relative, otherwise it's absolute.
     *
     * @var int
     */
    protected $signatureExpiration = false;
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
    protected $_signedHeaders = array();

    /**
     * If debugHeaders is set store debugDatas here.
     *
     * @var string
     */
    private $_debugHeadersData = '';
=======
    protected $signedHeaders = [];

    /**
     * If debugHeaders is set store debugData here.
     *
     * @var string[]
     */
    private $debugHeadersData = [];
>>>>>>> v2-test

    /**
     * Stores the bodyHash.
     *
     * @var string
     */
<<<<<<< HEAD
    private $_bodyHash = '';
=======
    private $bodyHash = '';
>>>>>>> v2-test

    /**
     * Stores the signature header.
     *
     * @var Swift_Mime_Headers_ParameterizedHeader
     */
<<<<<<< HEAD
    protected $_dkimHeader;

    private $_bodyHashHandler;

    private $_headerHash;

    private $_headerCanonData = '';

    private $_bodyCanonEmptyCounter = 0;

    private $_bodyCanonIgnoreStart = 2;

    private $_bodyCanonSpace = false;

    private $_bodyCanonLastChar = null;

    private $_bodyCanonLine = '';

    private $_bound = array();
=======
    protected $dkimHeader;

    private $bodyHashHandler;

    private $headerHash;

    private $headerCanonData = '';

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
<<<<<<< HEAD
     */
    public function __construct($privateKey, $domainName, $selector)
    {
        $this->_privateKey = $privateKey;
        $this->_domainName = $domainName;
        $this->_signerIdentity = '@'.$domainName;
        $this->_selector = $selector;
    }

    /**
     * Instanciate DKIMSigner.
     *
     * @param string $privateKey
     * @param string $domainName
     * @param string $selector
     *
     * @return Swift_Signers_DKIMSigner
     */
    public static function newInstance($privateKey, $domainName, $selector)
    {
        return new static($privateKey, $domainName, $selector);
=======
     * @param string $passphrase
     */
    public function __construct($privateKey, $domainName, $selector, $passphrase = '')
    {
        $this->privateKey = $privateKey;
        $this->domainName = $domainName;
        $this->signerIdentity = '@'.$domainName;
        $this->selector = $selector;
        $this->passphrase = $passphrase;
>>>>>>> v2-test
    }

    /**
     * Reset the Signer.
     *
     * @see Swift_Signer::reset()
     */
    public function reset()
    {
<<<<<<< HEAD
        $this->_headerHash = null;
        $this->_signedHeaders = array();
        $this->_bodyHash = null;
        $this->_bodyHashHandler = null;
        $this->_bodyCanonIgnoreStart = 2;
        $this->_bodyCanonEmptyCounter = 0;
        $this->_bodyCanonLastChar = null;
        $this->_bodyCanonSpace = false;
=======
        $this->headerHash = null;
        $this->signedHeaders = [];
        $this->bodyHash = null;
        $this->bodyHashHandler = null;
        $this->bodyCanonIgnoreStart = 2;
        $this->bodyCanonEmptyCounter = 0;
        $this->bodyCanonLastChar = null;
        $this->bodyCanonSpace = false;
>>>>>>> v2-test
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
     */
    public function write($bytes)
    {
        $this->_canonicalizeBody($bytes);
        foreach ($this->_bound as $is) {
=======
     * @return int
     *
     * @throws Swift_IoException
     */
    // TODO fix return
    public function write($bytes)
    {
        $this->canonicalizeBody($bytes);
        foreach ($this->bound as $is) {
>>>>>>> v2-test
            $is->write($bytes);
        }
    }

    /**
     * For any bytes that are currently buffered inside the stream, force them
     * off the buffer.
<<<<<<< HEAD
     *
     * @throws Swift_IoException
=======
>>>>>>> v2-test
     */
    public function commit()
    {
        // Nothing to do
        return;
    }

    /**
     * Attach $is to this stream.
<<<<<<< HEAD
     * The stream acts as an observer, receiving all data that is written.
     * All {@link write()} and {@link flushBuffers()} operations will be mirrored.
     *
     * @param Swift_InputByteStream $is
=======
     *
     * The stream acts as an observer, receiving all data that is written.
     * All {@link write()} and {@link flushBuffers()} operations will be mirrored.
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

        return;
    }

    /**
     * Remove an already bound stream.
<<<<<<< HEAD
     * If $is is not bound, no errors will be raised.
     * If the stream currently has any buffered data it will be written to $is
     * before unbinding occurs.
     *
     * @param Swift_InputByteStream $is
=======
     *
     * If $is is not bound, no errors will be raised.
     * If the stream currently has any buffered data it will be written to $is
     * before unbinding occurs.
>>>>>>> v2-test
     */
    public function unbind(Swift_InputByteStream $is)
    {
        // Don't have to mirror anything
<<<<<<< HEAD
        foreach ($this->_bound as $k => $stream) {
            if ($stream === $is) {
                unset($this->_bound[$k]);
=======
        foreach ($this->bound as $k => $stream) {
            if ($stream === $is) {
                unset($this->bound[$k]);
>>>>>>> v2-test

                return;
            }
        }
<<<<<<< HEAD

        return;
=======
>>>>>>> v2-test
    }

    /**
     * Flush the contents of the stream (empty it) and set the internal pointer
     * to the beginning.
     *
     * @throws Swift_IoException
     */
    public function flushBuffers()
    {
        $this->reset();
    }

    /**
<<<<<<< HEAD
     * Set hash_algorithm, must be one of rsa-sha256 | rsa-sha1 defaults to rsa-sha256.
     *
     * @param string $hash
     *
     * @return Swift_Signers_DKIMSigner
     */
    public function setHashAlgorithm($hash)
    {
        // Unable to sign with rsa-sha256
        if ($hash == 'rsa-sha1') {
            $this->_hashAlgorithm = 'rsa-sha1';
        } else {
            $this->_hashAlgorithm = 'rsa-sha256';
=======
     * Set hash_algorithm, must be one of rsa-sha256 | rsa-sha1.
     *
     * @param string $hash 'rsa-sha1' or 'rsa-sha256'
     *
     * @throws Swift_SwiftException
     *
     * @return $this
     */
    public function setHashAlgorithm($hash)
    {
        switch ($hash) {
            case 'rsa-sha1':
                $this->hashAlgorithm = 'rsa-sha1';
                break;
            case 'rsa-sha256':
                $this->hashAlgorithm = 'rsa-sha256';
                if (!\defined('OPENSSL_ALGO_SHA256')) {
                    throw new Swift_SwiftException('Unable to set sha256 as it is not supported by OpenSSL.');
                }
                break;
            default:
                throw new Swift_SwiftException('Unable to set the hash algorithm, must be one of rsa-sha1 or rsa-sha256 (%s given).', $hash);
>>>>>>> v2-test
        }

        return $this;
    }

    /**
     * Set the body canonicalization algorithm.
     *
     * @param string $canon
     *
<<<<<<< HEAD
     * @return Swift_Signers_DKIMSigner
     */
    public function setBodyCanon($canon)
    {
        if ($canon == 'relaxed') {
            $this->_bodyCanon = 'relaxed';
        } else {
            $this->_bodyCanon = 'simple';
=======
     * @return $this
     */
    public function setBodyCanon($canon)
    {
        if ('relaxed' == $canon) {
            $this->bodyCanon = 'relaxed';
        } else {
            $this->bodyCanon = 'simple';
>>>>>>> v2-test
        }

        return $this;
    }

    /**
     * Set the header canonicalization algorithm.
     *
     * @param string $canon
     *
<<<<<<< HEAD
     * @return Swift_Signers_DKIMSigner
     */
    public function setHeaderCanon($canon)
    {
        if ($canon == 'relaxed') {
            $this->_headerCanon = 'relaxed';
        } else {
            $this->_headerCanon = 'simple';
=======
     * @return $this
     */
    public function setHeaderCanon($canon)
    {
        if ('relaxed' == $canon) {
            $this->headerCanon = 'relaxed';
        } else {
            $this->headerCanon = 'simple';
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
     * @return Swift_Signers_DKIMSigner
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
     * Set the length of the body to sign.
     *
     * @param mixed $len (bool or int)
     *
<<<<<<< HEAD
     * @return Swift_Signers_DKIMSigner
     */
    public function setBodySignedLen($len)
    {
        if ($len === true) {
            $this->_showLen = true;
            $this->_maxLen = PHP_INT_MAX;
        } elseif ($len === false) {
            $this->_showLen = false;
            $this->_maxLen = PHP_INT_MAX;
        } else {
            $this->_showLen = true;
            $this->_maxLen = (int) $len;
=======
     * @return $this
     */
    public function setBodySignedLen($len)
    {
        if (true === $len) {
            $this->showLen = true;
            $this->maxLen = PHP_INT_MAX;
        } elseif (false === $len) {
            $this->showLen = false;
            $this->maxLen = PHP_INT_MAX;
        } else {
            $this->showLen = true;
            $this->maxLen = (int) $len;
>>>>>>> v2-test
        }

        return $this;
    }

    /**
     * Set the signature timestamp.
     *
     * @param int $time A timestamp
     *
<<<<<<< HEAD
     * @return Swift_Signers_DKIMSigner
     */
    public function setSignatureTimestamp($time)
    {
        $this->_signatureTimestamp = $time;
=======
     * @return $this
     */
    public function setSignatureTimestamp($time)
    {
        $this->signatureTimestamp = $time;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Set the signature expiration timestamp.
     *
     * @param int $time A timestamp
     *
<<<<<<< HEAD
     * @return Swift_Signers_DKIMSigner
     */
    public function setSignatureExpiration($time)
    {
        $this->_signatureExpiration = $time;
=======
     * @return $this
     */
    public function setSignatureExpiration($time)
    {
        $this->signatureExpiration = $time;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Enable / disable the DebugHeaders.
     *
     * @param bool $debug
     *
     * @return Swift_Signers_DKIMSigner
     */
    public function setDebugHeaders($debug)
    {
<<<<<<< HEAD
        $this->_debugHeaders = (bool) $debug;
=======
        $this->debugHeaders = (bool) $debug;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Start Body.
     */
    public function startBody()
    {
        // Init
<<<<<<< HEAD
        switch ($this->_hashAlgorithm) {
            case 'rsa-sha256' :
                $this->_bodyHashHandler = hash_init('sha256');
                break;
            case 'rsa-sha1' :
                $this->_bodyHashHandler = hash_init('sha1');
                break;
        }
        $this->_bodyCanonLine = '';
=======
        switch ($this->hashAlgorithm) {
            case 'rsa-sha256':
                $this->bodyHashHandler = hash_init('sha256');
                break;
            case 'rsa-sha1':
                $this->bodyHashHandler = hash_init('sha1');
                break;
        }
        $this->bodyCanonLine = '';
>>>>>>> v2-test
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
            return array('DKIM-Signature', 'X-DebugHash');
        } else {
            return array('DKIM-Signature');
=======
        if ($this->debugHeaders) {
            return ['DKIM-Signature', 'X-DebugHash'];
        } else {
            return ['DKIM-Signature'];
>>>>>>> v2-test
        }
    }

    /**
     * Adds an ignored Header.
     *
     * @param string $header_name
     *
     * @return Swift_Signers_DKIMSigner
     */
    public function ignoreHeader($header_name)
    {
<<<<<<< HEAD
        $this->_ignoredHeaders[strtolower($header_name)] = true;
=======
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
     * @return Swift_Signers_DKIMSigner
     */
    public function setHeaders(Swift_Mime_HeaderSet $headers)
    {
        $this->_headerCanonData = '';
=======
     * @return Swift_Signers_DKIMSigner
     */
    public function setHeaders(Swift_Mime_SimpleHeaderSet $headers)
    {
        $this->headerCanonData = '';
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

        return $this;
    }

    /**
     * Add the signature to the given Headers.
     *
<<<<<<< HEAD
     * @param Swift_Mime_HeaderSet $headers
     *
     * @return Swift_Signers_DKIMSigner
     */
    public function addSignature(Swift_Mime_HeaderSet $headers)
    {
        // Prepare the DKIM-Signature
        $params = array('v' => '1', 'a' => $this->_hashAlgorithm, 'bh' => base64_encode($this->_bodyHash), 'd' => $this->_domainName, 'h' => implode(': ', $this->_signedHeaders), 'i' => $this->_signerIdentity, 's' => $this->_selector);
        if ($this->_bodyCanon != 'simple') {
            $params['c'] = $this->_headerCanon.'/'.$this->_bodyCanon;
        } elseif ($this->_headerCanon != 'simple') {
            $params['c'] = $this->_headerCanon;
        }
        if ($this->_showLen) {
            $params['l'] = $this->_bodyLen;
        }
        if ($this->_signatureTimestamp === true) {
            $params['t'] = time();
            if ($this->_signatureExpiration !== false) {
                $params['x'] = $params['t'] + $this->_signatureExpiration;
            }
        } else {
            if ($this->_signatureTimestamp !== false) {
                $params['t'] = $this->_signatureTimestamp;
            }
            if ($this->_signatureExpiration !== false) {
                $params['x'] = $this->_signatureExpiration;
            }
        }
        if ($this->_debugHeaders) {
            $params['z'] = implode('|', $this->_debugHeadersData);
=======
     * @return Swift_Signers_DKIMSigner
     */
    public function addSignature(Swift_Mime_SimpleHeaderSet $headers)
    {
        // Prepare the DKIM-Signature
        $params = ['v' => '1', 'a' => $this->hashAlgorithm, 'bh' => base64_encode($this->bodyHash), 'd' => $this->domainName, 'h' => implode(': ', $this->signedHeaders), 'i' => $this->signerIdentity, 's' => $this->selector];
        if ('simple' != $this->bodyCanon) {
            $params['c'] = $this->headerCanon.'/'.$this->bodyCanon;
        } elseif ('simple' != $this->headerCanon) {
            $params['c'] = $this->headerCanon;
        }
        if ($this->showLen) {
            $params['l'] = $this->bodyLen;
        }
        if (true === $this->signatureTimestamp) {
            $params['t'] = time();
            if (false !== $this->signatureExpiration) {
                $params['x'] = $params['t'] + $this->signatureExpiration;
            }
        } else {
            if (false !== $this->signatureTimestamp) {
                $params['t'] = $this->signatureTimestamp;
            }
            if (false !== $this->signatureExpiration) {
                $params['x'] = $this->signatureExpiration;
            }
        }
        if ($this->debugHeaders) {
            $params['z'] = implode('|', $this->debugHeadersData);
>>>>>>> v2-test
        }
        $string = '';
        foreach ($params as $k => $v) {
            $string .= $k.'='.$v.'; ';
        }
        $string = trim($string);
        $headers->addTextHeader('DKIM-Signature', $string);
        // Add the last DKIM-Signature
        $tmp = $headers->getAll('DKIM-Signature');
<<<<<<< HEAD
        $this->_dkimHeader = end($tmp);
        $this->_addHeader(trim($this->_dkimHeader->toString())."\r\n b=", true);
        $this->_endOfHeaders();
        if ($this->_debugHeaders) {
            $headers->addTextHeader('X-DebugHash', base64_encode($this->_headerHash));
        }
        $this->_dkimHeader->setValue($string.' b='.trim(chunk_split(base64_encode($this->_getEncryptedHash()), 73, ' ')));
=======
        $this->dkimHeader = end($tmp);
        $this->addHeader(trim($this->dkimHeader->toString())."\r\n b=", true);
        if ($this->debugHeaders) {
            $headers->addTextHeader('X-DebugHash', base64_encode($this->headerHash));
        }
        $this->dkimHeader->setValue($string.' b='.trim(chunk_split(base64_encode($this->getEncryptedHash()), 73, ' ')));
>>>>>>> v2-test

        return $this;
    }

    /* Private helpers */

<<<<<<< HEAD
    protected function _addHeader($header, $is_sig = false)
    {
        switch ($this->_headerCanon) {
            case 'relaxed' :
=======
    protected function addHeader($header, $is_sig = false)
    {
        switch ($this->headerCanon) {
            case 'relaxed':
>>>>>>> v2-test
                // Prepare Header and cascade
                $exploded = explode(':', $header, 2);
                $name = strtolower(trim($exploded[0]));
                $value = str_replace("\r\n", '', $exploded[1]);
                $value = preg_replace("/[ \t][ \t]+/", ' ', $value);
                $header = $name.':'.trim($value).($is_sig ? '' : "\r\n");
<<<<<<< HEAD
            case 'simple' :
                // Nothing to do
        }
        $this->_addToHeaderHash($header);
    }

    /**
     * @deprecated This method is currently useless in this class but it must be
     *             kept for BC reasons due to its "protected" scope. This method
     *             might be overriden by custom client code.
     */
    protected function _endOfHeaders()
    {
    }

    protected function _canonicalizeBody($string)
    {
        $len = strlen($string);
        $canon = '';
        $method = ($this->_bodyCanon == 'relaxed');
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
                        if ($method) {
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
        $this->addToHeaderHash($header);
    }

    protected function canonicalizeBody($string)
    {
        $len = \strlen($string);
        $canon = '';
        $method = ('relaxed' == $this->bodyCanon);
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
                        if ($method) {
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
                        // todo handle it but should never happen
                    }
                    break;
<<<<<<< HEAD
                case ' ' :
                case "\t" :
                    if ($method) {
                        $this->_bodyCanonSpace = true;
                        break;
                    }
                default :
                    if ($this->_bodyCanonEmptyCounter > 0) {
                        $canon .= str_repeat("\r\n", $this->_bodyCanonEmptyCounter);
                        $this->_bodyCanonEmptyCounter = 0;
                    }
                    if ($this->_bodyCanonSpace) {
                        $this->_bodyCanonLine .= ' ';
                        $canon .= ' ';
                        $this->_bodyCanonSpace = false;
                    }
                    $this->_bodyCanonLine .= $string[$i];
                    $canon .= $string[$i];
            }
        }
        $this->_addToBodyHash($canon);
    }

    protected function _endOfBody()
    {
        // Add trailing Line return if last line is non empty
        if (strlen($this->_bodyCanonLine) > 0) {
            $this->_addToBodyHash("\r\n");
        }
        $this->_bodyHash = hash_final($this->_bodyHashHandler, true);
    }

    private function _addToBodyHash($string)
    {
        $len = strlen($string);
        if ($len > ($new_len = ($this->_maxLen - $this->_bodyLen))) {
            $string = substr($string, 0, $new_len);
            $len = $new_len;
        }
        hash_update($this->_bodyHashHandler, $string);
        $this->_bodyLen += $len;
    }

    private function _addToHeaderHash($header)
    {
        if ($this->_debugHeaders) {
            $this->_debugHeadersData[] = trim($header);
        }
        $this->_headerCanonData .= $header;
=======
                case ' ':
                case "\t":
                    if ($method) {
                        $this->bodyCanonSpace = true;
                        break;
                    }
                    // no break
                default:
                    if ($this->bodyCanonEmptyCounter > 0) {
                        $canon .= str_repeat("\r\n", $this->bodyCanonEmptyCounter);
                        $this->bodyCanonEmptyCounter = 0;
                    }
                    if ($this->bodyCanonSpace) {
                        $this->bodyCanonLine .= ' ';
                        $canon .= ' ';
                        $this->bodyCanonSpace = false;
                    }
                    $this->bodyCanonLine .= $string[$i];
                    $canon .= $string[$i];
            }
        }
        $this->addToBodyHash($canon);
    }

    protected function endOfBody()
    {
        // Add trailing Line return if last line is non empty
        if (\strlen($this->bodyCanonLine) > 0) {
            $this->addToBodyHash("\r\n");
        }
        $this->bodyHash = hash_final($this->bodyHashHandler, true);
    }

    private function addToBodyHash($string)
    {
        $len = \strlen($string);
        if ($len > ($new_len = ($this->maxLen - $this->bodyLen))) {
            $string = substr($string, 0, $new_len);
            $len = $new_len;
        }
        hash_update($this->bodyHashHandler, $string);
        $this->bodyLen += $len;
    }

    private function addToHeaderHash($header)
    {
        if ($this->debugHeaders) {
            $this->debugHeadersData[] = trim($header);
        }
        $this->headerCanonData .= $header;
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
        switch ($this->_hashAlgorithm) {
=======
    private function getEncryptedHash()
    {
        $signature = '';
        switch ($this->hashAlgorithm) {
>>>>>>> v2-test
            case 'rsa-sha1':
                $algorithm = OPENSSL_ALGO_SHA1;
                break;
            case 'rsa-sha256':
                $algorithm = OPENSSL_ALGO_SHA256;
                break;
        }
<<<<<<< HEAD
        $pkeyId = openssl_get_privatekey($this->_privateKey);
        if (!$pkeyId) {
            throw new Swift_SwiftException('Unable to load DKIM Private Key ['.openssl_error_string().']');
        }
        if (openssl_sign($this->_headerCanonData, $signature, $pkeyId, $algorithm)) {
=======
        $pkeyId = openssl_get_privatekey($this->privateKey, $this->passphrase);
        if (!$pkeyId) {
            throw new Swift_SwiftException('Unable to load DKIM Private Key ['.openssl_error_string().']');
        }
        if (openssl_sign($this->headerCanonData, $signature, $pkeyId, $algorithm)) {
>>>>>>> v2-test
            return $signature;
        }
        throw new Swift_SwiftException('Unable to sign DKIM Hash ['.openssl_error_string().']');
    }
}
