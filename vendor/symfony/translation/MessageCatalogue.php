<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation;

use Symfony\Component\Config\Resource\ResourceInterface;
<<<<<<< HEAD

/**
 * MessageCatalogue.
 *
=======
use Symfony\Component\Translation\Exception\LogicException;

/**
>>>>>>> v2-test
 * @author Fabien Potencier <fabien@symfony.com>
 */
class MessageCatalogue implements MessageCatalogueInterface, MetadataAwareInterface
{
<<<<<<< HEAD
    private $messages = array();
    private $metadata = array();
    private $resources = array();
=======
    private $messages = [];
    private $metadata = [];
    private $resources = [];
>>>>>>> v2-test
    private $locale;
    private $fallbackCatalogue;
    private $parent;

    /**
<<<<<<< HEAD
     * Constructor.
     *
     * @param string $locale   The locale
     * @param array  $messages An array of messages classified by domain
     */
    public function __construct($locale, array $messages = array())
=======
     * @param string $locale   The locale
     * @param array  $messages An array of messages classified by domain
     */
    public function __construct(string $locale, array $messages = [])
>>>>>>> v2-test
    {
        $this->locale = $locale;
        $this->messages = $messages;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     */
    public function getDomains()
    {
<<<<<<< HEAD
        return array_keys($this->messages);
=======
        $domains = [];
        $suffixLength = \strlen(self::INTL_DOMAIN_SUFFIX);

        foreach ($this->messages as $domain => $messages) {
            if (\strlen($domain) > $suffixLength && false !== $i = strpos($domain, self::INTL_DOMAIN_SUFFIX, -$suffixLength)) {
                $domain = substr($domain, 0, $i);
            }
            $domains[$domain] = $domain;
        }

        return array_values($domains);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function all($domain = null)
    {
        if (null === $domain) {
            return $this->messages;
        }

        return isset($this->messages[$domain]) ? $this->messages[$domain] : array();
=======
    public function all(string $domain = null)
    {
        if (null !== $domain) {
            // skip messages merge if intl-icu requested explicitly
            if (false !== strpos($domain, self::INTL_DOMAIN_SUFFIX)) {
                return $this->messages[$domain] ?? [];
            }

            return ($this->messages[$domain.self::INTL_DOMAIN_SUFFIX] ?? []) + ($this->messages[$domain] ?? []);
        }

        $allMessages = [];
        $suffixLength = \strlen(self::INTL_DOMAIN_SUFFIX);

        foreach ($this->messages as $domain => $messages) {
            if (\strlen($domain) > $suffixLength && false !== $i = strpos($domain, self::INTL_DOMAIN_SUFFIX, -$suffixLength)) {
                $domain = substr($domain, 0, $i);
                $allMessages[$domain] = $messages + ($allMessages[$domain] ?? []);
            } else {
                $allMessages[$domain] = ($allMessages[$domain] ?? []) + $messages;
            }
        }

        return $allMessages;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function set($id, $translation, $domain = 'messages')
    {
        $this->add(array($id => $translation), $domain);
=======
    public function set(string $id, string $translation, string $domain = 'messages')
    {
        $this->add([$id => $translation], $domain);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function has($id, $domain = 'messages')
    {
        if (isset($this->messages[$domain][$id])) {
=======
    public function has(string $id, string $domain = 'messages')
    {
        if (isset($this->messages[$domain][$id]) || isset($this->messages[$domain.self::INTL_DOMAIN_SUFFIX][$id])) {
>>>>>>> v2-test
            return true;
        }

        if (null !== $this->fallbackCatalogue) {
            return $this->fallbackCatalogue->has($id, $domain);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function defines($id, $domain = 'messages')
    {
        return isset($this->messages[$domain][$id]);
=======
    public function defines(string $id, string $domain = 'messages')
    {
        return isset($this->messages[$domain][$id]) || isset($this->messages[$domain.self::INTL_DOMAIN_SUFFIX][$id]);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function get($id, $domain = 'messages')
    {
=======
    public function get(string $id, string $domain = 'messages')
    {
        if (isset($this->messages[$domain.self::INTL_DOMAIN_SUFFIX][$id])) {
            return $this->messages[$domain.self::INTL_DOMAIN_SUFFIX][$id];
        }

>>>>>>> v2-test
        if (isset($this->messages[$domain][$id])) {
            return $this->messages[$domain][$id];
        }

        if (null !== $this->fallbackCatalogue) {
            return $this->fallbackCatalogue->get($id, $domain);
        }

        return $id;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function replace($messages, $domain = 'messages')
    {
        $this->messages[$domain] = array();
=======
    public function replace(array $messages, string $domain = 'messages')
    {
        unset($this->messages[$domain], $this->messages[$domain.self::INTL_DOMAIN_SUFFIX]);
>>>>>>> v2-test

        $this->add($messages, $domain);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function add($messages, $domain = 'messages')
    {
        if (!isset($this->messages[$domain])) {
            $this->messages[$domain] = $messages;
        } else {
            $this->messages[$domain] = array_replace($this->messages[$domain], $messages);
=======
    public function add(array $messages, string $domain = 'messages')
    {
        if (!isset($this->messages[$domain])) {
            $this->messages[$domain] = [];
        }
        $intlDomain = $domain;
        $suffixLength = \strlen(self::INTL_DOMAIN_SUFFIX);
        if (\strlen($domain) > $suffixLength && false !== strpos($domain, self::INTL_DOMAIN_SUFFIX, -$suffixLength)) {
            $intlDomain .= self::INTL_DOMAIN_SUFFIX;
        }
        foreach ($messages as $id => $message) {
            if (isset($this->messages[$intlDomain]) && \array_key_exists($id, $this->messages[$intlDomain])) {
                $this->messages[$intlDomain][$id] = $message;
            } else {
                $this->messages[$domain][$id] = $message;
            }
>>>>>>> v2-test
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addCatalogue(MessageCatalogueInterface $catalogue)
    {
        if ($catalogue->getLocale() !== $this->locale) {
<<<<<<< HEAD
            throw new \LogicException(sprintf('Cannot add a catalogue for locale "%s" as the current locale for this catalogue is "%s"', $catalogue->getLocale(), $this->locale));
        }

        foreach ($catalogue->all() as $domain => $messages) {
=======
            throw new LogicException(sprintf('Cannot add a catalogue for locale "%s" as the current locale for this catalogue is "%s".', $catalogue->getLocale(), $this->locale));
        }

        foreach ($catalogue->all() as $domain => $messages) {
            if ($intlMessages = $catalogue->all($domain.self::INTL_DOMAIN_SUFFIX)) {
                $this->add($intlMessages, $domain.self::INTL_DOMAIN_SUFFIX);
                $messages = array_diff_key($messages, $intlMessages);
            }
>>>>>>> v2-test
            $this->add($messages, $domain);
        }

        foreach ($catalogue->getResources() as $resource) {
            $this->addResource($resource);
        }

        if ($catalogue instanceof MetadataAwareInterface) {
            $metadata = $catalogue->getMetadata('', '');
            $this->addMetadata($metadata);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addFallbackCatalogue(MessageCatalogueInterface $catalogue)
    {
        // detect circular references
        $c = $catalogue;
        while ($c = $c->getFallbackCatalogue()) {
            if ($c->getLocale() === $this->getLocale()) {
<<<<<<< HEAD
                throw new \LogicException(sprintf('Circular reference detected when adding a fallback catalogue for locale "%s".', $catalogue->getLocale()));
=======
                throw new LogicException(sprintf('Circular reference detected when adding a fallback catalogue for locale "%s".', $catalogue->getLocale()));
>>>>>>> v2-test
            }
        }

        $c = $this;
        do {
            if ($c->getLocale() === $catalogue->getLocale()) {
<<<<<<< HEAD
                throw new \LogicException(sprintf('Circular reference detected when adding a fallback catalogue for locale "%s".', $catalogue->getLocale()));
=======
                throw new LogicException(sprintf('Circular reference detected when adding a fallback catalogue for locale "%s".', $catalogue->getLocale()));
            }

            foreach ($catalogue->getResources() as $resource) {
                $c->addResource($resource);
>>>>>>> v2-test
            }
        } while ($c = $c->parent);

        $catalogue->parent = $this;
        $this->fallbackCatalogue = $catalogue;

        foreach ($catalogue->getResources() as $resource) {
            $this->addResource($resource);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFallbackCatalogue()
    {
        return $this->fallbackCatalogue;
    }

    /**
     * {@inheritdoc}
     */
    public function getResources()
    {
        return array_values($this->resources);
    }

    /**
     * {@inheritdoc}
     */
    public function addResource(ResourceInterface $resource)
    {
        $this->resources[$resource->__toString()] = $resource;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getMetadata($key = '', $domain = 'messages')
=======
    public function getMetadata(string $key = '', string $domain = 'messages')
>>>>>>> v2-test
    {
        if ('' == $domain) {
            return $this->metadata;
        }

        if (isset($this->metadata[$domain])) {
            if ('' == $key) {
                return $this->metadata[$domain];
            }

            if (isset($this->metadata[$domain][$key])) {
                return $this->metadata[$domain][$key];
            }
        }
<<<<<<< HEAD
=======

        return null;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function setMetadata($key, $value, $domain = 'messages')
=======
    public function setMetadata(string $key, $value, string $domain = 'messages')
>>>>>>> v2-test
    {
        $this->metadata[$domain][$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function deleteMetadata($key = '', $domain = 'messages')
    {
        if ('' == $domain) {
            $this->metadata = array();
=======
    public function deleteMetadata(string $key = '', string $domain = 'messages')
    {
        if ('' == $domain) {
            $this->metadata = [];
>>>>>>> v2-test
        } elseif ('' == $key) {
            unset($this->metadata[$domain]);
        } else {
            unset($this->metadata[$domain][$key]);
        }
    }

    /**
     * Adds current values with the new values.
     *
     * @param array $values Values to add
     */
    private function addMetadata(array $values)
    {
        foreach ($values as $domain => $keys) {
            foreach ($keys as $key => $value) {
                $this->setMetadata($key, $value, $domain);
            }
        }
    }
}
