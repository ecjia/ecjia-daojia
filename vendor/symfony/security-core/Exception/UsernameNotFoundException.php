<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Security\Core\Exception;

/**
 * UsernameNotFoundException is thrown if a User cannot be found by its username.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Alexander <iam.asm89@gmail.com>
 */
class UsernameNotFoundException extends AuthenticationException
{
    private $username;

    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return 'Username could not be found.';
    }

    /**
     * Get the username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the username.
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessageData()
    {
        return ['{{ username }}' => $this->username];
    }

    /**
     * {@inheritdoc}
     */
    public function __serialize(): array
    {
        return [$this->username, parent::__serialize()];
    }

    /**
     * {@inheritdoc}
     */
    public function __unserialize(array $data): void
    {
        [$this->username, $parentData] = $data;
        $parentData = \is_array($parentData) ? $parentData : unserialize($parentData);
        parent::__unserialize($parentData);
    }
}
