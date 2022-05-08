<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * DKIM Signer used to apply DKIM Signature to a message
 * Takes advantage of pecl extension.
 *
<<<<<<< HEAD
 * @author Xavier De Cock <xdecock@gmail.com>
 */
class Swift_Signers_OpenDKIMSigner extends Swift_Signers_DKIMSigner
{
    private $_peclLoaded = false;

    private $_dkimHandler = null;
=======
 * @author     Xavier De Cock <xdecock@gmail.com>
 *
 * @deprecated since SwiftMailer 6.1.0; use Swift_Signers_DKIMSigner instead.
 */
class Swift_Signers_OpenDKIMSigner extends Swift_Signers_DKIMSigner
{
    private $peclLoaded = false;

    private $dkimHandler = null;
>>>>>>> v2-test

    private $dropFirstLF = true;

    const CANON_RELAXED = 1;
    const CANON_SIMPLE = 2;
    const SIG_RSA_SHA1 = 3;
    const SIG_RSA_SHA256 = 4;

    public function __construct($privateKey, $domainName, $selector)
    {
<<<<<<< HEAD
        if (!extension_loaded('opendkim')) {
            throw new Swift_SwiftException('php-opendkim extension not found');
        }

        $this->_peclLoaded = true;
=======
        if (!\extension_loaded('opendkim')) {
            throw new Swift_SwiftException('php-opendkim extension not found');
        }

        $this->peclLoaded = true;
>>>>>>> v2-test

        parent::__construct($privateKey, $domainName, $selector);
    }

<<<<<<< HEAD
    public static function newInstance($privateKey, $domainName, $selector)
    {
        return new static($privateKey, $domainName, $selector);
    }

