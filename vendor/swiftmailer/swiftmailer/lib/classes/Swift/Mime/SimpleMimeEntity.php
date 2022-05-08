<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A MIME entity, in a multipart message.
 *
 * @author Chris Corbyn
 */
<<<<<<< HEAD
class Swift_Mime_SimpleMimeEntity implements Swift_Mime_MimeEntity
{
    /** A collection of Headers for this mime entity */
    private $_headers;

    /** The body as a string, or a stream */
    private $_body;

    /** The encoder that encodes the body into a streamable format */
    private $_encoder;

    /** The grammar to use for id validation */
    private $_grammar;

    /** A mime boundary, if any is used */
    private $_boundary;

    /** Mime types to be used based on the nesting level */
    private $_compositeRanges = array(
        'multipart/mixed' => array(self::LEVEL_TOP, self::LEVEL_MIXED),
        'multipart/alternative' => array(self::LEVEL_MIXED, self::LEVEL_ALTERNATIVE),
        'multipart/related' => array(self::LEVEL_ALTERNATIVE, self::LEVEL_RELATED),
    );

    /** A set of filter rules to define what level an entity should be nested at */
    private $_compoundLevelFilters = array();

    /** The nesting level of this entity */
    private $_nestingLevel = self::LEVEL_ALTERNATIVE;

    /** A KeyCache instance used during encoding and streaming */
    private $_cache;

    /** Direct descendants of this entity */
    private $_immediateChildren = array();

    /** All descendants of this entity */
    private $_children = array();

    /** The maximum line length of the body of this entity */
    private $_maxLineLength = 78;

    /** The order in which alternative mime types should appear */
    private $_alternativePartOrder = array(
        'text/plain' => 1,
        'text/html' => 2,
        'multipart/related' => 3,
    );

    /** The CID of this entity */
    private $_id;

    /** The key used for accessing the cache */
    private $_cacheKey;

    protected $_userContentType;

