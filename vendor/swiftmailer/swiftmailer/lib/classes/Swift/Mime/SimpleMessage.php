<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The default email message class.
 *
 * @author Chris Corbyn
 */
<<<<<<< HEAD
class Swift_Mime_SimpleMessage extends Swift_Mime_MimePart implements Swift_Mime_Message
{
    /**
     * Create a new SimpleMessage with $headers, $encoder and $cache.
     *
     * @param Swift_Mime_HeaderSet      $headers
     * @param Swift_Mime_ContentEncoder $encoder
     * @param Swift_KeyCache            $cache
     * @param Swift_Mime_Grammar        $grammar
     * @param string                    $charset
     */
    public function __construct(Swift_Mime_HeaderSet $headers, Swift_Mime_ContentEncoder $encoder, Swift_KeyCache $cache, Swift_Mime_Grammar $grammar, $charset = null)
    {
        parent::__construct($headers, $encoder, $cache, $grammar, $charset);
        $this->getHeaders()->defineOrdering(array(
=======
class Swift_Mime_SimpleMessage extends Swift_Mime_MimePart
{
    const PRIORITY_HIGHEST = 1;
    const PRIORITY_HIGH = 2;
    const PRIORITY_NORMAL = 3;
    const PRIORITY_LOW = 4;
    const PRIORITY_LOWEST = 5;

    /**
     * Create a new SimpleMessage with $headers, $encoder and $cache.
     *
     * @param string $charset
     */
    public function __construct(Swift_Mime_SimpleHeaderSet $headers, Swift_Mime_ContentEncoder $encoder, Swift_KeyCache $cache, Swift_IdGenerator $idGenerator, $charset = null)
    {
        parent::__construct($headers, $encoder, $cache, $idGenerator, $charset);
        $this->getHeaders()->defineOrdering([
>>>>>>> v2-test
            'Return-Path',
            'Received',
            'DKIM-Signature',
            'DomainKey-Signature',
            'Sender',
            'Message-ID',
            'Date',
            'Subject',
            'From',
            'Reply-To',
            'To',
            'Cc',
            'Bcc',
            'MIME-Version',
            'Content-Type',
            'Content-Transfer-Encoding',
<<<<<<< HEAD
            ));
        $this->getHeaders()->setAlwaysDisplayed(array('Date', 'Message-ID', 'From'));
        $this->getHeaders()->addTextHeader('MIME-Version', '1.0');
        $this->setDate(time());
=======
            ]);
        $this->getHeaders()->setAlwaysDisplayed(['Date', 'Message-ID', 'From']);
        $this->getHeaders()->addTextHeader('MIME-Version', '1.0');
        $this->setDate(new DateTimeImmutable());
>>>>>>> v2-test
        $this->setId($this->getId());
        $this->getHeaders()->addMailboxHeader('From');
    }

    /**
     * Always returns {@link LEVEL_TOP} for a message instance.
     *
     * @return int
     */
    public function getNestingLevel()
    {
        return self::LEVEL_TOP;
    }

    /**
     * Set the subject of this message.
     *
     * @param string $subject
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMessage
     */
    public function setSubject($subject)
    {
        if (!$this->_setHeaderFieldModel('Subject', $subject)) {
=======
     * @return $this
     */
    public function setSubject($subject)
    {
        if (!$this->setHeaderFieldModel('Subject', $subject)) {
>>>>>>> v2-test
            $this->getHeaders()->addTextHeader('Subject', $subject);
        }

        return $this;
    }

    /**
     * Get the subject of this message.
     *
     * @return string
     */
    public function getSubject()
    {
<<<<<<< HEAD
        return $this->_getHeaderFieldModel('Subject');
=======
        return $this->getHeaderFieldModel('Subject');
>>>>>>> v2-test
    }

    /**
     * Set the date at which this message was created.
     *
<<<<<<< HEAD
     * @param int $date
     *
     * @return Swift_Mime_SimpleMessage
     */
    public function setDate($date)
    {
        if (!$this->_setHeaderFieldModel('Date', $date)) {
            $this->getHeaders()->addDateHeader('Date', $date);
=======
     * @return $this
     */
    public function setDate(DateTimeInterface $dateTime)
    {
        if (!$this->setHeaderFieldModel('Date', $dateTime)) {
            $this->getHeaders()->addDateHeader('Date', $dateTime);
>>>>>>> v2-test
        }

        return $this;
    }

    /**
     * Get the date at which this message was created.
     *
<<<<<<< HEAD
     * @return int
     */
    public function getDate()
    {
        return $this->_getHeaderFieldModel('Date');
=======
     * @return DateTimeInterface
     */
    public function getDate()
    {
        return $this->getHeaderFieldModel('Date');
>>>>>>> v2-test
    }

    /**
     * Set the return-path (the bounce address) of this message.
     *
     * @param string $address
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMessage
     */
    public function setReturnPath($address)
    {
        if (!$this->_setHeaderFieldModel('Return-Path', $address)) {
=======
     * @return $this
     */
    public function setReturnPath($address)
    {
        if (!$this->setHeaderFieldModel('Return-Path', $address)) {
>>>>>>> v2-test
            $this->getHeaders()->addPathHeader('Return-Path', $address);
        }

        return $this;
    }

    /**
     * Get the return-path (bounce address) of this message.
     *
     * @return string
     */
    public function getReturnPath()
    {
<<<<<<< HEAD
        return $this->_getHeaderFieldModel('Return-Path');
=======
        return $this->getHeaderFieldModel('Return-Path');
>>>>>>> v2-test
    }

    /**
     * Set the sender of this message.
     *
     * This does not override the From field, but it has a higher significance.
     *
     * @param string $address
     * @param string $name    optional
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMessage
     */
    public function setSender($address, $name = null)
    {
        if (!is_array($address) && isset($name)) {
            $address = array($address => $name);
        }

        if (!$this->_setHeaderFieldModel('Sender', (array) $address)) {
=======
     * @return $this
     */
    public function setSender($address, $name = null)
    {
        if (!\is_array($address) && isset($name)) {
            $address = [$address => $name];
        }

        if (!$this->setHeaderFieldModel('Sender', (array) $address)) {
>>>>>>> v2-test
            $this->getHeaders()->addMailboxHeader('Sender', (array) $address);
        }

        return $this;
    }

    /**
     * Get the sender of this message.
     *
     * @return string
     */
    public function getSender()
    {
<<<<<<< HEAD
        return $this->_getHeaderFieldModel('Sender');
=======
        return $this->getHeaderFieldModel('Sender');
>>>>>>> v2-test
    }

    /**
     * Add a From: address to this message.
     *
     * If $name is passed this name will be associated with the address.
     *
     * @param string $address
     * @param string $name    optional
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMessage
=======
     * @return $this
>>>>>>> v2-test
     */
    public function addFrom($address, $name = null)
    {
        $current = $this->getFrom();
        $current[$address] = $name;

        return $this->setFrom($current);
    }

    /**
     * Set the from address of this message.
     *
     * You may pass an array of addresses if this message is from multiple people.
     *
     * If $name is passed and the first parameter is a string, this name will be
     * associated with the address.
     *
     * @param string|array $addresses
     * @param string       $name      optional
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMessage
     */
    public function setFrom($addresses, $name = null)
    {
        if (!is_array($addresses) && isset($name)) {
            $addresses = array($addresses => $name);
        }

        if (!$this->_setHeaderFieldModel('From', (array) $addresses)) {
=======
     * @return $this
     */
    public function setFrom($addresses, $name = null)
    {
        if (!\is_array($addresses) && isset($name)) {
            $addresses = [$addresses => $name];
        }

        if (!$this->setHeaderFieldModel('From', (array) $addresses)) {
>>>>>>> v2-test
            $this->getHeaders()->addMailboxHeader('From', (array) $addresses);
        }

        return $this;
    }

    /**
     * Get the from address of this message.
     *
     * @return mixed
     */
    public function getFrom()
    {
<<<<<<< HEAD
        return $this->_getHeaderFieldModel('From');
=======
        return $this->getHeaderFieldModel('From');
>>>>>>> v2-test
    }

    /**
     * Add a Reply-To: address to this message.
     *
     * If $name is passed this name will be associated with the address.
     *
     * @param string $address
     * @param string $name    optional
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMessage
=======
     * @return $this
>>>>>>> v2-test
     */
    public function addReplyTo($address, $name = null)
    {
        $current = $this->getReplyTo();
        $current[$address] = $name;

        return $this->setReplyTo($current);
    }

    /**
     * Set the reply-to address of this message.
     *
     * You may pass an array of addresses if replies will go to multiple people.
     *
     * If $name is passed and the first parameter is a string, this name will be
     * associated with the address.
     *
     * @param mixed  $addresses
     * @param string $name      optional
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMessage
     */
    public function setReplyTo($addresses, $name = null)
    {
        if (!is_array($addresses) && isset($name)) {
            $addresses = array($addresses => $name);
        }

        if (!$this->_setHeaderFieldModel('Reply-To', (array) $addresses)) {
=======
     * @return $this
     */
    public function setReplyTo($addresses, $name = null)
    {
        if (!\is_array($addresses) && isset($name)) {
            $addresses = [$addresses => $name];
        }

        if (!$this->setHeaderFieldModel('Reply-To', (array) $addresses)) {
>>>>>>> v2-test
            $this->getHeaders()->addMailboxHeader('Reply-To', (array) $addresses);
        }

        return $this;
    }

    /**
     * Get the reply-to address of this message.
     *
     * @return string
     */
    public function getReplyTo()
    {
<<<<<<< HEAD
        return $this->_getHeaderFieldModel('Reply-To');
=======
        return $this->getHeaderFieldModel('Reply-To');
>>>>>>> v2-test
    }

    /**
     * Add a To: address to this message.
     *
     * If $name is passed this name will be associated with the address.
     *
     * @param string $address
     * @param string $name    optional
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMessage
=======
     * @return $this
>>>>>>> v2-test
     */
    public function addTo($address, $name = null)
    {
        $current = $this->getTo();
        $current[$address] = $name;

        return $this->setTo($current);
    }

    /**
     * Set the to addresses of this message.
     *
     * If multiple recipients will receive the message an array should be used.
     * Example: array('receiver@domain.org', 'other@domain.org' => 'A name')
     *
     * If $name is passed and the first parameter is a string, this name will be
     * associated with the address.
     *
     * @param mixed  $addresses
     * @param string $name      optional
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMessage
     */
    public function setTo($addresses, $name = null)
    {
        if (!is_array($addresses) && isset($name)) {
            $addresses = array($addresses => $name);
        }

        if (!$this->_setHeaderFieldModel('To', (array) $addresses)) {
=======
     * @return $this
     */
    public function setTo($addresses, $name = null)
    {
        if (!\is_array($addresses) && isset($name)) {
            $addresses = [$addresses => $name];
        }

        if (!$this->setHeaderFieldModel('To', (array) $addresses)) {
>>>>>>> v2-test
            $this->getHeaders()->addMailboxHeader('To', (array) $addresses);
        }

        return $this;
    }

    /**
     * Get the To addresses of this message.
     *
     * @return array
     */
    public function getTo()
    {
<<<<<<< HEAD
        return $this->_getHeaderFieldModel('To');
=======
        return $this->getHeaderFieldModel('To');
>>>>>>> v2-test
    }

    /**
     * Add a Cc: address to this message.
     *
     * If $name is passed this name will be associated with the address.
     *
     * @param string $address
     * @param string $name    optional
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMessage
=======
     * @return $this
>>>>>>> v2-test
     */
    public function addCc($address, $name = null)
    {
        $current = $this->getCc();
        $current[$address] = $name;

        return $this->setCc($current);
    }

    /**
     * Set the Cc addresses of this message.
     *
     * If $name is passed and the first parameter is a string, this name will be
     * associated with the address.
     *
     * @param mixed  $addresses
     * @param string $name      optional
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMessage
     */
    public function setCc($addresses, $name = null)
    {
        if (!is_array($addresses) && isset($name)) {
            $addresses = array($addresses => $name);
        }

        if (!$this->_setHeaderFieldModel('Cc', (array) $addresses)) {
=======
     * @return $this
     */
    public function setCc($addresses, $name = null)
    {
        if (!\is_array($addresses) && isset($name)) {
            $addresses = [$addresses => $name];
        }

        if (!$this->setHeaderFieldModel('Cc', (array) $addresses)) {
>>>>>>> v2-test
            $this->getHeaders()->addMailboxHeader('Cc', (array) $addresses);
        }

        return $this;
    }

    /**
     * Get the Cc address of this message.
     *
     * @return array
     */
    public function getCc()
    {
<<<<<<< HEAD
        return $this->_getHeaderFieldModel('Cc');
=======
        return $this->getHeaderFieldModel('Cc');
>>>>>>> v2-test
    }

    /**
     * Add a Bcc: address to this message.
     *
     * If $name is passed this name will be associated with the address.
     *
     * @param string $address
     * @param string $name    optional
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMessage
=======
     * @return $this
>>>>>>> v2-test
     */
    public function addBcc($address, $name = null)
    {
        $current = $this->getBcc();
        $current[$address] = $name;

        return $this->setBcc($current);
    }

    /**
     * Set the Bcc addresses of this message.
     *
     * If $name is passed and the first parameter is a string, this name will be
     * associated with the address.
     *
     * @param mixed  $addresses
     * @param string $name      optional
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMessage
     */
    public function setBcc($addresses, $name = null)
    {
        if (!is_array($addresses) && isset($name)) {
            $addresses = array($addresses => $name);
        }

        if (!$this->_setHeaderFieldModel('Bcc', (array) $addresses)) {
=======
     * @return $this
     */
    public function setBcc($addresses, $name = null)
    {
        if (!\is_array($addresses) && isset($name)) {
            $addresses = [$addresses => $name];
        }

        if (!$this->setHeaderFieldModel('Bcc', (array) $addresses)) {
>>>>>>> v2-test
            $this->getHeaders()->addMailboxHeader('Bcc', (array) $addresses);
        }

        return $this;
    }

    /**
     * Get the Bcc addresses of this message.
     *
     * @return array
     */
    public function getBcc()
    {
<<<<<<< HEAD
        return $this->_getHeaderFieldModel('Bcc');
=======
        return $this->getHeaderFieldModel('Bcc');
>>>>>>> v2-test
    }

    /**
     * Set the priority of this message.
     *
     * The value is an integer where 1 is the highest priority and 5 is the lowest.
     *
     * @param int $priority
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMessage
     */
    public function setPriority($priority)
    {
        $priorityMap = array(
            1 => 'Highest',
            2 => 'High',
            3 => 'Normal',
            4 => 'Low',
            5 => 'Lowest',
            );
=======
     * @return $this
     */
    public function setPriority($priority)
    {
        $priorityMap = [
            self::PRIORITY_HIGHEST => 'Highest',
            self::PRIORITY_HIGH => 'High',
            self::PRIORITY_NORMAL => 'Normal',
            self::PRIORITY_LOW => 'Low',
            self::PRIORITY_LOWEST => 'Lowest',
            ];
>>>>>>> v2-test
        $pMapKeys = array_keys($priorityMap);
        if ($priority > max($pMapKeys)) {
            $priority = max($pMapKeys);
        } elseif ($priority < min($pMapKeys)) {
            $priority = min($pMapKeys);
        }
<<<<<<< HEAD
        if (!$this->_setHeaderFieldModel('X-Priority',
=======
        if (!$this->setHeaderFieldModel('X-Priority',
>>>>>>> v2-test
            sprintf('%d (%s)', $priority, $priorityMap[$priority]))) {
            $this->getHeaders()->addTextHeader('X-Priority',
                sprintf('%d (%s)', $priority, $priorityMap[$priority]));
        }

        return $this;
    }

    /**
     * Get the priority of this message.
     *
     * The returned value is an integer where 1 is the highest priority and 5
     * is the lowest.
     *
     * @return int
     */
    public function getPriority()
    {
<<<<<<< HEAD
        list($priority) = sscanf($this->_getHeaderFieldModel('X-Priority'),
            '%[1-5]'
            );

        return isset($priority) ? $priority : 3;
=======
        list($priority) = sscanf($this->getHeaderFieldModel('X-Priority'),
            '%[1-5]'
            );

        return $priority ?? 3;
>>>>>>> v2-test
    }

    /**
     * Ask for a delivery receipt from the recipient to be sent to $addresses.
     *
     * @param array $addresses
     *
<<<<<<< HEAD
     * @return Swift_Mime_SimpleMessage
     */
    public function setReadReceiptTo($addresses)
    {
        if (!$this->_setHeaderFieldModel('Disposition-Notification-To', $addresses)) {
=======
     * @return $this
     */
    public function setReadReceiptTo($addresses)
    {
        if (!$this->setHeaderFieldModel('Disposition-Notification-To', $addresses)) {
>>>>>>> v2-test
            $this->getHeaders()
                ->addMailboxHeader('Disposition-Notification-To', $addresses);
        }

        return $this;
    }

    /**
     * Get the addresses to which a read-receipt will be sent.
     *
     * @return string
     */
    public function getReadReceiptTo()
    {
<<<<<<< HEAD
        return $this->_getHeaderFieldModel('Disposition-Notification-To');
    }

    /**
     * Attach a {@link Swift_Mime_MimeEntity} such as an Attachment or MimePart.
     *
     * @param Swift_Mime_MimeEntity $entity
     *
     * @return Swift_Mime_SimpleMessage
     */
    public function attach(Swift_Mime_MimeEntity $entity)
    {
        $this->setChildren(array_merge($this->getChildren(), array($entity)));
=======
        return $this->getHeaderFieldModel('Disposition-Notification-To');
    }

    /**
     * Attach a {@link Swift_Mime_SimpleMimeEntity} such as an Attachment or MimePart.
     *
     * @return $this
     */
    public function attach(Swift_Mime_SimpleMimeEntity $entity)
    {
        $this->setChildren(array_merge($this->getChildren(), [$entity]));
>>>>>>> v2-test

        return $this;
    }

    /**
     * Remove an already attached entity.
     *
<<<<<<< HEAD
     * @param Swift_Mime_MimeEntity $entity
     *
     * @return Swift_Mime_SimpleMessage
     */
    public function detach(Swift_Mime_MimeEntity $entity)
    {
        $newChildren = array();
=======
     * @return $this
     */
    public function detach(Swift_Mime_SimpleMimeEntity $entity)
    {
        $newChildren = [];
>>>>>>> v2-test
        foreach ($this->getChildren() as $child) {
            if ($entity !== $child) {
                $newChildren[] = $child;
            }
        }
        $this->setChildren($newChildren);

        return $this;
    }

    /**
<<<<<<< HEAD
     * Attach a {@link Swift_Mime_MimeEntity} and return it's CID source.
     * This method should be used when embedding images or other data in a message.
     *
     * @param Swift_Mime_MimeEntity $entity
     *
     * @return string
     */
    public function embed(Swift_Mime_MimeEntity $entity)
=======
     * Attach a {@link Swift_Mime_SimpleMimeEntity} and return it's CID source.
     *
     * This method should be used when embedding images or other data in a message.
     *
     * @return string
     */
    public function embed(Swift_Mime_SimpleMimeEntity $entity)
>>>>>>> v2-test
    {
        $this->attach($entity);

        return 'cid:'.$entity->getId();
    }

    /**
     * Get this message as a complete string.
     *
     * @return string
     */
    public function toString()
    {
<<<<<<< HEAD
        if (count($children = $this->getChildren()) > 0 && $this->getBody() != '') {
            $this->setChildren(array_merge(array($this->_becomeMimePart()), $children));
=======
        if (\count($children = $this->getChildren()) > 0 && '' != $this->getBody()) {
            $this->setChildren(array_merge([$this->becomeMimePart()], $children));
>>>>>>> v2-test
            $string = parent::toString();
            $this->setChildren($children);
        } else {
            $string = parent::toString();
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
     * Write this message to a {@link Swift_InputByteStream}.
<<<<<<< HEAD
     *
     * @param Swift_InputByteStream $is
     */
    public function toByteStream(Swift_InputByteStream $is)
    {
        if (count($children = $this->getChildren()) > 0 && $this->getBody() != '') {
            $this->setChildren(array_merge(array($this->_becomeMimePart()), $children));
=======
     */
    public function toByteStream(Swift_InputByteStream $is)
    {
        if (\count($children = $this->getChildren()) > 0 && '' != $this->getBody()) {
            $this->setChildren(array_merge([$this->becomeMimePart()], $children));
>>>>>>> v2-test
            parent::toByteStream($is);
            $this->setChildren($children);
        } else {
            parent::toByteStream($is);
        }
    }

<<<<<<< HEAD
    /** @see Swift_Mime_SimpleMimeEntity::_getIdField() */
    protected function _getIdField()
=======
    /** @see Swift_Mime_SimpleMimeEntity::getIdField() */
    protected function getIdField()
>>>>>>> v2-test
    {
        return 'Message-ID';
    }

    /** Turn the body of this message into a child of itself if needed */
<<<<<<< HEAD
    protected function _becomeMimePart()
    {
        $part = new parent($this->getHeaders()->newInstance(), $this->getEncoder(),
            $this->_getCache(), $this->_getGrammar(), $this->_userCharset
            );
        $part->setContentType($this->_userContentType);
        $part->setBody($this->getBody());
        $part->setFormat($this->_userFormat);
        $part->setDelSp($this->_userDelSp);
        $part->_setNestingLevel($this->_getTopNestingLevel());
=======
    protected function becomeMimePart()
    {
        $part = new parent($this->getHeaders()->newInstance(), $this->getEncoder(),
            $this->getCache(), $this->getIdGenerator(), $this->userCharset
            );
        $part->setContentType($this->userContentType);
        $part->setBody($this->getBody());
        $part->setFormat($this->userFormat);
        $part->setDelSp($this->userDelSp);
        $part->setNestingLevel($this->getTopNestingLevel());
>>>>>>> v2-test

        return $part;
    }

    /** Get the highest nesting level nested inside this message */
<<<<<<< HEAD
    private function _getTopNestingLevel()
=======
    private function getTopNestingLevel()
>>>>>>> v2-test
    {
        $highestLevel = $this->getNestingLevel();
        foreach ($this->getChildren() as $child) {
            $childLevel = $child->getNestingLevel();
            if ($highestLevel < $childLevel) {
                $highestLevel = $childLevel;
            }
        }

        return $highestLevel;
    }
}
