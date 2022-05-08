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
 * Pbkdf2PasswordEncoder uses the PBKDF2 (Password-Based Key Derivation Function 2).
 *
 * Providing a high level of Cryptographic security,
 *  PBKDF2 is recommended by the National Institute of Standards and Technology (NIST).
 *
 * But also warrants a warning, using PBKDF2 (with a high number of iterations) slows down the process.
 * PBKDF2 should be used with caution and care.
 *
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 * @author Andrew Johnson
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Pbkdf2PasswordEncoder extends BasePasswordEncoder
{
    private $algorithm;
    private $encodeHashAsBase64;
    private $iterations = 1;
    private $length;
    private $encodedLength = -1;

    /**
     * @param string $algorithm          The digest algorithm to use
     * @param bool   $encodeHashAsBase64 Whether to base64 encode the password hash
     * @param int    $iterations         The number of iterations to use to stretch the password hash
     * @param int    $length             Length of derived key to create
     */
    public function __construct(string $algorithm = 'sha512', bool $encodeHashAsBase64 = true, int $iterations = 1000, int $length = 40)
    {
        $this->algorithm = $algorithm;
        $this->encodeHashAsBase64 = $encodeHashAsBase64;
        $this->length = $length;

        try {
            $this->encodedLength = \strlen($this->encodePassword('', 'salt'));
        } catch (\LogicException $e) {
            // ignore algorithm not supported
        }

        $this->iterations = $iterations;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \LogicException when the algorithm is not supported
     */
    public function encodePassword(string $raw, ?string $salt)
    {
        if ($this->isPasswordTooLong($raw)) {
            throw new BadCredentialsException('Invalid password.');
        }

        if (!\in_array($this->algorithm, hash_algos(), true)) {
            throw new \LogicException(sprintf('The algorithm "%s" is not supported.', $this->algorithm));
        }

        $digest = hash_pbkdf2($this->algorithm, $raw, $salt, $this->iterations, $this->length, true);

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
