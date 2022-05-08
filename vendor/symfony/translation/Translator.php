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
use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Symfony\Component\Config\ConfigCacheInterface;
use Symfony\Component\Config\ConfigCacheFactoryInterface;
use Symfony\Component\Config\ConfigCacheFactory;

/**
 * Translator.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Translator implements TranslatorInterface, TranslatorBagInterface
=======
use Symfony\Component\Config\ConfigCacheFactory;
use Symfony\Component\Config\ConfigCacheFactoryInterface;
use Symfony\Component\Config\ConfigCacheInterface;
use Symfony\Component\Translation\Exception\InvalidArgumentException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Symfony\Component\Translation\Exception\RuntimeException;
use Symfony\Component\Translation\Formatter\IntlFormatterInterface;
use Symfony\Component\Translation\Formatter\MessageFormatter;
use Symfony\Component\Translation\Formatter\MessageFormatterInterface;
use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Contracts\Translation\LocaleAwareInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

// Help opcache.preload discover always-needed symbols
class_exists(MessageCatalogue::class);

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Translator implements TranslatorInterface, TranslatorBagInterface, LocaleAwareInterface
>>>>>>> v2-test
{
    /**
     * @var MessageCatalogueInterface[]
     */
<<<<<<< HEAD
    protected $catalogues = array();
=======
    protected $catalogues = [];
>>>>>>> v2-test

    /**
     * @var string
     */
<<<<<<< HEAD
    protected $locale;
=======
    private $locale;
>>>>>>> v2-test

    /**
     * @var array
     */
<<<<<<< HEAD
    private $fallbackLocales = array();
=======
    private $fallbackLocales = [];
>>>>>>> v2-test

    /**
     * @var LoaderInterface[]
     */
<<<<<<< HEAD
    private $loaders = array();
=======
    private $loaders = [];
>>>>>>> v2-test

    /**
     * @var array
     */
<<<<<<< HEAD
    private $resources = array();

    /**
     * @var MessageSelector
     */
    private $selector;
=======
    private $resources = [];

    /**
     * @var MessageFormatterInterface
     */
    private $formatter;
>>>>>>> v2-test

    /**
     * @var string
     */
    private $cacheDir;

    /**
     * @var bool
     */
    private $debug;

<<<<<<< HEAD
=======
    private $cacheVary;

>>>>>>> v2-test
    /**
     * @var ConfigCacheFactoryInterface|null
     */
    private $configCacheFactory;

    /**
<<<<<<< HEAD
     * Constructor.
     *
     * @param string               $locale   The locale
     * @param MessageSelector|null $selector The message selector for pluralization
     * @param string|null          $cacheDir The directory to use for the cache
     * @param bool                 $debug    Use cache in debug mode ?
     *
     * @throws \InvalidArgumentException If a locale contains invalid characters
     */
    public function __construct($locale, MessageSelector $selector = null, $cacheDir = null, $debug = false)
    {
        $this->setLocale($locale);
        $this->selector = $selector ?: new MessageSelector();
        $this->cacheDir = $cacheDir;
        $this->debug = $debug;
    }

    /**
     * Sets the ConfigCache factory to use.
     *
     * @param ConfigCacheFactoryInterface $configCacheFactory
     */
=======
     * @var array|null
     */
    private $parentLocales;

    private $hasIntlFormatter;

    /**
     * @throws InvalidArgumentException If a locale contains invalid characters
     */
    public function __construct(string $locale, MessageFormatterInterface $formatter = null, string $cacheDir = null, bool $debug = false, array $cacheVary = [])
    {
        $this->setLocale($locale);

        if (null === $formatter) {
            $formatter = new MessageFormatter();
        }

        $this->formatter = $formatter;
        $this->cacheDir = $cacheDir;
        $this->debug = $debug;
        $this->cacheVary = $cacheVary;
        $this->hasIntlFormatter = $formatter instanceof IntlFormatterInterface;
    }

>>>>>>> v2-test
    public function setConfigCacheFactory(ConfigCacheFactoryInterface $configCacheFactory)
    {
        $this->configCacheFactory = $configCacheFactory;
    }

    /**
     * Adds a Loader.
     *
<<<<<<< HEAD
     * @param string          $format The name of the loader (@see addResource())
     * @param LoaderInterface $loader A LoaderInterface instance
     */
    public function addLoader($format, LoaderInterface $loader)
