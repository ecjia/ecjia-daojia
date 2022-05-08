<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation;

<<<<<<< HEAD
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
=======
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
>>>>>>> v2-test

/**
 * BinaryFileResponse represents an HTTP response delivering a file.
 *
 * @author Niklas Fiekas <niklas.fiekas@tu-clausthal.de>
 * @author stealth35 <stealth35-php@live.fr>
 * @author Igor Wiedler <igor@wiedler.ch>
 * @author Jordan Alliot <jordan.alliot@gmail.com>
 * @author Sergey Linnik <linniksa@gmail.com>
 */
class BinaryFileResponse extends Response
{
    protected static $trustXSendfileTypeHeader = false;

    /**
     * @var File
     */
    protected $file;
<<<<<<< HEAD
    protected $offset;
    protected $maxlen;
    protected $deleteFileAfterSend = false;

    /**
     * Constructor.
     *
=======
    protected $offset = 0;
    protected $maxlen = -1;
    protected $deleteFileAfterSend = false;

    /**
>>>>>>> v2-test
     * @param \SplFileInfo|string $file               The file to stream
     * @param int                 $status             The response status code
     * @param array               $headers            An array of response headers
     * @param bool                $public             Files are public by default
<<<<<<< HEAD
     * @param null|string         $contentDisposition The type of Content-Disposition to set automatically with the filename
     * @param bool                $autoEtag           Whether the ETag header should be automatically set
     * @param bool                $autoLastModified   Whether the Last-Modified header should be automatically set
     */
    public function __construct($file, $status = 200, $headers = array(), $public = true, $contentDisposition = null, $autoEtag = false, $autoLastModified = true)
=======
     * @param string|null         $contentDisposition The type of Content-Disposition to set automatically with the filename
     * @param bool                $autoEtag           Whether the ETag header should be automatically set
     * @param bool                $autoLastModified   Whether the Last-Modified header should be automatically set
     */
    public function __construct($file, int $status = 200, array $headers = [], bool $public = true, string $contentDisposition = null, bool $autoEtag = false, bool $autoLastModified = true)
>>>>>>> v2-test
    {
        parent::__construct(null, $status, $headers);

        $this->setFile($file, $contentDisposition, $autoEtag, $autoLastModified);

        if ($public) {
            $this->setPublic();
        }
    }

