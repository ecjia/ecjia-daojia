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

<<<<<<< HEAD
/**
 * @author Abdellatif Ait boudad <a.aitboudad@gmail.com>
 */
class DataCollectorTranslator implements TranslatorInterface, TranslatorBagInterface
{
    const MESSAGE_DEFINED = 0;
    const MESSAGE_MISSING = 1;
    const MESSAGE_EQUALS_FALLBACK = 2;
=======
use Symfony\Component\HttpKernel\CacheWarmer\WarmableInterface;
use Symfony\Component\Translation\Exception\InvalidArgumentException;
use Symfony\Contracts\Translation\LocaleAwareInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author Abdellatif Ait boudad <a.aitboudad@gmail.com>
 */
class DataCollectorTranslator implements TranslatorInterface, TranslatorBagInterface, LocaleAwareInterface, WarmableInterface
{
    public const MESSAGE_DEFINED = 0;
    public const MESSAGE_MISSING = 1;
    public const MESSAGE_EQUALS_FALLBACK = 2;
>>>>>>> v2-test

    /**
     * @var TranslatorInterface|TranslatorBagInterface
     */
    private $translator;

<<<<<<< HEAD
    /**
     * @var array
     */
    private $messages = array();
=======
    private $messages = [];
>>>>>>> v2-test

    /**
     * @param TranslatorInterface $translator The translator must implement TranslatorBagInterface
     */
    public function __construct(TranslatorInterface $translator)
    {
<<<<<<< HEAD
        if (!$translator instanceof TranslatorBagInterface) {
            throw new \InvalidArgumentException(sprintf('The Translator "%s" must implement TranslatorInterface and TranslatorBagInterface.', get_class($translator)));
=======
        if (!$translator instanceof TranslatorBagInterface || !$translator instanceof LocaleAwareInterface) {
            throw new InvalidArgumentException(sprintf('The Translator "%s" must implement TranslatorInterface, TranslatorBagInterface and LocaleAwareInterface.', get_debug_type($translator)));
>>>>>>> v2-test
        }

        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function trans($id, array $parameters = array(), $domain = null, $locale = null)
    {
        $trans = $this->translator->trans($id, $parameters, $domain, $locale);
        $this->collectMessage($locale, $domain, $id, $trans);
=======
    public function trans(?string $id, array $parameters = [], string $domain = null, string $locale = null)
    {
        $trans = $this->translator->trans($id = (string) $id, $parameters, $domain, $locale);
        $this->collectMessage($locale, $domain, $id, $trans, $parameters);
>>>>>>> v2-test

        return $trans;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function transChoice($id, $number, array $parameters = array(), $domain = null, $locale = null)
    {
        $trans = $this->translator->transChoice($id, $number, $parameters, $domain, $locale);
        $this->collectMessage($locale, $domain, $id, $trans);

        return $trans;
=======
    public function setLocale(string $locale)
    {
        $this->translator->setLocale($locale);
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
=======
    public function getCatalogue(string $locale = null)
    {
        return $this->translator->getCatalogue($locale);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
<<<<<<< HEAD
     */
    public function getCatalogue($locale = null)
    {
        return $this->translator->getCatalogue($locale);
=======
     *
     * @return string[]
     */
    public function warmUp(string $cacheDir)
    {
        if ($this->translator instanceof WarmableInterface) {
            return (array) $this->translator->warmUp($cacheDir);
        }

        return [];
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
     * @return array
     */
    public function getCollectedMessages()
    {
        return $this->messages;
    }

<<<<<<< HEAD
    /**
     * @param string|null $locale
     * @param string|null $domain
     * @param string      $id
     * @param string      $translation
     */
    private function collectMessage($locale, $domain, $id, $translation)
=======
    private function collectMessage(?string $locale, ?string $domain, string $id, string $translation, ?array $parameters = [])
>>>>>>> v2-test
    {
        if (null === $domain) {
            $domain = 'messages';
        }

<<<<<<< HEAD
        $id = (string) $id;
        $catalogue = $this->translator->getCatalogue($locale);
        $locale = $catalogue->getLocale();
=======
        $catalogue = $this->translator->getCatalogue($locale);
        $locale = $catalogue->getLocale();
        $fallbackLocale = null;
>>>>>>> v2-test
        if ($catalogue->defines($id, $domain)) {
            $state = self::MESSAGE_DEFINED;
        } elseif ($catalogue->has($id, $domain)) {
            $state = self::MESSAGE_EQUALS_FALLBACK;

            $fallbackCatalogue = $catalogue->getFallbackCatalogue();
            while ($fallbackCatalogue) {
                if ($fallbackCatalogue->defines($id, $domain)) {
<<<<<<< HEAD
                    $locale = $fallbackCatalogue->getLocale();
                    break;
                }

=======
                    $fallbackLocale = $fallbackCatalogue->getLocale();
                    break;
                }
>>>>>>> v2-test
                $fallbackCatalogue = $fallbackCatalogue->getFallbackCatalogue();
            }
        } else {
            $state = self::MESSAGE_MISSING;
        }

<<<<<<< HEAD
        $this->messages[] = array(
            'locale' => $locale,
            'domain' => $domain,
            'id' => $id,
            'translation' => $translation,
            'state' => $state,
        );
=======
        $this->messages[] = [
            'locale' => $locale,
            'fallbackLocale' => $fallbackLocale,
            'domain' => $domain,
            'id' => $id,
            'translation' => $translation,
            'parameters' => $parameters,
            'state' => $state,
            'transChoiceNumber' => isset($parameters['%count%']) && is_numeric($parameters['%count%']) ? $parameters['%count%'] : null,
        ];
>>>>>>> v2-test
    }
}