    public function addSignature(Swift_Mime_HeaderSet $headers)
    {
        $header = new Swift_Mime_Headers_OpenDKIMHeader('DKIM-Signature');
        $headerVal = $this->_dkimHandler->getSignatureHeader();
        if (!$headerVal) {
            throw new Swift_SwiftException('OpenDKIM Error: '.$this->_dkimHandler->getError());
=======
    public function addSignature(Swift_Mime_SimpleHeaderSet $headers)
    {
        $header = new Swift_Mime_Headers_OpenDKIMHeader('DKIM-Signature');
        $headerVal = $this->dkimHandler->getSignatureHeader();
        if (false === $headerVal || \is_int($headerVal)) {
            throw new Swift_SwiftException('OpenDKIM Error: '.$this->dkimHandler->getError());
>>>>>>> v2-test
        }
        $header->setValue($headerVal);
        $headers->set($header);

        return $this;
    }

<<<<<<< HEAD
    public function setHeaders(Swift_Mime_HeaderSet $headers)
    {
        $bodyLen = $this->_bodyLen;
        if (is_bool($bodyLen)) {
            $bodyLen = -1;
        }
        $hash = $this->_hashAlgorithm == 'rsa-sha1' ? OpenDKIMSign::ALG_RSASHA1 : OpenDKIMSign::ALG_RSASHA256;
        $bodyCanon = $this->_bodyCanon == 'simple' ? OpenDKIMSign::CANON_SIMPLE : OpenDKIMSign::CANON_RELAXED;
        $headerCanon = $this->_headerCanon == 'simple' ? OpenDKIMSign::CANON_SIMPLE : OpenDKIMSign::CANON_RELAXED;
        $this->_dkimHandler = new OpenDKIMSign($this->_privateKey, $this->_selector, $this->_domainName, $headerCanon, $bodyCanon, $hash, $bodyLen);
        // Hardcode signature Margin for now
        $this->_dkimHandler->setMargin(78);

        if (!is_numeric($this->_signatureTimestamp)) {
            OpenDKIM::setOption(OpenDKIM::OPTS_FIXEDTIME, time());
        } else {
            if (!OpenDKIM::setOption(OpenDKIM::OPTS_FIXEDTIME, $this->_signatureTimestamp)) {
                throw new Swift_SwiftException('Unable to force signature timestamp ['.openssl_error_string().']');
            }
        }
        if (isset($this->_signerIdentity)) {
            $this->_dkimHandler->setSigner($this->_signerIdentity);
=======
    public function setHeaders(Swift_Mime_SimpleHeaderSet $headers)
    {
        $hash = 'rsa-sha1' == $this->hashAlgorithm ? OpenDKIMSign::ALG_RSASHA1 : OpenDKIMSign::ALG_RSASHA256;
        $bodyCanon = 'simple' == $this->bodyCanon ? OpenDKIMSign::CANON_SIMPLE : OpenDKIMSign::CANON_RELAXED;
        $headerCanon = 'simple' == $this->headerCanon ? OpenDKIMSign::CANON_SIMPLE : OpenDKIMSign::CANON_RELAXED;
        $this->dkimHandler = new OpenDKIMSign($this->privateKey, $this->selector, $this->domainName, $headerCanon, $bodyCanon, $hash, -1);
        // Hardcode signature Margin for now
        $this->dkimHandler->setMargin(78);

        if (!is_numeric($this->signatureTimestamp)) {
            OpenDKIM::setOption(OpenDKIM::OPTS_FIXEDTIME, time());
        } else {
            if (!OpenDKIM::setOption(OpenDKIM::OPTS_FIXEDTIME, $this->signatureTimestamp)) {
                throw new Swift_SwiftException('Unable to force signature timestamp ['.openssl_error_string().']');
            }
        }
        if (isset($this->signerIdentity)) {
            $this->dkimHandler->setSigner($this->signerIdentity);
>>>>>>> v2-test
        }
        $listHeaders = $headers->listAll();
        foreach ($listHeaders as $hName) {
            // Check if we need to ignore Header
<<<<<<< HEAD
            if (!isset($this->_ignoredHeaders[strtolower($hName)])) {
                $tmp = $headers->getAll($hName);
                if ($headers->has($hName)) {
                    foreach ($tmp as $header) {
                        if ($header->getFieldBody() != '') {
                            $htosign = $header->toString();
                            $this->_dkimHandler->header($htosign);
                            $this->_signedHeaders[] = $header->getFieldName();
=======
            if (!isset($this->ignoredHeaders[strtolower($hName)])) {
                $tmp = $headers->getAll($hName);
                if ($headers->has($hName)) {
                    foreach ($tmp as $header) {
                        if ('' != $header->getFieldBody()) {
                            $htosign = $header->toString();
                            $this->dkimHandler->header($htosign);
                            $this->signedHeaders[] = $header->getFieldName();
>>>>>>> v2-test
                        }
                    }
                }
            }
        }

        return $this;
    }

    public function startBody()
    {
<<<<<<< HEAD
        if (!$this->_peclLoaded) {
            return parent::startBody();
        }
        $this->dropFirstLF = true;
        $this->_dkimHandler->eoh();
=======
        if (!$this->peclLoaded) {
            return parent::startBody();
        }
        $this->dropFirstLF = true;
        $this->dkimHandler->eoh();
>>>>>>> v2-test

        return $this;
    }

    public function endBody()
    {
<<<<<<< HEAD
        if (!$this->_peclLoaded) {
            return parent::endBody();
        }
        $this->_dkimHandler->eom();
=======
        if (!$this->peclLoaded) {
            return parent::endBody();
        }
        $this->dkimHandler->eom();
>>>>>>> v2-test

        return $this;
    }

    public function reset()
    {
<<<<<<< HEAD
        $this->_dkimHandler = null;
=======
        $this->dkimHandler = null;
>>>>>>> v2-test
        parent::reset();

        return $this;
    }

    /**
     * Set the signature timestamp.
     *
     * @param int $time
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
     * @param int $time
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
<<<<<<< HEAD
     * @return Swift_Signers_DKIMSigner
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

    // Protected

<<<<<<< HEAD
    protected function _canonicalizeBody($string)
    {
        if (!$this->_peclLoaded) {
            return parent::_canonicalizeBody($string);
        }
        if (false && $this->dropFirstLF === true) {
            if ($string[0] == "\r" && $string[1] == "\n") {
=======
    protected function canonicalizeBody($string)
    {
        if (!$this->peclLoaded) {
            return parent::canonicalizeBody($string);
        }
        if (true === $this->dropFirstLF) {
            if ("\r" == $string[0] && "\n" == $string[1]) {
>>>>>>> v2-test
                $string = substr($string, 2);
            }
        }
        $this->dropFirstLF = false;
<<<<<<< HEAD
        if (strlen($string)) {
            $this->_dkimHandler->body($string);
=======
        if (\strlen($string)) {
            $this->dkimHandler->body($string);
>>>>>>> v2-test
        }
    }
}
