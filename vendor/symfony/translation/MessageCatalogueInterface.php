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

/**
 * MessageCatalogueInterface.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface MessageCatalogueInterface
{
<<<<<<< HEAD
=======
    public const INTL_DOMAIN_SUFFIX = '+intl-icu';

>>>>>>> v2-test
    /**
     * Gets the catalogue locale.
     *
     * @return string The locale
     */
    public function getLocale();

    /**
     * Gets the domains.
     *
     * @return array An array of domains
     */
    public function getDomains();

    /**
     * Gets the messages within a given domain.
     *
     * If $domain is null, it returns all messages.
     *
     * @param string $domain The domain name
     *
     * @return array An array of messages
     */
<<<<<<< HEAD
    public function all($domain = null);
=======
    public function all(string $domain = null);
>>>>>>> v2-test

    /**
     * Sets a message translation.
     *
     * @param string $id          The message id
     * @param string $translation The messages translation
     * @param string $domain      The domain name
     */
<<<<<<< HEAD
    public function set($id, $translation, $domain = 'messages');
=======
    public function set(string $id, string $translation, string $domain = 'messages');
>>>>>>> v2-test

    /**
     * Checks if a message has a translation.
     *
     * @param string $id     The message id
     * @param string $domain The domain name
     *
     * @return bool true if the message has a translation, false otherwise
     */
<<<<<<< HEAD
    public function has($id, $domain = 'messages');
=======
    public function has(string $id, string $domain = 'messages');
>>>>>>> v2-test

    /**
     * Checks if a message has a translation (it does not take into account the fallback mechanism).
     *
     * @param string $id     The message id
     * @param string $domain The domain name
     *
     * @return bool true if the message has a translation, false otherwise
     */
<<<<<<< HEAD
    public function defines($id, $domain = 'messages');
=======
    public function defines(string $id, string $domain = 'messages');
>>>>>>> v2-test

    /**
     * Gets a message translation.
     *
     * @param string $id     The message id
     * @param string $domain The domain name
     *
     * @return string The message translation
     */
<<<<<<< HEAD
    public function get($id, $domain = 'messages');
=======
    public function get(string $id, string $domain = 'messages');
>>>>>>> v2-test

    /**
     * Sets translations for a given domain.
     *
     * @param array  $messages An array of translations
     * @param string $domain   The domain name
     */
<<<<<<< HEAD
    public function replace($messages, $domain = 'messages');
=======
    public function replace(array $messages, string $domain = 'messages');
>>>>>>> v2-test

    /**
     * Adds translations for a given domain.
     *
     * @param array  $messages An array of translations
     * @param string $domain   The domain name
     */
<<<<<<< HEAD
    public function add($messages, $domain = 'messages');
=======
    public function add(array $messages, string $domain = 'messages');
>>>>>>> v2-test

    /**
     * Merges translations from the given Catalogue into the current one.
     *
     * The two catalogues must have the same locale.
<<<<<<< HEAD
     *
     * @param MessageCatalogueInterface $catalogue A MessageCatalogueInterface instance
     */
    public function addCatalogue(MessageCatalogueInterface $catalogue);
=======
     */
    public function addCatalogue(self $catalogue);
>>>>>>> v2-test

    /**
     * Merges translations from the given Catalogue into the current one
     * only when the translation does not exist.
     *
     * This is used to provide default translations when they do not exist for the current locale.
<<<<<<< HEAD
     *
     * @param MessageCatalogueInterface $catalogue A MessageCatalogueInterface instance
     */
    public function addFallbackCatalogue(MessageCatalogueInterface $catalogue);
=======
     */
    public function addFallbackCatalogue(self $catalogue);
>>>>>>> v2-test

    /**
     * Gets the fallback catalogue.
     *
<<<<<<< HEAD
     * @return MessageCatalogueInterface|null A MessageCatalogueInterface instance or null when no fallback has been set
=======
     * @return self|null A MessageCatalogueInterface instance or null when no fallback has been set
>>>>>>> v2-test
     */
    public function getFallbackCatalogue();

    /**
     * Returns an array of resources loaded to build this collection.
     *
     * @return ResourceInterface[] An array of resources
     */
    public function getResources();

    /**
     * Adds a resource for this collection.
<<<<<<< HEAD
     *
     * @param ResourceInterface $resource A resource instance
=======
>>>>>>> v2-test
     */
    public function addResource(ResourceInterface $resource);
}