    /**
     * Create a new SimpleMimeEntity with $headers, $encoder and $cache.
     *
     * @param Swift_Mime_HeaderSet      $headers
     * @param Swift_Mime_ContentEncoder $encoder
     * @param Swift_KeyCache            $cache
     * @param Swift_Mime_Grammar        $grammar
     */
    public function __construct(Swift_Mime_HeaderSet $headers, Swift_Mime_ContentEncoder $encoder, Swift_KeyCache $cache, Swift_Mime_Grammar $grammar)
    {
        $this->_cacheKey = md5(uniqid(getmypid().mt_rand(), true));
        $this->_cache = $cache;
        $this->_headers = $headers;
        $this->_grammar = $grammar;
        $this->setEncoder($encoder);
        $this->_headers->defineOrdering(array('Content-Type', 'Content-Transfer-Encoding'));
=======
class Swift_Mime_SimpleMimeEntity implements Swift_Mime_CharsetObserver, Swift_Mime_EncodingObserver
{
    /** Main message document; there can only be one of these */
    const LEVEL_TOP = 16;

    /** An entity which nests with the same precedence as an attachment */
    const LEVEL_MIXED = 256;

    /** An entity which nests with the same precedence as a mime part */
    const LEVEL_ALTERNATIVE = 4096;

    /** An entity which nests with the same precedence as embedded content */
    const LEVEL_RELATED = 65536;

    /** A collection of Headers for this mime entity */
    private $headers;

    /** The body as a string, or a stream */
    private $body;

    /** The encoder that encodes the body into a streamable format */
    private $encoder;

    /** Message ID generator */
    private $idGenerator;

    /** A mime boundary, if any is used */
    private $boundary;

    /** Mime types to be used based on the nesting level */
    private $compositeRanges = [
        'multipart/mixed' => [self::LEVEL_TOP, self::LEVEL_MIXED],
        'multipart/alternative' => [self::LEVEL_MIXED, self::LEVEL_ALTERNATIVE],
        'multipart/related' => [self::LEVEL_ALTERNATIVE, self::LEVEL_RELATED],
    ];

    /** A set of filter rules to define what level an entity should be nested at */
    private $compoundLevelFilters = [];

    /** The nesting level of this entity */
    private $nestingLevel = self::LEVEL_ALTERNATIVE;

    /** A KeyCache instance used during encoding and streaming */
    private $cache;

    /** Direct descendants of this entity */
    private $immediateChildren = [];

    /** All descendants of this entity */
    private $children = [];

    /** The maximum line length of the body of this entity */
    private $maxLineLength = 78;

    /** The order in which alternative mime types should appear */
    private $alternativePartOrder = [
        'text/plain' => 1,
        'text/html' => 2,
        'multipart/related' => 3,
    ];

    /** The CID of this entity */
    private $id;

    /** The key used for accessing the cache */
    private $cacheKey;

    protected $userContentType;

    /**
     * Create a new SimpleMimeEntity with $headers, $encoder and $cache.
     */
    public function __construct(Swift_Mime_SimpleHeaderSet $headers, Swift_Mime_ContentEncoder $encoder, Swift_KeyCache $cache, Swift_IdGenerator $idGenerator)
    {
        $this->cacheKey = bin2hex(random_bytes(16)); // set 32 hex values
        $this->cache = $cache;
        $this->headers = $headers;
        $this->idGenerator = $idGenerator;
        $this->setEncoder($encoder);
        $this->headers->defineOrdering(['Content-Type', 'Content-Transfer-Encoding']);
>>>>>>> v2-test

        // This array specifies that, when the entire MIME document contains
        // $compoundLevel, then for each child within $level, if its Content-Type
        // is $contentType then it should be treated as if it's level is
        // $neededLevel instead.  I tried to write that unambiguously! :-\
        // Data Structure:
        // array (
        //   $compoundLevel => array(
        //     $level => array(
        //       $contentType => $neededLevel
        //     )
        //   )
        // )

<<<<<<< HEAD
        $this->_compoundLevelFilters = array(
            (self::LEVEL_ALTERNATIVE + self::LEVEL_RELATED) => array(
                self::LEVEL_ALTERNATIVE => array(
                    'text/plain' => self::LEVEL_ALTERNATIVE,
                    'text/html' => self::LEVEL_RELATED,
                    ),
                ),
            );

        $this->_id = $this->getRandomId();
=======
        $this->compoundLevelFilters = [
            (self::LEVEL_ALTERNATIVE + self::LEVEL_RELATED) => [
                self::LEVEL_ALTERNATIVE => [
                    'text/plain' => self::LEVEL_ALTERNATIVE,
                    'text/html' => self::LEVEL_RELATED,
                    ],
                ],
            ];

        $this->id = $this->idGenerator->generateId();
>>>>>>> v2-test
    }

    /**
     * Generate a new Content-ID or Message-ID for this MIME entity.
     *
     * @return string
     */
    public function generateId()
    {
<<<<<<< HEAD
        $this->setId($this->getRandomId());

        return $this->_id;
    }

    /**
     * Get the {@link Swift_Mime_HeaderSet} for this entity.
     *
     * @return Swift_Mime_HeaderSet
     */
    public function getHeaders()
    {
        return $this->_headers;
=======
        $this->setId($this->idGenerator->generateId());

        return $this->id;
    }

    /**
     * Get the {@link Swift_Mime_SimpleHeaderSet} for this entity.
     *
     * @return Swift_Mime_SimpleHeaderSet
     */
    public function getHeaders()
    {
        return $this->headers;
>>>>>>> v2-test
    }

    /**
     * Get the nesting level of this entity.
     *
     * @see LEVEL_TOP, LEVEL_MIXED, LEVEL_RELATED, LEVEL_ALTERNATIVE
     *
     * @return int
     */
    public function getNestingLevel()
    {
<<<<<<< HEAD
        return $this->_nestingLevel;
=======
        return $this->nestingLevel;
>>>>>>> v2-test
    }

    /**
     * Get the Content-type of this entity.
     *
     * @return string
     */
    public function getContentType()
    {
<<<<<<< HEAD
        return $this->_getHeaderFieldModel('Content-Type');
=======
        return $this->getHeaderFieldModel('Content-Type');
    }

    /**
     * Get the Body Content-type of this entity.
     *
     * @return string
     */
    public function getBodyContentType()
    {
        return $this->userContentType;
>>>>>>> v2-test
    }

    /**
     * Set the Content-type of this entity.
     *
     * @param string $type
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMimeEntity
     */
    public function setContentType($type)
    {
        $this->_setContentTypeInHeaders($type);
        // Keep track of the value so that if the content-type changes automatically
        // due to added child entities, it can be restored if they are later removed
        $this->_userContentType = $type;
=======
     * @return $this
     */
    public function setContentType($type)
    {
        $this->setContentTypeInHeaders($type);
        // Keep track of the value so that if the content-type changes automatically
        // due to added child entities, it can be restored if they are later removed
        $this->userContentType = $type;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Get the CID of this entity.
     *
     * The CID will only be present in headers if a Content-ID header is present.
     *
     * @return string
     */
    public function getId()
    {
<<<<<<< HEAD
        $tmp = (array) $this->_getHeaderFieldModel($this->_getIdField());

        return $this->_headers->has($this->_getIdField()) ? current($tmp) : $this->_id;
=======
        $tmp = (array) $this->getHeaderFieldModel($this->getIdField());

        return $this->headers->has($this->getIdField()) ? current($tmp) : $this->id;
>>>>>>> v2-test
    }

    /**
     * Set the CID of this entity.
     *
     * @param string $id
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMimeEntity
     */
    public function setId($id)
    {
        if (!$this->_setHeaderFieldModel($this->_getIdField(), $id)) {
            $this->_headers->addIdHeader($this->_getIdField(), $id);
        }
        $this->_id = $id;
=======
     * @return $this
     */
    public function setId($id)
    {
        if (!$this->setHeaderFieldModel($this->getIdField(), $id)) {
            $this->headers->addIdHeader($this->getIdField(), $id);
        }
        $this->id = $id;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Get the description of this entity.
     *
     * This value comes from the Content-Description header if set.
     *
     * @return string
     */
    public function getDescription()
    {
<<<<<<< HEAD
        return $this->_getHeaderFieldModel('Content-Description');
=======
        return $this->getHeaderFieldModel('Content-Description');
>>>>>>> v2-test
    }

    /**
     * Set the description of this entity.
     *
     * This method sets a value in the Content-ID header.
     *
     * @param string $description
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMimeEntity
     */
    public function setDescription($description)
    {
        if (!$this->_setHeaderFieldModel('Content-Description', $description)) {
            $this->_headers->addTextHeader('Content-Description', $description);
=======
     * @return $this
     */
    public function setDescription($description)
    {
        if (!$this->setHeaderFieldModel('Content-Description', $description)) {
            $this->headers->addTextHeader('Content-Description', $description);
>>>>>>> v2-test
        }

        return $this;
    }

    /**
     * Get the maximum line length of the body of this entity.
     *
     * @return int
     */
    public function getMaxLineLength()
    {
<<<<<<< HEAD
        return $this->_maxLineLength;
=======
        return $this->maxLineLength;
>>>>>>> v2-test
    }

    /**
     * Set the maximum line length of lines in this body.
     *
     * Though not enforced by the library, lines should not exceed 1000 chars.
     *
     * @param int $length
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMimeEntity
     */
    public function setMaxLineLength($length)
    {
        $this->_maxLineLength = $length;
=======
     * @return $this
     */
    public function setMaxLineLength($length)
    {
        $this->maxLineLength = $length;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Get all children added to this entity.
     *
<<<<<<< HEAD
     * @return Swift_Mime_MimeEntity[]
     */
    public function getChildren()
    {
        return $this->_children;
=======
     * @return Swift_Mime_SimpleMimeEntity[]
     */
    public function getChildren()
    {
        return $this->children;
>>>>>>> v2-test
    }

    /**
     * Set all children of this entity.
     *
<<<<<<< HEAD
     * @param Swift_Mime_MimeEntity[] $children
     * @param int                     $compoundLevel For internal use only
     *
     * @return Swift_Mime_SimpleMimeEntity
=======
     * @param Swift_Mime_SimpleMimeEntity[] $children
     * @param int                           $compoundLevel For internal use only
     *
     * @return $this
>>>>>>> v2-test
     */
    public function setChildren(array $children, $compoundLevel = null)
    {
        // TODO: Try to refactor this logic
<<<<<<< HEAD

        $compoundLevel = isset($compoundLevel) ? $compoundLevel : $this->_getCompoundLevel($children);
        $immediateChildren = array();
        $grandchildren = array();
        $newContentType = $this->_userContentType;

        foreach ($children as $child) {
            $level = $this->_getNeededChildLevel($child, $compoundLevel);
            if (empty($immediateChildren)) {
                //first iteration
                $immediateChildren = array($child);
            } else {
                $nextLevel = $this->_getNeededChildLevel($immediateChildren[0], $compoundLevel);
=======
        $compoundLevel = $compoundLevel ?? $this->getCompoundLevel($children);
        $immediateChildren = [];
        $grandchildren = [];
        $newContentType = $this->userContentType;

        foreach ($children as $child) {
            $level = $this->getNeededChildLevel($child, $compoundLevel);
            if (empty($immediateChildren)) {
                //first iteration
                $immediateChildren = [$child];
            } else {
                $nextLevel = $this->getNeededChildLevel($immediateChildren[0], $compoundLevel);
>>>>>>> v2-test
                if ($nextLevel == $level) {
                    $immediateChildren[] = $child;
                } elseif ($level < $nextLevel) {
                    // Re-assign immediateChildren to grandchildren
                    $grandchildren = array_merge($grandchildren, $immediateChildren);
                    // Set new children
<<<<<<< HEAD
                    $immediateChildren = array($child);
=======
                    $immediateChildren = [$child];
>>>>>>> v2-test
                } else {
                    $grandchildren[] = $child;
                }
            }
        }

        if ($immediateChildren) {
<<<<<<< HEAD
            $lowestLevel = $this->_getNeededChildLevel($immediateChildren[0], $compoundLevel);

            // Determine which composite media type is needed to accommodate the
            // immediate children
            foreach ($this->_compositeRanges as $mediaType => $range) {
=======
            $lowestLevel = $this->getNeededChildLevel($immediateChildren[0], $compoundLevel);

            // Determine which composite media type is needed to accommodate the
            // immediate children
            foreach ($this->compositeRanges as $mediaType => $range) {
>>>>>>> v2-test
                if ($lowestLevel > $range[0] && $lowestLevel <= $range[1]) {
                    $newContentType = $mediaType;

                    break;
                }
            }

            // Put any grandchildren in a subpart
            if (!empty($grandchildren)) {
<<<<<<< HEAD
                $subentity = $this->_createChild();
                $subentity->_setNestingLevel($lowestLevel);
=======
                $subentity = $this->createChild();
                $subentity->setNestingLevel($lowestLevel);
>>>>>>> v2-test
                $subentity->setChildren($grandchildren, $compoundLevel);
                array_unshift($immediateChildren, $subentity);
            }
        }

<<<<<<< HEAD
        $this->_immediateChildren = $immediateChildren;
        $this->_children = $children;
        $this->_setContentTypeInHeaders($newContentType);
        $this->_fixHeaders();
        $this->_sortChildren();
=======
        $this->immediateChildren = $immediateChildren;
        $this->children = $children;
        $this->setContentTypeInHeaders($newContentType);
        $this->fixHeaders();
        $this->sortChildren();
>>>>>>> v2-test

        return $this;
    }

    /**
     * Get the body of this entity as a string.
     *
     * @return string
     */
    public function getBody()
    {
<<<<<<< HEAD
        return $this->_body instanceof Swift_OutputByteStream ? $this->_readStream($this->_body) : $this->_body;
=======
        return $this->body instanceof Swift_OutputByteStream ? $this->readStream($this->body) : $this->body;
>>>>>>> v2-test
    }

    /**
     * Set the body of this entity, either as a string, or as an instance of
     * {@link Swift_OutputByteStream}.
     *
     * @param mixed  $body
     * @param string $contentType optional
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMimeEntity
     */
    public function setBody($body, $contentType = null)
    {
        if ($body !== $this->_body) {
            $this->_clearCache();
        }

        $this->_body = $body;
        if (isset($contentType)) {
=======
     * @return $this
     */
    public function setBody($body, $contentType = null)
    {
        if ($body !== $this->body) {
            $this->clearCache();
        }

        $this->body = $body;
        if (null !== $contentType) {
>>>>>>> v2-test
            $this->setContentType($contentType);
        }

        return $this;
    }

    /**
     * Get the encoder used for the body of this entity.
     *
     * @return Swift_Mime_ContentEncoder
     */
    public function getEncoder()
    {
<<<<<<< HEAD
        return $this->_encoder;
=======
        return $this->encoder;
>>>>>>> v2-test
    }

    /**
     * Set the encoder used for the body of this entity.
     *
<<<<<<< HEAD
     * @param Swift_Mime_ContentEncoder $encoder
     *
     * @return Swift_Mime_SimpleMimeEntity
     */
    public function setEncoder(Swift_Mime_ContentEncoder $encoder)
    {
        if ($encoder !== $this->_encoder) {
            $this->_clearCache();
        }

        $this->_encoder = $encoder;
        $this->_setEncoding($encoder->getName());
        $this->_notifyEncoderChanged($encoder);
=======
     * @return $this
     */
    public function setEncoder(Swift_Mime_ContentEncoder $encoder)
    {
        if ($encoder !== $this->encoder) {
            $this->clearCache();
        }

        $this->encoder = $encoder;
        $this->setEncoding($encoder->getName());
        $this->notifyEncoderChanged($encoder);
>>>>>>> v2-test

        return $this;
    }

    /**
     * Get the boundary used to separate children in this entity.
     *
     * @return string
     */
    public function getBoundary()
    {
<<<<<<< HEAD
        if (!isset($this->_boundary)) {
            $this->_boundary = '_=_swift_v4_'.time().'_'.md5(getmypid().mt_rand().uniqid('', true)).'_=_';
        }

        return $this->_boundary;
=======
        if (!isset($this->boundary)) {
            $this->boundary = '_=_swift_'.time().'_'.bin2hex(random_bytes(16)).'_=_';
        }

        return $this->boundary;
>>>>>>> v2-test
    }

    /**
     * Set the boundary used to separate children in this entity.
     *
     * @param string $boundary
     *
     * @throws Swift_RfcComplianceException
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMimeEntity
     */
    public function setBoundary($boundary)
    {
        $this->_assertValidBoundary($boundary);
        $this->_boundary = $boundary;
=======
     * @return $this
     */
    public function setBoundary($boundary)
    {
        $this->assertValidBoundary($boundary);
        $this->boundary = $boundary;
>>>>>>> v2-test

        return $this;
    }

    /**
     * Receive notification that the charset of this entity, or a parent entity
     * has changed.
     *
     * @param string $charset
     */
    public function charsetChanged($charset)
    {
<<<<<<< HEAD
        $this->_notifyCharsetChanged($charset);
=======
        $this->notifyCharsetChanged($charset);
>>>>>>> v2-test
    }

    /**
     * Receive notification that the encoder of this entity or a parent entity
     * has changed.
<<<<<<< HEAD
     *
     * @param Swift_Mime_ContentEncoder $encoder
     */
    public function encoderChanged(Swift_Mime_ContentEncoder $encoder)
    {
        $this->_notifyEncoderChanged($encoder);
=======
     */
    public function encoderChanged(Swift_Mime_ContentEncoder $encoder)
    {
        $this->notifyEncoderChanged($encoder);
>>>>>>> v2-test
    }

    /**
     * Get this entire entity as a string.
     *
     * @return string
     */
    public function toString()
    {
<<<<<<< HEAD
        $string = $this->_headers->toString();
        $string .= $this->_bodyToString();
=======
        $string = $this->headers->toString();
        $string .= $this->bodyToString();
>>>>>>> v2-test

        return $string;
    }

    /**
     * Get this entire entity as a string.
     *
     * @return string
     */
<<<<<<< HEAD
    protected function _bodyToString()
    {
        $string = '';

        if (isset($this->_body) && empty($this->_immediateChildren)) {
            if ($this->_cache->hasKey($this->_cacheKey, 'body')) {
                $body = $this->_cache->getString($this->_cacheKey, 'body');
            } else {
                $body = "\r\n".$this->_encoder->encodeString($this->getBody(), 0, $this->getMaxLineLength());
                $this->_cache->setString($this->_cacheKey, 'body', $body, Swift_KeyCache::MODE_WRITE);
=======
    protected function bodyToString()
    {
        $string = '';

        if (isset($this->body) && empty($this->immediateChildren)) {
            if ($this->cache->hasKey($this->cacheKey, 'body')) {
                $body = $this->cache->getString($this->cacheKey, 'body');
            } else {
                $body = "\r\n".$this->encoder->encodeString($this->getBody(), 0, $this->getMaxLineLength());
                $this->cache->setString($this->cacheKey, 'body', $body, Swift_KeyCache::MODE_WRITE);
>>>>>>> v2-test
            }
            $string .= $body;
        }

<<<<<<< HEAD
        if (!empty($this->_immediateChildren)) {
            foreach ($this->_immediateChildren as $child) {
=======
        if (!empty($this->immediateChildren)) {
            foreach ($this->immediateChildren as $child) {
>>>>>>> v2-test
                $string .= "\r\n\r\n--".$this->getBoundary()."\r\n";
                $string .= $child->toString();
            }
            $string .= "\r\n\r\n--".$this->getBoundary()."--\r\n";
        }

        return $string;
    }

    /**
     * Returns a string representation of this object.
     *
     * @see toString()
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Write this entire entity to a {@see Swift_InputByteStream}.
<<<<<<< HEAD
     *
     * @param Swift_InputByteStream
     */
    public function toByteStream(Swift_InputByteStream $is)
    {
        $is->write($this->_headers->toString());
        $is->commit();

        $this->_bodyToByteStream($is);
=======
     */
    public function toByteStream(Swift_InputByteStream $is)
    {
        $is->write($this->headers->toString());
        $is->commit();

        $this->bodyToByteStream($is);
>>>>>>> v2-test
    }

    /**
     * Write this entire entity to a {@link Swift_InputByteStream}.
<<<<<<< HEAD
     *
     * @param Swift_InputByteStream
     */
    protected function _bodyToByteStream(Swift_InputByteStream $is)
    {
        if (empty($this->_immediateChildren)) {
            if (isset($this->_body)) {
                if ($this->_cache->hasKey($this->_cacheKey, 'body')) {
                    $this->_cache->exportToByteStream($this->_cacheKey, 'body', $is);
                } else {
                    $cacheIs = $this->_cache->getInputByteStream($this->_cacheKey, 'body');
=======
     */
    protected function bodyToByteStream(Swift_InputByteStream $is)
    {
        if (empty($this->immediateChildren)) {
            if (isset($this->body)) {
                if ($this->cache->hasKey($this->cacheKey, 'body')) {
                    $this->cache->exportToByteStream($this->cacheKey, 'body', $is);
                } else {
                    $cacheIs = $this->cache->getInputByteStream($this->cacheKey, 'body');
>>>>>>> v2-test
                    if ($cacheIs) {
                        $is->bind($cacheIs);
                    }

                    $is->write("\r\n");

<<<<<<< HEAD
                    if ($this->_body instanceof Swift_OutputByteStream) {
                        $this->_body->setReadPointer(0);

                        $this->_encoder->encodeByteStream($this->_body, $is, 0, $this->getMaxLineLength());
                    } else {
                        $is->write($this->_encoder->encodeString($this->getBody(), 0, $this->getMaxLineLength()));
=======
                    if ($this->body instanceof Swift_OutputByteStream) {
                        $this->body->setReadPointer(0);

                        $this->encoder->encodeByteStream($this->body, $is, 0, $this->getMaxLineLength());
                    } else {
                        $is->write($this->encoder->encodeString($this->getBody(), 0, $this->getMaxLineLength()));
>>>>>>> v2-test
                    }

                    if ($cacheIs) {
                        $is->unbind($cacheIs);
                    }
                }
            }
        }

<<<<<<< HEAD
        if (!empty($this->_immediateChildren)) {
            foreach ($this->_immediateChildren as $child) {
=======
        if (!empty($this->immediateChildren)) {
            foreach ($this->immediateChildren as $child) {
>>>>>>> v2-test
                $is->write("\r\n\r\n--".$this->getBoundary()."\r\n");
                $child->toByteStream($is);
            }
            $is->write("\r\n\r\n--".$this->getBoundary()."--\r\n");
        }
    }

    /**
     * Get the name of the header that provides the ID of this entity.
     */
<<<<<<< HEAD
    protected function _getIdField()
=======
    protected function getIdField()
>>>>>>> v2-test
    {
        return 'Content-ID';
    }

    /**
     * Get the model data (usually an array or a string) for $field.
     */
<<<<<<< HEAD
    protected function _getHeaderFieldModel($field)
    {
        if ($this->_headers->has($field)) {
            return $this->_headers->get($field)->getFieldBodyModel();
=======
    protected function getHeaderFieldModel($field)
    {
        if ($this->headers->has($field)) {
            return $this->headers->get($field)->getFieldBodyModel();
>>>>>>> v2-test
        }
    }

    /**
     * Set the model data for $field.
     */
<<<<<<< HEAD
    protected function _setHeaderFieldModel($field, $model)
    {
        if ($this->_headers->has($field)) {
            $this->_headers->get($field)->setFieldBodyModel($model);
=======
    protected function setHeaderFieldModel($field, $model)
    {
        if ($this->headers->has($field)) {
            $this->headers->get($field)->setFieldBodyModel($model);
>>>>>>> v2-test

            return true;
        }

        return false;
    }

    /**
     * Get the parameter value of $parameter on $field header.
     */
<<<<<<< HEAD
    protected function _getHeaderParameter($field, $parameter)
    {
        if ($this->_headers->has($field)) {
            return $this->_headers->get($field)->getParameter($parameter);
=======
    protected function getHeaderParameter($field, $parameter)
    {
        if ($this->headers->has($field)) {
            return $this->headers->get($field)->getParameter($parameter);
>>>>>>> v2-test
        }
    }

    /**
     * Set the parameter value of $parameter on $field header.
     */
<<<<<<< HEAD
    protected function _setHeaderParameter($field, $parameter, $value)
    {
        if ($this->_headers->has($field)) {
            $this->_headers->get($field)->setParameter($parameter, $value);
=======
    protected function setHeaderParameter($field, $parameter, $value)
    {
        if ($this->headers->has($field)) {
            $this->headers->get($field)->setParameter($parameter, $value);
>>>>>>> v2-test

            return true;
        }

        return false;
    }

    /**
     * Re-evaluate what content type and encoding should be used on this entity.
     */
<<<<<<< HEAD
    protected function _fixHeaders()
    {
        if (count($this->_immediateChildren)) {
            $this->_setHeaderParameter('Content-Type', 'boundary',
                $this->getBoundary()
                );
            $this->_headers->remove('Content-Transfer-Encoding');
        } else {
            $this->_setHeaderParameter('Content-Type', 'boundary', null);
            $this->_setEncoding($this->_encoder->getName());
=======
    protected function fixHeaders()
    {
        if (\count($this->immediateChildren)) {
            $this->setHeaderParameter('Content-Type', 'boundary',
                $this->getBoundary()
                );
            $this->headers->remove('Content-Transfer-Encoding');
        } else {
            $this->setHeaderParameter('Content-Type', 'boundary', null);
            $this->setEncoding($this->encoder->getName());
>>>>>>> v2-test
        }
    }

    /**
     * Get the KeyCache used in this entity.
     *
     * @return Swift_KeyCache
     */
<<<<<<< HEAD
    protected function _getCache()
    {
        return $this->_cache;
    }

    /**
     * Get the grammar used for validation.
     *
     * @return Swift_Mime_Grammar
     */
    protected function _getGrammar()
    {
        return $this->_grammar;
=======
    protected function getCache()
    {
        return $this->cache;
    }

    /**
     * Get the ID generator.
     *
     * @return Swift_IdGenerator
     */
    protected function getIdGenerator()
    {
        return $this->idGenerator;
>>>>>>> v2-test
    }

    /**
     * Empty the KeyCache for this entity.
     */
<<<<<<< HEAD
    protected function _clearCache()
    {
        $this->_cache->clearKey($this->_cacheKey, 'body');
    }

    /**
     * Returns a random Content-ID or Message-ID.
     *
     * @return string
     */
    protected function getRandomId()
    {
        $idLeft = md5(getmypid().'.'.time().'.'.uniqid(mt_rand(), true));
        $idRight = !empty($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'swift.generated';
        $id = $idLeft.'@'.$idRight;

        try {
            $this->_assertValidId($id);
        } catch (Swift_RfcComplianceException $e) {
            $id = $idLeft.'@swift.generated';
        }

        return $id;
    }

    private function _readStream(Swift_OutputByteStream $os)
=======
    protected function clearCache()
    {
        $this->cache->clearKey($this->cacheKey, 'body');
    }

    private function readStream(Swift_OutputByteStream $os)
>>>>>>> v2-test
    {
        $string = '';
        while (false !== $bytes = $os->read(8192)) {
            $string .= $bytes;
        }

        $os->setReadPointer(0);

        return $string;
    }

<<<<<<< HEAD
    private function _setEncoding($encoding)
    {
        if (!$this->_setHeaderFieldModel('Content-Transfer-Encoding', $encoding)) {
            $this->_headers->addTextHeader('Content-Transfer-Encoding', $encoding);
        }
    }

    private function _assertValidBoundary($boundary)
=======
    private function setEncoding($encoding)
    {
        if (!$this->setHeaderFieldModel('Content-Transfer-Encoding', $encoding)) {
            $this->headers->addTextHeader('Content-Transfer-Encoding', $encoding);
        }
    }

    private function assertValidBoundary($boundary)
>>>>>>> v2-test
    {
        if (!preg_match('/^[a-z0-9\'\(\)\+_\-,\.\/:=\?\ ]{0,69}[a-z0-9\'\(\)\+_\-,\.\/:=\?]$/Di', $boundary)) {
            throw new Swift_RfcComplianceException('Mime boundary set is not RFC 2046 compliant.');
        }
    }

<<<<<<< HEAD
    private function _setContentTypeInHeaders($type)
    {
        if (!$this->_setHeaderFieldModel('Content-Type', $type)) {
            $this->_headers->addParameterizedHeader('Content-Type', $type);
        }
    }

    private function _setNestingLevel($level)
    {
        $this->_nestingLevel = $level;
    }

    private function _getCompoundLevel($children)
=======
    private function setContentTypeInHeaders($type)
    {
        if (!$this->setHeaderFieldModel('Content-Type', $type)) {
            $this->headers->addParameterizedHeader('Content-Type', $type);
        }
    }

    private function setNestingLevel($level)
    {
        $this->nestingLevel = $level;
    }

    private function getCompoundLevel($children)
>>>>>>> v2-test
    {
        $level = 0;
        foreach ($children as $child) {
            $level |= $child->getNestingLevel();
        }

        return $level;
    }

<<<<<<< HEAD
    private function _getNeededChildLevel($child, $compoundLevel)
    {
        $filter = array();
        foreach ($this->_compoundLevelFilters as $bitmask => $rules) {
=======
    private function getNeededChildLevel($child, $compoundLevel)
    {
        $filter = [];
        foreach ($this->compoundLevelFilters as $bitmask => $rules) {
>>>>>>> v2-test
            if (($compoundLevel & $bitmask) === $bitmask) {
                $filter = $rules + $filter;
            }
        }

        $realLevel = $child->getNestingLevel();
        $lowercaseType = strtolower($child->getContentType());

        if (isset($filter[$realLevel]) && isset($filter[$realLevel][$lowercaseType])) {
            return $filter[$realLevel][$lowercaseType];
        }

        return $realLevel;
    }

<<<<<<< HEAD
    private function _createChild()
    {
        return new self($this->_headers->newInstance(), $this->_encoder, $this->_cache, $this->_grammar);
    }

    private function _notifyEncoderChanged(Swift_Mime_ContentEncoder $encoder)
    {
        foreach ($this->_immediateChildren as $child) {
=======
    private function createChild()
    {
        return new self($this->headers->newInstance(), $this->encoder, $this->cache, $this->idGenerator);
    }

    private function notifyEncoderChanged(Swift_Mime_ContentEncoder $encoder)
    {
        foreach ($this->immediateChildren as $child) {
>>>>>>> v2-test
            $child->encoderChanged($encoder);
        }
    }

<<<<<<< HEAD
    private function _notifyCharsetChanged($charset)
    {
        $this->_encoder->charsetChanged($charset);
        $this->_headers->charsetChanged($charset);
        foreach ($this->_immediateChildren as $child) {
=======
    private function notifyCharsetChanged($charset)
    {
        $this->encoder->charsetChanged($charset);
        $this->headers->charsetChanged($charset);
        foreach ($this->immediateChildren as $child) {
>>>>>>> v2-test
            $child->charsetChanged($charset);
        }
    }

<<<<<<< HEAD
    private function _sortChildren()
    {
        $shouldSort = false;
        foreach ($this->_immediateChildren as $child) {
            // NOTE: This include alternative parts moved into a related part
            if ($child->getNestingLevel() == self::LEVEL_ALTERNATIVE) {
=======
    private function sortChildren()
    {
        $shouldSort = false;
        foreach ($this->immediateChildren as $child) {
            // NOTE: This include alternative parts moved into a related part
            if (self::LEVEL_ALTERNATIVE == $child->getNestingLevel()) {
>>>>>>> v2-test
                $shouldSort = true;
                break;
            }
        }

        // Sort in order of preference, if there is one
        if ($shouldSort) {
<<<<<<< HEAD
            usort($this->_immediateChildren, array($this, '_childSortAlgorithm'));
        }
    }

    private function _childSortAlgorithm($a, $b)
    {
        $typePrefs = array();
        $types = array(strtolower($a->getContentType()), strtolower($b->getContentType()));

        foreach ($types as $type) {
            $typePrefs[] = array_key_exists($type, $this->_alternativePartOrder) ? $this->_alternativePartOrder[$type] : max($this->_alternativePartOrder) + 1;
        }

        return $typePrefs[0] >= $typePrefs[1] ? 1 : -1;
    }

    // -- Destructor

=======
            // Group the messages by order of preference
            $sorted = [];
            foreach ($this->immediateChildren as $child) {
                $type = $child->getContentType();
                $level = \array_key_exists($type, $this->alternativePartOrder) ? $this->alternativePartOrder[$type] : max($this->alternativePartOrder) + 1;

                if (empty($sorted[$level])) {
                    $sorted[$level] = [];
                }

                $sorted[$level][] = $child;
            }

            ksort($sorted);

            $this->immediateChildren = array_reduce($sorted, 'array_merge', []);
        }
    }

>>>>>>> v2-test
    /**
     * Empties it's own contents from the cache.
     */
    public function __destruct()
    {
<<<<<<< HEAD
        $this->_cache->clearAll($this->_cacheKey);
    }

    /**
     * Throws an Exception if the id passed does not comply with RFC 2822.
     *
     * @param string $id
     *
     * @throws Swift_RfcComplianceException
     */
    private function _assertValidId($id)
    {
        if (!preg_match('/^'.$this->_grammar->getDefinition('id-left').'@'.$this->_grammar->getDefinition('id-right').'$/D', $id)) {
            throw new Swift_RfcComplianceException('Invalid ID given <'.$id.'>');
=======
        if ($this->cache instanceof Swift_KeyCache) {
            $this->cache->clearAll($this->cacheKey);
>>>>>>> v2-test
        }
    }

    /**
     * Make a deep copy of object.
     */
    public function __clone()
    {
<<<<<<< HEAD
        $this->_headers = clone $this->_headers;
        $this->_encoder = clone $this->_encoder;
        $this->_cacheKey = md5(uniqid(getmypid().mt_rand(), true));
        $children = array();
        foreach ($this->_children as $pos => $child) {
=======
        $this->headers = clone $this->headers;
        $this->encoder = clone $this->encoder;
        $this->cacheKey = bin2hex(random_bytes(16)); // set 32 hex values
        $children = [];
        foreach ($this->children as $pos => $child) {
>>>>>>> v2-test
            $children[$pos] = clone $child;
        }
        $this->setChildren($children);
    }
<<<<<<< HEAD
=======

    public function __wakeup()
    {
        $this->cacheKey = bin2hex(random_bytes(16)); // set 32 hex values
        $this->cache = new Swift_KeyCache_ArrayKeyCache(new Swift_KeyCache_SimpleKeyCacheInputStream());
    }
>>>>>>> v2-test
}
