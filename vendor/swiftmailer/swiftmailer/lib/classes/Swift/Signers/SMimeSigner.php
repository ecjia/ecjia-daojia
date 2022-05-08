<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * MIME Message Signer used to apply S/MIME Signature/Encryption to a message.
 *
<<<<<<< HEAD
 *
 * @author Romain-Geissler
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
=======
 * @author Romain-Geissler
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 * @author Jan Flora <jf@penneo.com>
>>>>>>> v2-test
 */
class Swift_Signers_SMimeSigner implements Swift_Signers_BodySigner
{
    protected $signCertificate;
    protected $signPrivateKey;
    protected $encryptCert;
    protected $signThenEncrypt = true;
    protected $signLevel;
    protected $encryptLevel;
    protected $signOptions;
    protected $encryptOptions;
    protected $encryptCipher;
    protected $extraCerts = null;
<<<<<<< HEAD
=======
    protected $wrapFullMessage = false;
>>>>>>> v2-test

    /**
     * @var Swift_StreamFilters_StringReplacementFilterFactory
     */
    protected $replacementFactory;

    /**
<<<<<<< HEAD
     * @var Swift_Mime_HeaderFactory
=======
     * @var Swift_Mime_SimpleHeaderFactory
>>>>>>> v2-test
     */
    protected $headerFactory;

    /**
     * Constructor.
     *
     * @param string|null $signCertificate
     * @param string|null $signPrivateKey
     * @param string|null $encryptCertificate
     */
    public function __construct($signCertificate = null, $signPrivateKey = null, $encryptCertificate = null)
    {
        if (null !== $signPrivateKey) {
            $this->setSignCertificate($signCertificate, $signPrivateKey);
        }

        if (null !== $encryptCertificate) {
            $this->setEncryptCertificate($encryptCertificate);
        }

        $this->replacementFactory = Swift_DependencyContainer::getInstance()
            ->lookup('transport.replacementfactory');

        $this->signOptions = PKCS7_DETACHED;
<<<<<<< HEAD

        // Supported since php5.4
        if (defined('OPENSSL_CIPHER_AES_128_CBC')) {
            $this->encryptCipher = OPENSSL_CIPHER_AES_128_CBC;
        } else {
            $this->encryptCipher = OPENSSL_CIPHER_RC2_128;
        }
    }

    /**
     * Returns an new Swift_Signers_SMimeSigner instance.
     *
     * @param string $certificate
     * @param string $privateKey
     *
     * @return Swift_Signers_SMimeSigner
     */
    public static function newInstance($certificate = null, $privateKey = null)
    {
        return new self($certificate, $privateKey);
=======
        $this->encryptCipher = OPENSSL_CIPHER_AES_128_CBC;
>>>>>>> v2-test
    }