    /**
     * @param \SplFileInfo|string $file               The file to stream
     * @param int                 $status             The response status code
     * @param array               $headers            An array of response headers
     * @param bool                $public             Files are public by default
<<<<<<< HEAD
     * @param null|string         $contentDisposition The type of Content-Disposition to set automatically with the filename
     * @param bool                $autoEtag           Whether the ETag header should be automatically set
     * @param bool                $autoLastModified   Whether the Last-Modified header should be automatically set
     *
     * @return BinaryFileResponse The created response
     */
    public static function create($file = null, $status = 200, $headers = array(), $public = true, $contentDisposition = null, $autoEtag = false, $autoLastModified = true)
    {
=======
     * @param string|null         $contentDisposition The type of Content-Disposition to set automatically with the filename
     * @param bool                $autoEtag           Whether the ETag header should be automatically set
     * @param bool                $autoLastModified   Whether the Last-Modified header should be automatically set
     *
     * @return static
     *
     * @deprecated since Symfony 5.2, use __construct() instead.
     */
    public static function create($file = null, int $status = 200, array $headers = [], bool $public = true, string $contentDisposition = null, bool $autoEtag = false, bool $autoLastModified = true)
    {
        trigger_deprecation('symfony/http-foundation', '5.2', 'The "%s()" method is deprecated, use "new %s()" instead.', __METHOD__, static::class);

>>>>>>> v2-test
        return new static($file, $status, $headers, $public, $contentDisposition, $autoEtag, $autoLastModified);
    }

    /**
     * Sets the file to stream.
     *
<<<<<<< HEAD
     * @param \SplFileInfo|string $file               The file to stream
     * @param string              $contentDisposition
     * @param bool                $autoEtag
     * @param bool                $autoLastModified
     *
     * @return BinaryFileResponse
     *
     * @throws FileException
     */
    public function setFile($file, $contentDisposition = null, $autoEtag = false, $autoLastModified = true)
=======
     * @param \SplFileInfo|string $file The file to stream
     *
     * @return $this
     *
     * @throws FileException
     */
    public function setFile($file, string $contentDisposition = null, bool $autoEtag = false, bool $autoLastModified = true)
>>>>>>> v2-test
    {
        if (!$file instanceof File) {
            if ($file instanceof \SplFileInfo) {
                $file = new File($file->getPathname());
            } else {
                $file = new File((string) $file);
            }
        }

        if (!$file->isReadable()) {
            throw new FileException('File must be readable.');
        }

        $this->file = $file;

        if ($autoEtag) {
            $this->setAutoEtag();
        }

        if ($autoLastModified) {
            $this->setAutoLastModified();
        }

        if ($contentDisposition) {
            $this->setContentDisposition($contentDisposition);
        }

        return $this;
    }

    /**
     * Gets the file.
     *
     * @return File The file to stream
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Automatically sets the Last-Modified header according the file modification date.
     */
    public function setAutoLastModified()
    {
        $this->setLastModified(\DateTime::createFromFormat('U', $this->file->getMTime()));

        return $this;
    }

    /**
     * Automatically sets the ETag header according to the checksum of the file.
     */
    public function setAutoEtag()
    {
<<<<<<< HEAD
        $this->setEtag(sha1_file($this->file->getPathname()));
=======
        $this->setEtag(base64_encode(hash_file('sha256', $this->file->getPathname(), true)));
>>>>>>> v2-test

        return $this;
    }

    /**
     * Sets the Content-Disposition header with the given filename.
     *
     * @param string $disposition      ResponseHeaderBag::DISPOSITION_INLINE or ResponseHeaderBag::DISPOSITION_ATTACHMENT
<<<<<<< HEAD
     * @param string $filename         Optionally use this filename instead of the real name of the file
     * @param string $filenameFallback A fallback filename, containing only ASCII characters. Defaults to an automatically encoded filename
     *
     * @return BinaryFileResponse
     */
    public function setContentDisposition($disposition, $filename = '', $filenameFallback = '')
    {
        if ($filename === '') {
=======
     * @param string $filename         Optionally use this UTF-8 encoded filename instead of the real name of the file
     * @param string $filenameFallback A fallback filename, containing only ASCII characters. Defaults to an automatically encoded filename
     *
     * @return $this
     */
    public function setContentDisposition(string $disposition, string $filename = '', string $filenameFallback = '')
    {
        if ('' === $filename) {
>>>>>>> v2-test
            $filename = $this->file->getFilename();
        }

        if ('' === $filenameFallback && (!preg_match('/^[\x20-\x7e]*$/', $filename) || false !== strpos($filename, '%'))) {
<<<<<<< HEAD
            $encoding = mb_detect_encoding($filename, null, true);

            for ($i = 0; $i < mb_strlen($filename, $encoding); ++$i) {
                $char = mb_substr($filename, $i, 1, $encoding);

                if ('%' === $char || ord($char) < 32 || ord($char) > 126) {
=======
            $encoding = mb_detect_encoding($filename, null, true) ?: '8bit';

            for ($i = 0, $filenameLength = mb_strlen($filename, $encoding); $i < $filenameLength; ++$i) {
                $char = mb_substr($filename, $i, 1, $encoding);

                if ('%' === $char || \ord($char) < 32 || \ord($char) > 126) {
>>>>>>> v2-test
                    $filenameFallback .= '_';
                } else {
                    $filenameFallback .= $char;
                }
            }
        }

        $dispositionHeader = $this->headers->makeDisposition($disposition, $filename, $filenameFallback);
        $this->headers->set('Content-Disposition', $dispositionHeader);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function prepare(Request $request)
    {
<<<<<<< HEAD
        $this->headers->set('Content-Length', $this->file->getSize());

        if (!$this->headers->has('Accept-Ranges')) {
            // Only accept ranges on safe HTTP methods
            $this->headers->set('Accept-Ranges', $request->isMethodSafe() ? 'bytes' : 'none');
        }

=======
>>>>>>> v2-test
        if (!$this->headers->has('Content-Type')) {
            $this->headers->set('Content-Type', $this->file->getMimeType() ?: 'application/octet-stream');
        }

        if ('HTTP/1.0' !== $request->server->get('SERVER_PROTOCOL')) {
            $this->setProtocolVersion('1.1');
        }

        $this->ensureIEOverSSLCompatibility($request);

        $this->offset = 0;
        $this->maxlen = -1;

<<<<<<< HEAD
=======
        if (false === $fileSize = $this->file->getSize()) {
            return $this;
        }
        $this->headers->set('Content-Length', $fileSize);

        if (!$this->headers->has('Accept-Ranges')) {
            // Only accept ranges on safe HTTP methods
            $this->headers->set('Accept-Ranges', $request->isMethodSafe() ? 'bytes' : 'none');
        }

>>>>>>> v2-test
        if (self::$trustXSendfileTypeHeader && $request->headers->has('X-Sendfile-Type')) {
            // Use X-Sendfile, do not send any content.
            $type = $request->headers->get('X-Sendfile-Type');
            $path = $this->file->getRealPath();
            // Fall back to scheme://path for stream wrapped locations.
            if (false === $path) {
                $path = $this->file->getPathname();
            }
<<<<<<< HEAD
            if (strtolower($type) === 'x-accel-redirect') {
                // Do X-Accel-Mapping substitutions.
                // @link http://wiki.nginx.org/X-accel#X-Accel-Redirect
                foreach (explode(',', $request->headers->get('X-Accel-Mapping', '')) as $mapping) {
                    $mapping = explode('=', $mapping, 2);

                    if (2 === count($mapping)) {
                        $pathPrefix = trim($mapping[0]);
                        $location = trim($mapping[1]);

                        if (substr($path, 0, strlen($pathPrefix)) === $pathPrefix) {
                            $path = $location.substr($path, strlen($pathPrefix));
                            break;
                        }
                    }
                }
            }
            $this->headers->set($type, $path);
            $this->maxlen = 0;
        } elseif ($request->headers->has('Range')) {
            // Process the range headers.
            if (!$request->headers->has('If-Range') || $this->hasValidIfRangeHeader($request->headers->get('If-Range'))) {
                $range = $request->headers->get('Range');
                $fileSize = $this->file->getSize();

                list($start, $end) = explode('-', substr($range, 6), 2) + array(0);

                $end = ('' === $end) ? $fileSize - 1 : (int) $end;

                if ('' === $start) {
                    $start = $fileSize - $end;
                    $end = $fileSize - 1;
                } else {
                    $start = (int) $start;
                }

                if ($start <= $end) {
                    if ($start < 0 || $end > $fileSize - 1) {
                        $this->setStatusCode(416);
                        $this->headers->set('Content-Range', sprintf('bytes */%s', $fileSize));
                    } elseif ($start !== 0 || $end !== $fileSize - 1) {
                        $this->maxlen = $end < $fileSize ? $end - $start + 1 : -1;
                        $this->offset = $start;

                        $this->setStatusCode(206);
                        $this->headers->set('Content-Range', sprintf('bytes %s-%s/%s', $start, $end, $fileSize));
                        $this->headers->set('Content-Length', $end - $start + 1);
=======
            if ('x-accel-redirect' === strtolower($type)) {
                // Do X-Accel-Mapping substitutions.
                // @link https://www.nginx.com/resources/wiki/start/topics/examples/x-accel/#x-accel-redirect
                $parts = HeaderUtils::split($request->headers->get('X-Accel-Mapping', ''), ',=');
                foreach ($parts as $part) {
                    [$pathPrefix, $location] = $part;
                    if (substr($path, 0, \strlen($pathPrefix)) === $pathPrefix) {
                        $path = $location.substr($path, \strlen($pathPrefix));
                        // Only set X-Accel-Redirect header if a valid URI can be produced
                        // as nginx does not serve arbitrary file paths.
                        $this->headers->set($type, $path);
                        $this->maxlen = 0;
                        break;
                    }
                }
            } else {
                $this->headers->set($type, $path);
                $this->maxlen = 0;
            }
        } elseif ($request->headers->has('Range') && $request->isMethod('GET')) {
            // Process the range headers.
            if (!$request->headers->has('If-Range') || $this->hasValidIfRangeHeader($request->headers->get('If-Range'))) {
                $range = $request->headers->get('Range');

                if (0 === strpos($range, 'bytes=')) {
                    [$start, $end] = explode('-', substr($range, 6), 2) + [0];

                    $end = ('' === $end) ? $fileSize - 1 : (int) $end;

                    if ('' === $start) {
                        $start = $fileSize - $end;
                        $end = $fileSize - 1;
                    } else {
                        $start = (int) $start;
                    }

                    if ($start <= $end) {
                        $end = min($end, $fileSize - 1);
                        if ($start < 0 || $start > $end) {
                            $this->setStatusCode(416);
                            $this->headers->set('Content-Range', sprintf('bytes */%s', $fileSize));
                        } elseif ($end - $start < $fileSize - 1) {
                            $this->maxlen = $end < $fileSize ? $end - $start + 1 : -1;
                            $this->offset = $start;

                            $this->setStatusCode(206);
                            $this->headers->set('Content-Range', sprintf('bytes %s-%s/%s', $start, $end, $fileSize));
                            $this->headers->set('Content-Length', $end - $start + 1);
                        }
>>>>>>> v2-test
                    }
                }
            }
        }

        return $this;
    }

<<<<<<< HEAD
    private function hasValidIfRangeHeader($header)
=======
    private function hasValidIfRangeHeader(?string $header): bool
>>>>>>> v2-test
    {
        if ($this->getEtag() === $header) {
            return true;
        }

        if (null === $lastModified = $this->getLastModified()) {
            return false;
        }

        return $lastModified->format('D, d M Y H:i:s').' GMT' === $header;
    }

    /**
     * Sends the file.
     *
     * {@inheritdoc}
     */
    public function sendContent()
    {
        if (!$this->isSuccessful()) {
            return parent::sendContent();
        }

        if (0 === $this->maxlen) {
            return $this;
        }

<<<<<<< HEAD
        $out = fopen('php://output', 'wb');
        $file = fopen($this->file->getPathname(), 'rb');
=======
        $out = fopen('php://output', 'w');
        $file = fopen($this->file->getPathname(), 'r');
>>>>>>> v2-test

        stream_copy_to_stream($file, $out, $this->maxlen, $this->offset);

        fclose($out);
        fclose($file);

<<<<<<< HEAD
        if ($this->deleteFileAfterSend) {
=======
        if ($this->deleteFileAfterSend && is_file($this->file->getPathname())) {
>>>>>>> v2-test
            unlink($this->file->getPathname());
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \LogicException when the content is not null
     */
<<<<<<< HEAD
    public function setContent($content)
=======
    public function setContent(?string $content)
>>>>>>> v2-test
    {
        if (null !== $content) {
            throw new \LogicException('The content cannot be set on a BinaryFileResponse instance.');
        }
<<<<<<< HEAD
=======

        return $this;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
<<<<<<< HEAD
     *
     * @return false
=======
>>>>>>> v2-test
     */
    public function getContent()
    {
        return false;
    }

    /**
     * Trust X-Sendfile-Type header.
     */
    public static function trustXSendfileTypeHeader()
    {
        self::$trustXSendfileTypeHeader = true;
    }

    /**
<<<<<<< HEAD
     * If this is set to true, the file will be unlinked after the request is send
     * Note: If the X-Sendfile header is used, the deleteFileAfterSend setting will not be used.
     *
     * @param bool $shouldDelete
     *
     * @return BinaryFileResponse
     */
    public function deleteFileAfterSend($shouldDelete)
=======
     * If this is set to true, the file will be unlinked after the request is sent
     * Note: If the X-Sendfile header is used, the deleteFileAfterSend setting will not be used.
     *
     * @return $this
     */
    public function deleteFileAfterSend(bool $shouldDelete = true)
>>>>>>> v2-test
    {
        $this->deleteFileAfterSend = $shouldDelete;

        return $this;
    }
}
