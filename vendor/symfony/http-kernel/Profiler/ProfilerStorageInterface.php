<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Profiler;

/**
 * ProfilerStorageInterface.
 *
<<<<<<< HEAD
=======
 * This interface exists for historical reasons. The only supported
 * implementation is FileProfilerStorage.
 *
 * As the profiler must only be used on non-production servers, the file storage
 * is more than enough and no other implementations will ever be supported.
 *
 * @internal
 *
>>>>>>> v2-test
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface ProfilerStorageInterface
{
    /**
     * Finds profiler tokens for the given criteria.
     *
<<<<<<< HEAD
     * @param string   $ip     The IP
     * @param string   $url    The URL
     * @param string   $limit  The maximum number of tokens to return
     * @param string   $method The request method
     * @param int|null $start  The start date to search from
     * @param int|null $end    The end date to search to
     *
     * @return array An array of tokens
     */
    public function find($ip, $url, $limit, $method, $start = null, $end = null);
=======
     * @param int|null $limit The maximum number of tokens to return
     * @param int|null $start The start date to search from
     * @param int|null $end   The end date to search to
     *
     * @return array An array of tokens
     */
    public function find(?string $ip, ?string $url, ?int $limit, ?string $method, int $start = null, int $end = null): array;
>>>>>>> v2-test

    /**
     * Reads data associated with the given token.
     *
     * The method returns false if the token does not exist in the storage.
     *
<<<<<<< HEAD
     * @param string $token A token
     *
     * @return Profile The profile associated with token
     */
    public function read($token);
=======
     * @return Profile|null The profile associated with token
     */
    public function read(string $token): ?Profile;
>>>>>>> v2-test

    /**
     * Saves a Profile.
     *
<<<<<<< HEAD
     * @param Profile $profile A Profile instance
     *
     * @return bool Write operation successful
     */
    public function write(Profile $profile);
=======
     * @return bool Write operation successful
     */
    public function write(Profile $profile): bool;
>>>>>>> v2-test

    /**
     * Purges all data from the database.
     */
    public function purge();
}
