<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Security\Core\Encoder;

use Symfony\Component\Security\Core\Exception\BadCredentialsException;

/**
 * MessageDigestPasswordEncoder uses a message digest algorithm.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class MessageDigestPasswordEncoder extends BasePasswordEncoder
{
    private $algorithm;
    private $encodeHashAsBase64;
    private $iterations = 1;
    private $encodedLength = -1;

    /**
     * @param string $algorithm          The digest algorithm to use
     * @param bool   $encodeHashAsBase64 Whether to base64 encode the password hash
     * @param int    $iterations         The number of iterations to use to stretch the password hash
     */
    public function __construct(string $algorithm = 'sha512', bool $encodeHashAsBase64 = true, int $iterations = 5000)
    {
        $this->algorithm = $algorithm;
        $this->encodeHashAsBase64 = $encodeHashAsBase64;

        try {
            $this->encodedLength = \strlen($this->encodePassword('', 'salt'));
        } catch (\LogicException $e) {
            // ignore algorithm not supported
        }

        $this->iterations = $iterations;
    }

    /**
     * {@inheritdoc}
     */
    public function encodePassword(string $raw, ?string $salt)
    {
        if ($this->isPasswordTooLong($raw)) {
            throw new BadCredentialsException('Invalid password.');
        }

        if (!\in_array($this->algorithm, hash_algos(), true)) {
            throw new \LogicException(sprintf('The algorithm "%s" is not supported.', $this->algorithm));
        }

        $salted = $this->mergePasswordAndSalt($raw, $salt);
        $digest = hash($this->algorithm, $salted, true);

        // "stretch" hash
        for ($i = 1; $i < $this->iterations; ++$i) {
            $digest = hash($this->algorithm, $digest.$salted, true);
        }

        return $this->encodeHashAsBase64 ? base64_encode($digest) : bin2hex($digest);
    }

    /**
     * {@inheritdoc}
     */
    public function isPasswordValid(string $encoded, string $raw, ?string $salt)
    {
        if (\strlen($encoded) !== $this->encodedLength || false !== strpos($encoded, '$')) {
            return false;
        }

        return !$this->isPasswordTooLong($raw) && $this->comparePasswords($encoded, $this->encodePassword($raw, $salt));
    }
}
