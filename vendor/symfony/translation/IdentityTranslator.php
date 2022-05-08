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
=======
use Symfony\Contracts\Translation\LocaleAwareInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Contracts\Translation\TranslatorTrait;

>>>>>>> v2-test
/**
 * IdentityTranslator does not translate anything.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
<<<<<<< HEAD
class IdentityTranslator implements TranslatorInterface
{
    private $selector;
    private $locale;

    /**
     * Constructor.
     *
     * @param MessageSelector|null $selector The message selector for pluralization
     */
    public function __construct(MessageSelector $selector = null)
    {
        $this->selector = $selector ?: new MessageSelector();
    }

    /**
     * {@inheritdoc}
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        return $this->locale ?: \Locale::getDefault();
    }

    /**
     * {@inheritdoc}
     */
    public function trans($id, array $parameters = array(), $domain = null, $locale = null)
    {
        return strtr((string) $id, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function transChoice($id, $number, array $parameters = array(), $domain = null, $locale = null)
    {
        return strtr($this->selector->choose((string) $id, (int) $number, $locale ?: $this->getLocale()), $parameters);
    }
=======
class IdentityTranslator implements TranslatorInterface, LocaleAwareInterface
{
    use TranslatorTrait;
>>>>>>> v2-test
}