=======
     * @param string $format The name of the loader (@see addResource())
     */
    public function addLoader(string $format, LoaderInterface $loader)
>>>>>>> v2-test
    {
        $this->loaders[$format] = $loader;
    }

    /**
     * Adds a Resource.
     *
     * @param string $format   The name of the loader (@see addLoader())
     * @param mixed  $resource The resource name
<<<<<<< HEAD
     * @param string $locale   The locale
     * @param string $domain   The domain
     *
     * @throws \InvalidArgumentException If the locale contains invalid characters
     */
    public function addResource($format, $resource, $locale, $domain = null)
=======
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     */
    public function addResource(string $format, $resource, string $locale, string $domain = null)
>>>>>>> v2-test
    {
        if (null === $domain) {
            $domain = 'messages';
        }

        $this->assertValidLocale($locale);

<<<<<<< HEAD
        $this->resources[$locale][] = array($format, $resource, $domain);

        if (in_array($locale, $this->fallbackLocales)) {
            $this->catalogues = array();
=======
        $this->resources[$locale][] = [$format, $resource, $domain];

        if (\in_array($locale, $this->fallbackLocales)) {
            $this->catalogues = [];
>>>>>>> v2-test
        } else {
            unset($this->catalogues[$locale]);
        }
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function setLocale($locale)
    {
        $this->assertValidLocale($locale);
        $this->locale = $locale;
=======
    public function setLocale(string $locale)
    {
        $this->assertValidLocale($locale);
        $this->locale = $locale ?? (class_exists(\Locale::class) ? \Locale::getDefault() : 'en');
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
<<<<<<< HEAD
     * Sets the fallback locale(s).
     *
     * @param string|array $locales The fallback locale(s)
     *
     * @throws \InvalidArgumentException If a locale contains invalid characters
     *
     * @deprecated since version 2.3, to be removed in 3.0. Use setFallbackLocales() instead.
     */
    public function setFallbackLocale($locales)
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.3 and will be removed in 3.0. Use the setFallbackLocales() method instead.', E_USER_DEPRECATED);

        $this->setFallbackLocales(is_array($locales) ? $locales : array($locales));
    }

    /**
=======
>>>>>>> v2-test
     * Sets the fallback locales.
     *
     * @param array $locales The fallback locales
     *
<<<<<<< HEAD
     * @throws \InvalidArgumentException If a locale contains invalid characters
=======
     * @throws InvalidArgumentException If a locale contains invalid characters
>>>>>>> v2-test
     */
    public function setFallbackLocales(array $locales)
    {
        // needed as the fallback locales are linked to the already loaded catalogues
<<<<<<< HEAD
        $this->catalogues = array();
=======
        $this->catalogues = [];
>>>>>>> v2-test

        foreach ($locales as $locale) {
            $this->assertValidLocale($locale);
        }

<<<<<<< HEAD
        $this->fallbackLocales = $locales;
=======
        $this->fallbackLocales = $this->cacheVary['fallback_locales'] = $locales;
>>>>>>> v2-test
    }

    /**
     * Gets the fallback locales.
     *
<<<<<<< HEAD
     * @return array $locales The fallback locales
     */
    public function getFallbackLocales()
=======
     * @internal
     */
    public function getFallbackLocales(): array
>>>>>>> v2-test
    {
        return $this->fallbackLocales;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function trans($id, array $parameters = array(), $domain = null, $locale = null)
    {
        if (null === $domain) {
            $domain = 'messages';
        }

        return strtr($this->getCatalogue($locale)->get((string) $id, $domain), $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function transChoice($id, $number, array $parameters = array(), $domain = null, $locale = null)
    {
=======
    public function trans(?string $id, array $parameters = [], string $domain = null, string $locale = null)
    {
        if (null === $id || '' === $id) {
            return '';
        }

>>>>>>> v2-test
        if (null === $domain) {
            $domain = 'messages';
        }

<<<<<<< HEAD
        $id = (string) $id;
=======
>>>>>>> v2-test
        $catalogue = $this->getCatalogue($locale);
        $locale = $catalogue->getLocale();
        while (!$catalogue->defines($id, $domain)) {
            if ($cat = $catalogue->getFallbackCatalogue()) {
                $catalogue = $cat;
                $locale = $catalogue->getLocale();
            } else {
                break;
            }
        }

<<<<<<< HEAD
        return strtr($this->selector->choose($catalogue->get($id, $domain), (int) $number, $locale), $parameters);
=======
        $len = \strlen(MessageCatalogue::INTL_DOMAIN_SUFFIX);
        if ($this->hasIntlFormatter
            && ($catalogue->defines($id, $domain.MessageCatalogue::INTL_DOMAIN_SUFFIX)
            || (\strlen($domain) > $len && 0 === substr_compare($domain, MessageCatalogue::INTL_DOMAIN_SUFFIX, -$len, $len)))
        ) {
            return $this->formatter->formatIntl($catalogue->get($id, $domain), $locale, $parameters);
        }

        return $this->formatter->format($catalogue->get($id, $domain), $locale, $parameters);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getCatalogue($locale = null)
=======
    public function getCatalogue(string $locale = null)
>>>>>>> v2-test
    {
        if (null === $locale) {
            $locale = $this->getLocale();
        } else {
            $this->assertValidLocale($locale);
        }

        if (!isset($this->catalogues[$locale])) {
            $this->loadCatalogue($locale);
        }

        return $this->catalogues[$locale];
    }

    /**
     * Gets the loaders.
     *
     * @return array LoaderInterface[]
     */
    protected function getLoaders()
    {
        return $this->loaders;
    }

<<<<<<< HEAD
    /**
     * Collects all messages for the given locale.
     *
     * @param string|null $locale Locale of translations, by default is current locale
     *
     * @return array[array] indexed by catalog
     */
    public function getMessages($locale = null)
    {
        $catalogue = $this->getCatalogue($locale);
        $messages = $catalogue->all();
        while ($catalogue = $catalogue->getFallbackCatalogue()) {
            $messages = array_replace_recursive($catalogue->all(), $messages);
        }

        return $messages;
    }

    /**
     * @param string $locale
     */
    protected function loadCatalogue($locale)
=======
    protected function loadCatalogue(string $locale)
>>>>>>> v2-test
    {
        if (null === $this->cacheDir) {
            $this->initializeCatalogue($locale);
        } else {
            $this->initializeCacheCatalogue($locale);
        }
    }

<<<<<<< HEAD
    /**
     * @param string $locale
     */
    protected function initializeCatalogue($locale)
=======
    protected function initializeCatalogue(string $locale)
>>>>>>> v2-test
    {
        $this->assertValidLocale($locale);

        try {
            $this->doLoadCatalogue($locale);
        } catch (NotFoundResourceException $e) {
            if (!$this->computeFallbackLocales($locale)) {
                throw $e;
            }
        }
        $this->loadFallbackCatalogues($locale);
    }

<<<<<<< HEAD
    /**
     * @param string $locale
     */
    private function initializeCacheCatalogue($locale)
=======
    private function initializeCacheCatalogue(string $locale): void
>>>>>>> v2-test
    {
        if (isset($this->catalogues[$locale])) {
            /* Catalogue already initialized. */
            return;
        }

        $this->assertValidLocale($locale);
<<<<<<< HEAD
        $self = $this; // required for PHP 5.3 where "$this" cannot be use()d in anonymous functions. Change in Symfony 3.0.
        $cache = $this->getConfigCacheFactory()->cache($this->getCatalogueCachePath($locale),
            function (ConfigCacheInterface $cache) use ($self, $locale) {
                $self->dumpCatalogue($locale, $cache);
=======
        $cache = $this->getConfigCacheFactory()->cache($this->getCatalogueCachePath($locale),
            function (ConfigCacheInterface $cache) use ($locale) {
                $this->dumpCatalogue($locale, $cache);
>>>>>>> v2-test
            }
        );

        if (isset($this->catalogues[$locale])) {
            /* Catalogue has been initialized as it was written out to cache. */
            return;
        }

        /* Read catalogue from cache. */
        $this->catalogues[$locale] = include $cache->getPath();
    }

<<<<<<< HEAD
    /**
     * This method is public because it needs to be callable from a closure in PHP 5.3. It should be made protected (or even private, if possible) in 3.0.
     *
     * @internal
     */
    public function dumpCatalogue($locale, ConfigCacheInterface $cache)
=======
    private function dumpCatalogue(string $locale, ConfigCacheInterface $cache): void
>>>>>>> v2-test
    {
        $this->initializeCatalogue($locale);
        $fallbackContent = $this->getFallbackContent($this->catalogues[$locale]);

        $content = sprintf(<<<EOF
<?php

use Symfony\Component\Translation\MessageCatalogue;

\$catalogue = new MessageCatalogue('%s', %s);

%s
return \$catalogue;

EOF
            ,
            $locale,
<<<<<<< HEAD
            var_export($this->catalogues[$locale]->all(), true),
=======
            var_export($this->getAllMessages($this->catalogues[$locale]), true),
>>>>>>> v2-test
            $fallbackContent
        );

        $cache->write($content, $this->catalogues[$locale]->getResources());
    }

<<<<<<< HEAD
    private function getFallbackContent(MessageCatalogue $catalogue)
=======
    private function getFallbackContent(MessageCatalogue $catalogue): string
>>>>>>> v2-test
    {
        $fallbackContent = '';
        $current = '';
        $replacementPattern = '/[^a-z0-9_]/i';
        $fallbackCatalogue = $catalogue->getFallbackCatalogue();
        while ($fallbackCatalogue) {
            $fallback = $fallbackCatalogue->getLocale();
            $fallbackSuffix = ucfirst(preg_replace($replacementPattern, '_', $fallback));
            $currentSuffix = ucfirst(preg_replace($replacementPattern, '_', $current));

<<<<<<< HEAD
            $fallbackContent .= sprintf(<<<EOF
\$catalogue%s = new MessageCatalogue('%s', %s);
\$catalogue%s->addFallbackCatalogue(\$catalogue%s);
=======
            $fallbackContent .= sprintf(<<<'EOF'
$catalogue%s = new MessageCatalogue('%s', %s);
$catalogue%s->addFallbackCatalogue($catalogue%s);
>>>>>>> v2-test

EOF
                ,
                $fallbackSuffix,
                $fallback,
<<<<<<< HEAD
                var_export($fallbackCatalogue->all(), true),
=======
                var_export($this->getAllMessages($fallbackCatalogue), true),
>>>>>>> v2-test
                $currentSuffix,
                $fallbackSuffix
            );
            $current = $fallbackCatalogue->getLocale();
            $fallbackCatalogue = $fallbackCatalogue->getFallbackCatalogue();
        }

        return $fallbackContent;
    }

<<<<<<< HEAD
    private function getCatalogueCachePath($locale)
    {
        return $this->cacheDir.'/catalogue.'.$locale.'.'.sha1(serialize($this->fallbackLocales)).'.php';
    }

    private function doLoadCatalogue($locale)
=======
    private function getCatalogueCachePath(string $locale): string
    {
        return $this->cacheDir.'/catalogue.'.$locale.'.'.strtr(substr(base64_encode(hash('sha256', serialize($this->cacheVary), true)), 0, 7), '/', '_').'.php';
    }

    /**
     * @internal
     */
    protected function doLoadCatalogue(string $locale): void
>>>>>>> v2-test
    {
        $this->catalogues[$locale] = new MessageCatalogue($locale);

        if (isset($this->resources[$locale])) {
            foreach ($this->resources[$locale] as $resource) {
                if (!isset($this->loaders[$resource[0]])) {
<<<<<<< HEAD
                    throw new \RuntimeException(sprintf('The "%s" translation loader is not registered.', $resource[0]));
=======
                    if (\is_string($resource[1])) {
                        throw new RuntimeException(sprintf('No loader is registered for the "%s" format when loading the "%s" resource.', $resource[0], $resource[1]));
                    }

                    throw new RuntimeException(sprintf('No loader is registered for the "%s" format.', $resource[0]));
>>>>>>> v2-test
                }
                $this->catalogues[$locale]->addCatalogue($this->loaders[$resource[0]]->load($resource[1], $locale, $resource[2]));
            }
        }
    }

<<<<<<< HEAD
    private function loadFallbackCatalogues($locale)
=======
    private function loadFallbackCatalogues(string $locale): void
>>>>>>> v2-test
    {
        $current = $this->catalogues[$locale];

        foreach ($this->computeFallbackLocales($locale) as $fallback) {
            if (!isset($this->catalogues[$fallback])) {
<<<<<<< HEAD
                $this->doLoadCatalogue($fallback);
            }

            $fallbackCatalogue = new MessageCatalogue($fallback, $this->catalogues[$fallback]->all());
=======
                $this->initializeCatalogue($fallback);
            }

            $fallbackCatalogue = new MessageCatalogue($fallback, $this->getAllMessages($this->catalogues[$fallback]));
>>>>>>> v2-test
            foreach ($this->catalogues[$fallback]->getResources() as $resource) {
                $fallbackCatalogue->addResource($resource);
            }
            $current->addFallbackCatalogue($fallbackCatalogue);
            $current = $fallbackCatalogue;
        }
    }

<<<<<<< HEAD
    protected function computeFallbackLocales($locale)
    {
        $locales = array();
=======
    protected function computeFallbackLocales(string $locale)
    {
        if (null === $this->parentLocales) {
            $this->parentLocales = json_decode(file_get_contents(__DIR__.'/Resources/data/parents.json'), true);
        }

        $locales = [];
>>>>>>> v2-test
        foreach ($this->fallbackLocales as $fallback) {
            if ($fallback === $locale) {
                continue;
            }

            $locales[] = $fallback;
        }

<<<<<<< HEAD
        if (strrchr($locale, '_') !== false) {
            array_unshift($locales, substr($locale, 0, -strlen(strrchr($locale, '_'))));
=======
        while ($locale) {
            $parent = $this->parentLocales[$locale] ?? null;

            if ($parent) {
                $locale = 'root' !== $parent ? $parent : null;
            } elseif (\function_exists('locale_parse')) {
                $localeSubTags = locale_parse($locale);
                $locale = null;
                if (1 < \count($localeSubTags)) {
                    array_pop($localeSubTags);
                    $locale = locale_compose($localeSubTags) ?: null;
                }
            } elseif ($i = strrpos($locale, '_') ?: strrpos($locale, '-')) {
                $locale = substr($locale, 0, $i);
            } else {
                $locale = null;
            }

            if (null !== $locale) {
                array_unshift($locales, $locale);
            }
>>>>>>> v2-test
        }

        return array_unique($locales);
    }

    /**
     * Asserts that the locale is valid, throws an Exception if not.
     *
<<<<<<< HEAD
     * @param string $locale Locale to tests
     *
     * @throws \InvalidArgumentException If the locale contains invalid characters
     */
    protected function assertValidLocale($locale)
    {
        if (1 !== preg_match('/^[a-z0-9@_\\.\\-]*$/i', $locale)) {
            throw new \InvalidArgumentException(sprintf('Invalid "%s" locale.', $locale));
=======
     * @throws InvalidArgumentException If the locale contains invalid characters
     */
    protected function assertValidLocale(string $locale)
    {
        if (1 !== preg_match('/^[a-z0-9@_\\.\\-]*$/i', $locale)) {
            throw new InvalidArgumentException(sprintf('Invalid "%s" locale.', $locale));
>>>>>>> v2-test
        }
    }

    /**
     * Provides the ConfigCache factory implementation, falling back to a
     * default implementation if necessary.
<<<<<<< HEAD
     *
     * @return ConfigCacheFactoryInterface $configCacheFactory
     */
    private function getConfigCacheFactory()
=======
     */
    private function getConfigCacheFactory(): ConfigCacheFactoryInterface
>>>>>>> v2-test
    {
        if (!$this->configCacheFactory) {
            $this->configCacheFactory = new ConfigCacheFactory($this->debug);
        }

        return $this->configCacheFactory;
    }
<<<<<<< HEAD
=======

    private function getAllMessages(MessageCatalogueInterface $catalogue): array
    {
        $allMessages = [];

        foreach ($catalogue->all() as $domain => $messages) {
            if ($intlMessages = $catalogue->all($domain.MessageCatalogue::INTL_DOMAIN_SUFFIX)) {
                $allMessages[$domain.MessageCatalogue::INTL_DOMAIN_SUFFIX] = $intlMessages;
                $messages = array_diff_key($messages, $intlMessages);
            }
            if ($messages) {
                $allMessages[$domain] = $messages;
            }
        }

        return $allMessages;
    }
>>>>>>> v2-test
}