    /**
     * Set the certificate location to use for signing.
     *
<<<<<<< HEAD
     * @link http://www.php.net/manual/en/openssl.pkcs7.flags.php
=======
     * @see https://secure.php.net/manual/en/openssl.pkcs7.flags.php
>>>>>>> v2-test
     *
     * @param string       $certificate
     * @param string|array $privateKey  If the key needs an passphrase use array('file-location', 'passphrase') instead
     * @param int          $signOptions Bitwise operator options for openssl_pkcs7_sign()
     * @param string       $extraCerts  A file containing intermediate certificates needed by the signing certificate
     *
<<<<<<< HEAD
     * @return Swift_Signers_SMimeSigner
=======
     * @return $this
>>>>>>> v2-test
     */
    public function setSignCertificate($certificate, $privateKey = null, $signOptions = PKCS7_DETACHED, $extraCerts = null)
    {
        $this->signCertificate = 'file://'.str_replace('\\', '/', realpath($certificate));

        if (null !== $privateKey) {
<<<<<<< HEAD
            if (is_array($privateKey)) {
=======
            if (\is_array($privateKey)) {
>>>>>>> v2-test
                $this->signPrivateKey = $privateKey;
                $this->signPrivateKey[0] = 'file://'.str_replace('\\', '/', realpath($privateKey[0]));
            } else {
                $this->signPrivateKey = 'file://'.str_replace('\\', '/', realpath($privateKey));
            }
        }

        $this->signOptions = $signOptions;
<<<<<<< HEAD
        if (null !== $extraCerts) {
            $this->extraCerts = str_replace('\\', '/', realpath($extraCerts));
        }
=======
        $this->extraCerts = $extraCerts ? realpath($extraCerts) : null;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Set the certificate location to use for encryption.
     *
<<<<<<< HEAD
     * @link http://www.php.net/manual/en/openssl.pkcs7.flags.php
     * @link http://nl3.php.net/manual/en/openssl.ciphers.php
=======
     * @see https://secure.php.net/manual/en/openssl.pkcs7.flags.php
     * @see https://secure.php.net/manual/en/openssl.ciphers.php
>>>>>>> v2-test
     *
     * @param string|array $recipientCerts Either an single X.509 certificate, or an assoc array of X.509 certificates.
     * @param int          $cipher
     *
<<<<<<< HEAD
     * @return Swift_Signers_SMimeSigner
     */
    public function setEncryptCertificate($recipientCerts, $cipher = null)
    {
        if (is_array($recipientCerts)) {
            $this->encryptCert = array();
=======
     * @return $this
     */
    public function setEncryptCertificate($recipientCerts, $cipher = null)
    {
        if (\is_array($recipientCerts)) {
            $this->encryptCert = [];
>>>>>>> v2-test

            foreach ($recipientCerts as $cert) {
                $this->encryptCert[] = 'file://'.str_replace('\\', '/', realpath($cert));
            }
        } else {
            $this->encryptCert = 'file://'.str_replace('\\', '/', realpath($recipientCerts));
        }

        if (null !== $cipher) {
            $this->encryptCipher = $cipher;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getSignCertificate()
    {
        return $this->signCertificate;
    }

    /**
     * @return string
     */
    public function getSignPrivateKey()
    {
        return $this->signPrivateKey;
    }

    /**
     * Set perform signing before encryption.
     *
     * The default is to first sign the message and then encrypt.
     * But some older mail clients, namely Microsoft Outlook 2000 will work when the message first encrypted.
     * As this goes against the official specs, its recommended to only use 'encryption -> signing' when specifically targeting these 'broken' clients.
     *
     * @param bool $signThenEncrypt
     *
<<<<<<< HEAD
     * @return Swift_Signers_SMimeSigner
=======
     * @return $this
>>>>>>> v2-test
     */
    public function setSignThenEncrypt($signThenEncrypt = true)
    {
        $this->signThenEncrypt = $signThenEncrypt;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSignThenEncrypt()
    {
        return $this->signThenEncrypt;
    }

    /**
     * Resets internal states.
     *
<<<<<<< HEAD
     * @return Swift_Signers_SMimeSigner
=======
     * @return $this
>>>>>>> v2-test
     */
    public function reset()
    {
        return $this;
    }

    /**
<<<<<<< HEAD
     * Change the Swift_Message to apply the signing.
     *
     * @param Swift_Message $message
     *
     * @return Swift_Signers_SMimeSigner
=======
     * Specify whether to wrap the entire MIME message in the S/MIME message.
     *
     * According to RFC5751 section 3.1:
     * In order to protect outer, non-content-related message header fields
     * (for instance, the "Subject", "To", "From", and "Cc" fields), the
     * sending client MAY wrap a full MIME message in a message/rfc822
     * wrapper in order to apply S/MIME security services to these header
     * fields.  It is up to the receiving client to decide how to present
     * this "inner" header along with the unprotected "outer" header.
     *
     * @param bool $wrap
     *
     * @return $this
     */
    public function setWrapFullMessage($wrap)
    {
        $this->wrapFullMessage = $wrap;
    }

    /**
     * Change the Swift_Message to apply the signing.
     *
     * @return $this
>>>>>>> v2-test
     */
    public function signMessage(Swift_Message $message)
    {
        if (null === $this->signCertificate && null === $this->encryptCert) {
            return $this;
        }

<<<<<<< HEAD
        // Store the message using ByteStream to a file{1}
        // Remove all Children
        // Sign file{1}, parse the new MIME headers and set them on the primary MimeEntity
        // Set the singed-body as the new body (without boundary)

        $messageStream = new Swift_ByteStream_TemporaryFileByteStream();
        $this->toSMimeByteStream($messageStream, $message);
        $message->setEncoder(Swift_DependencyContainer::getInstance()->lookup('mime.rawcontentencoder'));

        $message->setChildren(array());
        $this->streamToMime($messageStream, $message);
=======
        if ($this->signThenEncrypt) {
            $this->smimeSignMessage($message);
            $this->smimeEncryptMessage($message);
        } else {
            $this->smimeEncryptMessage($message);
            $this->smimeSignMessage($message);
        }
>>>>>>> v2-test
    }

    /**
     * Return the list of header a signer might tamper.
     *
     * @return array
     */
    public function getAlteredHeaders()
    {
<<<<<<< HEAD
        return array('Content-Type', 'Content-Transfer-Encoding', 'Content-Disposition');
    }

    /**
     * @param Swift_InputByteStream $inputStream
     * @param Swift_Message         $mimeEntity
     */
    protected function toSMimeByteStream(Swift_InputByteStream $inputStream, Swift_Message $message)
    {
        $mimeEntity = $this->createMessage($message);
        $messageStream = new Swift_ByteStream_TemporaryFileByteStream();

        $mimeEntity->toByteStream($messageStream);
        $messageStream->commit();

        if (null !== $this->signCertificate && null !== $this->encryptCert) {
            $temporaryStream = new Swift_ByteStream_TemporaryFileByteStream();

            if ($this->signThenEncrypt) {
                $this->messageStreamToSignedByteStream($messageStream, $temporaryStream);
                $this->messageStreamToEncryptedByteStream($temporaryStream, $inputStream);
            } else {
                $this->messageStreamToEncryptedByteStream($messageStream, $temporaryStream);
                $this->messageStreamToSignedByteStream($temporaryStream, $inputStream);
            }
        } elseif ($this->signCertificate !== null) {
            $this->messageStreamToSignedByteStream($messageStream, $inputStream);
        } else {
            $this->messageStreamToEncryptedByteStream($messageStream, $inputStream);
        }
    }

    /**
     * @param Swift_Message $message
     *
     * @return Swift_Message
     */
    protected function createMessage(Swift_Message $message)
    {
        $mimeEntity = new Swift_Message('', $message->getBody(), $message->getContentType(), $message->getCharset());
        $mimeEntity->setChildren($message->getChildren());

        $messageHeaders = $mimeEntity->getHeaders();
        $messageHeaders->remove('Message-ID');
        $messageHeaders->remove('Date');
        $messageHeaders->remove('Subject');
        $messageHeaders->remove('MIME-Version');
        $messageHeaders->remove('To');
        $messageHeaders->remove('From');

        return $mimeEntity;
    }

    /**
     * @param Swift_FileStream      $outputStream
     * @param Swift_InputByteStream $inputStream
     *
     * @throws Swift_IoException
     */
    protected function messageStreamToSignedByteStream(Swift_FileStream $outputStream, Swift_InputByteStream $inputStream)
    {
        $signedMessageStream = new Swift_ByteStream_TemporaryFileByteStream();

        $args = array($outputStream->getPath(), $signedMessageStream->getPath(), $this->signCertificate, $this->signPrivateKey, array(), $this->signOptions);
        if (null !== $this->extraCerts) {
            $args[] = $this->extraCerts;
        }

        if (!call_user_func_array('openssl_pkcs7_sign', $args)) {
            throw new Swift_IoException(sprintf('Failed to sign S/Mime message. Error: "%s".', openssl_error_string()));
        }

        $this->copyFromOpenSSLOutput($signedMessageStream, $inputStream);
    }

    /**
     * @param Swift_FileStream      $outputStream
     * @param Swift_InputByteStream $is
     *
     * @throws Swift_IoException
     */
    protected function messageStreamToEncryptedByteStream(Swift_FileStream $outputStream, Swift_InputByteStream $is)
    {
        $encryptedMessageStream = new Swift_ByteStream_TemporaryFileByteStream();

        if (!openssl_pkcs7_encrypt($outputStream->getPath(), $encryptedMessageStream->getPath(), $this->encryptCert, array(), 0, $this->encryptCipher)) {
            throw new Swift_IoException(sprintf('Failed to encrypt S/Mime message. Error: "%s".', openssl_error_string()));
        }

        $this->copyFromOpenSSLOutput($encryptedMessageStream, $is);
    }

    /**
     * @param Swift_OutputByteStream $fromStream
     * @param Swift_InputByteStream  $toStream
     */
    protected function copyFromOpenSSLOutput(Swift_OutputByteStream $fromStream, Swift_InputByteStream $toStream)
    {
        $bufferLength = 4096;
        $filteredStream = new Swift_ByteStream_TemporaryFileByteStream();
        $filteredStream->addFilter($this->replacementFactory->createFilter("\r\n", "\n"), 'CRLF to LF');
        $filteredStream->addFilter($this->replacementFactory->createFilter("\n", "\r\n"), 'LF to CRLF');

        while (false !== ($buffer = $fromStream->read($bufferLength))) {
            $filteredStream->write($buffer);
        }

        $filteredStream->flushBuffers();

        while (false !== ($buffer = $filteredStream->read($bufferLength))) {
            $toStream->write($buffer);
        }

        $toStream->commit();
    }

    /**
     * Merges an OutputByteStream to Swift_Message.
     *
     * @param Swift_OutputByteStream $fromStream
     * @param Swift_Message          $message
     */
    protected function streamToMime(Swift_OutputByteStream $fromStream, Swift_Message $message)
    {
        $bufferLength = 78;
        $headerData = '';

        $fromStream->setReadPointer(0);

        while (($buffer = $fromStream->read($bufferLength)) !== false) {
            $headerData .= $buffer;

            if (false !== strpos($buffer, "\r\n\r\n")) {
=======
        return ['Content-Type', 'Content-Transfer-Encoding', 'Content-Disposition'];
    }

    /**
     * Sign a Swift message.
     */
    protected function smimeSignMessage(Swift_Message $message)
    {
        // If we don't have a certificate we can't sign the message
        if (null === $this->signCertificate) {
            return;
        }

        // Work on a clone of the original message
        $signMessage = clone $message;
        $signMessage->clearSigners();

        if ($this->wrapFullMessage) {
            // The original message essentially becomes the body of the new
            // wrapped message
            $signMessage = $this->wrapMimeMessage($signMessage);
        } else {
            // Only keep header needed to parse the body correctly
            $this->clearAllHeaders($signMessage);
            $this->copyHeaders(
                $message,
                $signMessage,
                [
                    'Content-Type',
                    'Content-Transfer-Encoding',
                    'Content-Disposition',
                ]
            );
        }

        // Copy the cloned message into a temporary file stream
        $messageStream = new Swift_ByteStream_TemporaryFileByteStream();
        $signMessage->toByteStream($messageStream);
        $messageStream->commit();
        $signedMessageStream = new Swift_ByteStream_TemporaryFileByteStream();

        // Sign the message using openssl
        if (!openssl_pkcs7_sign(
                $messageStream->getPath(),
                $signedMessageStream->getPath(),
                $this->signCertificate,
                $this->signPrivateKey,
                [],
                $this->signOptions,
                $this->extraCerts
            )
        ) {
            throw new Swift_IoException(sprintf('Failed to sign S/Mime message. Error: "%s".', openssl_error_string()));
        }

        // Parse the resulting signed message content back into the Swift message
        // preserving the original headers
        $this->parseSSLOutput($signedMessageStream, $message);
    }

    /**
     * Encrypt a Swift message.
     */
    protected function smimeEncryptMessage(Swift_Message $message)
    {
        // If we don't have a certificate we can't encrypt the message
        if (null === $this->encryptCert) {
            return;
        }

        // Work on a clone of the original message
        $encryptMessage = clone $message;
        $encryptMessage->clearSigners();

        if ($this->wrapFullMessage) {
            // The original message essentially becomes the body of the new
            // wrapped message
            $encryptMessage = $this->wrapMimeMessage($encryptMessage);
        } else {
            // Only keep header needed to parse the body correctly
            $this->clearAllHeaders($encryptMessage);
            $this->copyHeaders(
                $message,
                $encryptMessage,
                [
                    'Content-Type',
                    'Content-Transfer-Encoding',
                    'Content-Disposition',
                ]
            );
        }

        // Convert the message content (including headers) to a string
        // and place it in a temporary file
        $messageStream = new Swift_ByteStream_TemporaryFileByteStream();
        $encryptMessage->toByteStream($messageStream);
        $messageStream->commit();
        $encryptedMessageStream = new Swift_ByteStream_TemporaryFileByteStream();

        // Encrypt the message
        if (!openssl_pkcs7_encrypt(
                $messageStream->getPath(),
                $encryptedMessageStream->getPath(),
                $this->encryptCert,
                [],
                0,
                $this->encryptCipher
            )
        ) {
            throw new Swift_IoException(sprintf('Failed to encrypt S/Mime message. Error: "%s".', openssl_error_string()));
        }

        // Parse the resulting signed message content back into the Swift message
        // preserving the original headers
        $this->parseSSLOutput($encryptedMessageStream, $message);
    }

    /**
     * Copy named headers from one Swift message to another.
     */
    protected function copyHeaders(
        Swift_Message $fromMessage,
        Swift_Message $toMessage,
        array $headers = []
    ) {
        foreach ($headers as $header) {
            $this->copyHeader($fromMessage, $toMessage, $header);
        }
    }

    /**
     * Copy a single header from one Swift message to another.
     *
     * @param string $headerName
     */
    protected function copyHeader(Swift_Message $fromMessage, Swift_Message $toMessage, $headerName)
    {
        $header = $fromMessage->getHeaders()->get($headerName);
        if (!$header) {
            return;
        }
        $headers = $toMessage->getHeaders();
        switch ($header->getFieldType()) {
            case Swift_Mime_Header::TYPE_TEXT:
                $headers->addTextHeader($header->getFieldName(), $header->getValue());
                break;
            case Swift_Mime_Header::TYPE_PARAMETERIZED:
                $headers->addParameterizedHeader(
                    $header->getFieldName(),
                    $header->getValue(),
                    $header->getParameters()
                );
                break;
        }
    }

    /**
     * Remove all headers from a Swift message.
     */
    protected function clearAllHeaders(Swift_Message $message)
    {
        $headers = $message->getHeaders();
        foreach ($headers->listAll() as $header) {
            $headers->removeAll($header);
        }
    }

    /**
     * Wraps a Swift_Message in a message/rfc822 MIME part.
     *
     * @return Swift_MimePart
     */
    protected function wrapMimeMessage(Swift_Message $message)
    {
        // Start by copying the original message into a message stream
        $messageStream = new Swift_ByteStream_TemporaryFileByteStream();
        $message->toByteStream($messageStream);
        $messageStream->commit();

        // Create a new MIME part that wraps the original stream
        $wrappedMessage = new Swift_MimePart($messageStream, 'message/rfc822');
        $wrappedMessage->setEncoder(new Swift_Mime_ContentEncoder_PlainContentEncoder('7bit'));

        return $wrappedMessage;
    }

    protected function parseSSLOutput(Swift_InputByteStream $inputStream, Swift_Message $message)
    {
        $messageStream = new Swift_ByteStream_TemporaryFileByteStream();
        $this->copyFromOpenSSLOutput($inputStream, $messageStream);

        $this->streamToMime($messageStream, $message);
    }

    /**
     * Merges an OutputByteStream from OpenSSL to a Swift_Message.
     */
    protected function streamToMime(Swift_OutputByteStream $fromStream, Swift_Message $message)
    {
        // Parse the stream into headers and body
        list($headers, $messageStream) = $this->parseStream($fromStream);

        // Get the original message headers
        $messageHeaders = $message->getHeaders();

        // Let the stream determine the headers describing the body content,
        // since the body of the original message is overwritten by the body
        // coming from the stream.
        // These are all content-* headers.

        // Default transfer encoding is 7bit if not set
        $encoding = '';
        // Remove all existing transfer encoding headers
        $messageHeaders->removeAll('Content-Transfer-Encoding');
        // See whether the stream sets the transfer encoding
        if (isset($headers['content-transfer-encoding'])) {
            $encoding = $headers['content-transfer-encoding'];
        }

        // We use the null content encoder, since the body is already encoded
        // according to the transfer encoding specified in the stream
        $message->setEncoder(new Swift_Mime_ContentEncoder_NullContentEncoder($encoding));

        // Set the disposition, if present
        if (isset($headers['content-disposition'])) {
            $messageHeaders->addTextHeader('Content-Disposition', $headers['content-disposition']);
        }

        // Copy over the body from the stream using the content type dictated
        // by the stream content
        $message->setChildren([]);
        $message->setBody($messageStream, $headers['content-type']);
    }

    /**
     * This message will parse the headers of a MIME email byte stream
     * and return an array that contains the headers as an associative
     * array and the email body as a string.
     *
     * @return array
     */
    protected function parseStream(Swift_OutputByteStream $emailStream)
    {
        $bufferLength = 78;
        $headerData = '';
        $headerBodySeparator = "\r\n\r\n";

        $emailStream->setReadPointer(0);

        // Read out the headers section from the stream to a string
        while (false !== ($buffer = $emailStream->read($bufferLength))) {
            $headerData .= $buffer;

            $headersPosEnd = strpos($headerData, $headerBodySeparator);

            // Stop reading if we found the end of the headers
            if (false !== $headersPosEnd) {
>>>>>>> v2-test
                break;
            }
        }

<<<<<<< HEAD
        $headersPosEnd = strpos($headerData, "\r\n\r\n");
        $headerData = trim($headerData);
        $headerData = substr($headerData, 0, $headersPosEnd);
        $headerLines = explode("\r\n", $headerData);
        unset($headerData);

        $headers = array();
        $currentHeaderName = '';

        foreach ($headerLines as $headerLine) {
            // Line separated
            if (ctype_space($headerLines[0]) || false === strpos($headerLine, ':')) {
=======
        // Split the header data into lines
        $headerData = trim(substr($headerData, 0, $headersPosEnd));
        $headerLines = explode("\r\n", $headerData);
        unset($headerData);

        $headers = [];
        $currentHeaderName = '';

        // Transform header lines into an associative array
        foreach ($headerLines as $headerLine) {
            // Handle headers that span multiple lines
            if (false === strpos($headerLine, ':')) {
>>>>>>> v2-test
                $headers[$currentHeaderName] .= ' '.trim($headerLine);
                continue;
            }

            $header = explode(':', $headerLine, 2);
            $currentHeaderName = strtolower($header[0]);
            $headers[$currentHeaderName] = trim($header[1]);
        }

<<<<<<< HEAD
        $messageStream = new Swift_ByteStream_TemporaryFileByteStream();
        $messageStream->addFilter($this->replacementFactory->createFilter("\r\n", "\n"), 'CRLF to LF');
        $messageStream->addFilter($this->replacementFactory->createFilter("\n", "\r\n"), 'LF to CRLF');

        $messageHeaders = $message->getHeaders();

        // No need to check for 'application/pkcs7-mime', as this is always base64
        if ('multipart/signed;' === substr($headers['content-type'], 0, 17)) {
            if (!preg_match('/boundary=("[^"]+"|(?:[^\s]+|$))/is', $headers['content-type'], $contentTypeData)) {
                throw new Swift_SwiftException('Failed to find Boundary parameter');
            }

            $boundary = trim($contentTypeData['1'], '"');

            // Skip the header and CRLF CRLF
            $fromStream->setReadPointer($headersPosEnd + 4);

            while (false !== ($buffer = $fromStream->read($bufferLength))) {
                $messageStream->write($buffer);
            }

            $messageStream->commit();

            $messageHeaders->remove('Content-Transfer-Encoding');
            $message->setContentType($headers['content-type']);
            $message->setBoundary($boundary);
            $message->setBody($messageStream);
        } else {
            $fromStream->setReadPointer($headersPosEnd + 4);

            if (null === $this->headerFactory) {
                $this->headerFactory = Swift_DependencyContainer::getInstance()->lookup('mime.headerfactory');
            }

            $message->setContentType($headers['content-type']);
            $messageHeaders->set($this->headerFactory->createTextHeader('Content-Transfer-Encoding', $headers['content-transfer-encoding']));
            $messageHeaders->set($this->headerFactory->createTextHeader('Content-Disposition', $headers['content-disposition']));

            while (false !== ($buffer = $fromStream->read($bufferLength))) {
                $messageStream->write($buffer);
            }

            $messageStream->commit();
            $message->setBody($messageStream);
        }
=======
        // Read the entire email body into a byte stream
        $bodyStream = new Swift_ByteStream_TemporaryFileByteStream();

        // Skip the header and separator and point to the body
        $emailStream->setReadPointer($headersPosEnd + \strlen($headerBodySeparator));

        while (false !== ($buffer = $emailStream->read($bufferLength))) {
            $bodyStream->write($buffer);
        }

        $bodyStream->commit();

        return [$headers, $bodyStream];
    }

    protected function copyFromOpenSSLOutput(Swift_OutputByteStream $fromStream, Swift_InputByteStream $toStream)
    {
        $bufferLength = 4096;
        $filteredStream = new Swift_ByteStream_TemporaryFileByteStream();
        $filteredStream->addFilter($this->replacementFactory->createFilter("\r\n", "\n"), 'CRLF to LF');
        $filteredStream->addFilter($this->replacementFactory->createFilter("\n", "\r\n"), 'LF to CRLF');

        while (false !== ($buffer = $fromStream->read($bufferLength))) {
            $filteredStream->write($buffer);
        }

        $filteredStream->flushBuffers();

        while (false !== ($buffer = $filteredStream->read($bufferLength))) {
            $toStream->write($buffer);
        }

        $toStream->commit();
>>>>>>> v2-test
    }
}
