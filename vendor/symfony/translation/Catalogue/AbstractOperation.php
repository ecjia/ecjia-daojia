<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Catalogue;

<<<<<<< HEAD
=======
use Symfony\Component\Translation\Exception\InvalidArgumentException;
use Symfony\Component\Translation\Exception\LogicException;
>>>>>>> v2-test
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\MessageCatalogueInterface;

/**
 * Base catalogues binary operation class.
 *
<<<<<<< HEAD
=======
 * A catalogue binary operation performs operation on
 * source (the left argument) and target (the right argument) catalogues.
 *
>>>>>>> v2-test
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
abstract class AbstractOperation implements OperationInterface
{
<<<<<<< HEAD
    /**
     * @var MessageCatalogueInterface
     */
    protected $source;

    /**
     * @var MessageCatalogueInterface
     */
    protected $target;

    /**
     * @var MessageCatalogue
     */
    protected $result;

    /**
     * @var null|array
=======
    protected $source;
    protected $target;
    protected $result;

    /**
     * @var array|null The domains affected by this operation
>>>>>>> v2-test
     */
    private $domains;

    /**
<<<<<<< HEAD
     * @var array
=======
     * This array stores 'all', 'new' and 'obsolete' messages for all valid domains.
     *
     * The data structure of this array is as follows:
     *
     *     [
     *         'domain 1' => [
     *             'all' => [...],
     *             'new' => [...],
     *             'obsolete' => [...]
     *         ],
     *         'domain 2' => [
     *             'all' => [...],
     *             'new' => [...],
     *             'obsolete' => [...]
     *         ],
     *         ...
     *     ]
     *
     * @var array The array that stores 'all', 'new' and 'obsolete' messages
>>>>>>> v2-test
     */
    protected $messages;

    /**
<<<<<<< HEAD
     * @param MessageCatalogueInterface $source
     * @param MessageCatalogueInterface $target
     *
     * @throws \LogicException
=======
     * @throws LogicException
>>>>>>> v2-test
     */
    public function __construct(MessageCatalogueInterface $source, MessageCatalogueInterface $target)
    {
        if ($source->getLocale() !== $target->getLocale()) {
<<<<<<< HEAD
            throw new \LogicException('Operated catalogues must belong to the same locale.');
=======
            throw new LogicException('Operated catalogues must belong to the same locale.');
>>>>>>> v2-test
        }

        $this->source = $source;
        $this->target = $target;
        $this->result = new MessageCatalogue($source->getLocale());
<<<<<<< HEAD
        $this->domains = null;
        $this->messages = array();
=======
        $this->messages = [];
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function getDomains()
    {
        if (null === $this->domains) {
            $this->domains = array_values(array_unique(array_merge($this->source->getDomains(), $this->target->getDomains())));
        }

        return $this->domains;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getMessages($domain)
    {
        if (!in_array($domain, $this->getDomains())) {
            throw new \InvalidArgumentException(sprintf('Invalid domain: %s.', $domain));
=======
    public function getMessages(string $domain)
    {
        if (!\in_array($domain, $this->getDomains())) {
            throw new InvalidArgumentException(sprintf('Invalid domain: "%s".', $domain));
>>>>>>> v2-test
        }

        if (!isset($this->messages[$domain]['all'])) {
            $this->processDomain($domain);
        }

        return $this->messages[$domain]['all'];
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getNewMessages($domain)
    {
        if (!in_array($domain, $this->getDomains())) {
            throw new \InvalidArgumentException(sprintf('Invalid domain: %s.', $domain));
=======
    public function getNewMessages(string $domain)
    {
        if (!\in_array($domain, $this->getDomains())) {
            throw new InvalidArgumentException(sprintf('Invalid domain: "%s".', $domain));
>>>>>>> v2-test
        }

        if (!isset($this->messages[$domain]['new'])) {
            $this->processDomain($domain);
        }

        return $this->messages[$domain]['new'];
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getObsoleteMessages($domain)
    {
        if (!in_array($domain, $this->getDomains())) {
            throw new \InvalidArgumentException(sprintf('Invalid domain: %s.', $domain));
=======
    public function getObsoleteMessages(string $domain)
    {
        if (!\in_array($domain, $this->getDomains())) {
            throw new InvalidArgumentException(sprintf('Invalid domain: "%s".', $domain));
>>>>>>> v2-test
        }

        if (!isset($this->messages[$domain]['obsolete'])) {
            $this->processDomain($domain);
        }

        return $this->messages[$domain]['obsolete'];
    }

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        foreach ($this->getDomains() as $domain) {
            if (!isset($this->messages[$domain])) {
                $this->processDomain($domain);
            }
        }

        return $this->result;
    }

    /**
<<<<<<< HEAD
     * @param string $domain
     */
    abstract protected function processDomain($domain);
=======
     * Performs operation on source and target catalogues for the given domain and
     * stores the results.
     *
     * @param string $domain The domain which the operation will be performed for
     */
    abstract protected function processDomain(string $domain);
>>>>>>> v2-test
}
