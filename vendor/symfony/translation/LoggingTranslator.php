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

use Psr\Log\LoggerInterface;
<<<<<<< HEAD
=======
use Symfony\Component\Translation\Exception\InvalidArgumentException;
use Symfony\Contracts\Translation\LocaleAwareInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
>>>>>>> v2-test

/**
 * @author Abdellatif Ait boudad <a.aitboudad@gmail.com>
 */
<<<<<<< HEAD
class LoggingTranslator implements TranslatorInterface, TranslatorBagInterface
=======
class LoggingTranslator implements TranslatorInterface, TranslatorBagInterface, LocaleAwareInterface
>>>>>>> v2-test
{
    /**
     * @var TranslatorInterface|TranslatorBagInterface
     */
    private $translator;

<<<<<<< HEAD
    /**
     * @var LoggerInterface
     */
=======
>>>>>>> v2-test
    private $logger;

    /**
     * @param TranslatorInterface $translator The translator must implement TranslatorBagInterface
<<<<<<< HEAD
     * @param LoggerInterface     $logger
     */
    public function __construct(TranslatorInterface $translator, LoggerInterface $logger)
    {
        if (!$translator instanceof TranslatorBagInterface) {
            throw new \InvalidArgumentException(sprintf('The Translator "%s" must implement TranslatorInterface and TranslatorBagInterface.', get_class($translator)));
=======
     */
    public function __construct(TranslatorInterface $translator, LoggerInterface $logger)
    {
        if (!$translator instanceof TranslatorBagInterface || !$translator instanceof LocaleAwareInterface) {
            throw new InvalidArgumentException(sprintf('The Translator "%s" must implement TranslatorInterface, TranslatorBagInterface and LocaleAwareInterface.', get_debug_type($translator)));
>>>>>>> v2-test
        }

        $this->translator = $translator;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function trans($id, array $parameters = array(), $domain = null, $locale = null)
    {
        $trans = $this->translator->trans($id, $parameters, $domain, $locale);
=======
    public function trans(?string $id, array $parameters = [], string $domain = null, string $locale = null)
    {
        $trans = $this->translator->trans($id = (string) $id, $parameters, $domain, $locale);
>>>>>>> v2-test
        $this->log($id, $domain, $locale);

        return $trans;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function transChoice($id, $number, array $parameters = array(), $domain = null, $locale = null)
    {
        $trans = $this->translator->transChoice($id, $number, $parameters, $domain, $locale);
        $this->log($id, $domain, $locale);

        return $trans;
=======
    public function setLocale(string $locale)
    {
        $prev = $this->translator->getLocale();
        $this->translator->setLocale($locale);
        if ($prev === $locale) {
            return;
        }

        $this->logger->debug(sprintf('The locale of the translator has changed from "%s" to "%s".', $prev, $locale));
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function setLocale($locale)
    {
        $this->translator->setLocale($locale);
=======
    public function getLocale()
    {
        return $this->translator->getLocale();
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getLocale()
    {
        return $this->translator->getLocale();
    }

    /**
     * {@inheritdoc}
     */
    public function getCatalogue($locale = null)
    {
        return $this->translator->getCatalogue($locale);
=======
    public function getCatalogue(string $locale = null)
    {
        return $this->translator->getCatalogue($locale);
    }

    /**
     * Gets the fallback locales.
     *
     * @return array The fallback locales
     */
    public function getFallbackLocales()
    {
        if ($this->translator instanceof Translator || method_exists($this->translator, 'getFallbackLocales')) {
            return $this->translator->getFallbackLocales();
        }

        return [];
>>>>>>> v2-test
    }

    /**
     * Passes through all unknown calls onto the translator object.
     */
<<<<<<< HEAD
    public function __call($method, $args)
    {
        return call_user_func_array(array($this->translator, $method), $args);
=======
    public function __call(string $method, array $args)
    {
        return $this->translator->{$method}(...$args);
>>>>>>> v2-test
    }

    /**
     * Logs for missing translations.
<<<<<<< HEAD
     *
     * @param string      $id
     * @param string|null $domain
     * @param string|null $locale
     */
    private function log($id, $domain, $locale)
=======
     */
    private function log(string $id, ?string $domain, ?string $locale)
>>>>>>> v2-test
    {
        if (null === $domain) {
            $domain = 'messages';
        }

<<<<<<< HEAD
        $id = (string) $id;
=======
>>>>>>> v2-test
        $catalogue = $this->translator->getCatalogue($locale);
        if ($catalogue->defines($id, $domain)) {
            return;
        }

        if ($catalogue->has($id, $domain)) {
<<<<<<< HEAD
            $this->logger->debug('Translation use fallback catalogue.', array('id' => $id, 'domain' => $domain, 'locale' => $catalogue->getLocale()));
        } else {
            $this->logger->warning('Translation not found.', array('id' => $id, 'domain' => $domain, 'locale' => $catalogue->getLocale()));
=======
            $this->logger->debug('Translation use fallback catalogue.', ['id' => $id, 'domain' => $domain, 'locale' => $catalogue->getLocale()]);
        } else {
            $this->logger->warning('Translation not found.', ['id' => $id, 'domain' => $domain, 'locale' => $catalogue->getLocale()]);
>>>>>>> v2-test
        }
    }
}
