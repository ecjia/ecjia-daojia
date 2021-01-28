<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Security\Core\Authentication\Provider;

use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * AuthenticationProviderInterface is the interface for all authentication
 * providers.
 *
 * Concrete implementations processes specific Token instances.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface AuthenticationProviderInterface extends AuthenticationManagerInterface
{
    /**
     * Use this constant for not provided username.
     *
     * @var string
     */
    public const USERNAME_NONE_PROVIDED = 'NONE_PROVIDED';

    /**
     * Checks whether this provider supports the given token.
     *
     * @return bool true if the implementation supports the Token, false otherwise
     */
    public function supports(TokenInterface $token);
}
