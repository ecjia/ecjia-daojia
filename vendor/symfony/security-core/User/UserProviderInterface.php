<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Security\Core\User;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * Represents a class that loads UserInterface objects from some source for the authentication system.
 *
 * In a typical authentication configuration, a username (i.e. some unique
 * user identifier) credential enters the system (via form login, or any
 * method). The user provider that is configured with that authentication
 * method is asked to load the UserInterface object for the given username
 * (via loadUserByUsername) so that the rest of the process can continue.
 *
 * Internally, a user provider can load users from any source (databases,
 * configuration, web service). This is totally independent of how the authentication
 * information is submitted or what the UserInterface object looks like.
 *
 * @see UserInterface
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface UserProviderInterface
{
    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername(string $username);

    /**
     * Refreshes the user.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException  if the user is not supported
     * @throws UsernameNotFoundException if the user is not found
     */
    public function refreshUser(UserInterface $user);

    /**
     * Whether this provider supports the given user class.
     *
     * @return bool
     */
    public function supportsClass(string $class);
}
