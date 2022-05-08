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
 * Storage for profiler using files.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class FileProfilerStorage implements ProfilerStorageInterface
{
    /**
     * Folder where profiler data are stored.
     *
     * @var string
     */
    private $folder;

    /**
     * Constructs the file storage using a "dsn-like" path.
     *
     * Example : "file:/path/to/the/storage/folder"
     *
<<<<<<< HEAD
     * @param string $dsn The DSN
     *
     * @throws \RuntimeException
     */
    public function __construct($dsn)
=======
     * @throws \RuntimeException
     */
    public function __construct(string $dsn)
>>>>>>> v2-test
    {
        if (0 !== strpos($dsn, 'file:')) {
            throw new \RuntimeException(sprintf('Please check your configuration. You are trying to use FileStorage with an invalid dsn "%s". The expected format is "file:/path/to/the/storage/folder".', $dsn));
        }
        $this->folder = substr($dsn, 5);

        if (!is_dir($this->folder) && false === @mkdir($this->folder, 0777, true) && !is_dir($this->folder)) {
            throw new \RuntimeException(sprintf('Unable to create the storage directory (%s).', $this->folder));
        }
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function find($ip, $url, $limit, $method, $start = null, $end = null)
=======
    public function find(?string $ip, ?string $url, ?int $limit, ?string $method, int $start = null, int $end = null, string $statusCode = null): array
>>>>>>> v2-test
    {
        $file = $this->getIndexFilename();

        if (!file_exists($file)) {
<<<<<<< HEAD
            return array();
        }

        $file = fopen($file, 'r');
        fseek($file, 0, SEEK_END);

        $result = array();
        while (count($result) < $limit && $line = $this->readLineFromFile($file)) {
            $values = str_getcsv($line);
            list($csvToken, $csvIp, $csvMethod, $csvUrl, $csvTime, $csvParent) = $values;
            $csvStatusCode = isset($values[6]) ? $values[6] : null;

            $csvTime = (int) $csvTime;

            if ($ip && false === strpos($csvIp, $ip) || $url && false === strpos($csvUrl, $url) || $method && false === strpos($csvMethod, $method)) {
=======
            return [];
        }

        $file = fopen($file, 'r');
        fseek($file, 0, \SEEK_END);

        $result = [];
        while (\count($result) < $limit && $line = $this->readLineFromFile($file)) {
            $values = str_getcsv($line);
            [$csvToken, $csvIp, $csvMethod, $csvUrl, $csvTime, $csvParent, $csvStatusCode] = $values;
            $csvTime = (int) $csvTime;

            if ($ip && false === strpos($csvIp, $ip) || $url && false === strpos($csvUrl, $url) || $method && false === strpos($csvMethod, $method) || $statusCode && false === strpos($csvStatusCode, $statusCode)) {
>>>>>>> v2-test
                continue;
            }

            if (!empty($start) && $csvTime < $start) {
                continue;
            }

            if (!empty($end) && $csvTime > $end) {
                continue;
            }

<<<<<<< HEAD
            $result[$csvToken] = array(
=======
            $result[$csvToken] = [
>>>>>>> v2-test
                'token' => $csvToken,
                'ip' => $csvIp,
                'method' => $csvMethod,
                'url' => $csvUrl,
                'time' => $csvTime,
                'parent' => $csvParent,
                'status_code' => $csvStatusCode,
<<<<<<< HEAD
            );
=======
            ];
>>>>>>> v2-test
        }

        fclose($file);

        return array_values($result);
    }

    /**
     * {@inheritdoc}
     */
    public function purge()
    {
        $flags = \FilesystemIterator::SKIP_DOTS;
        $iterator = new \RecursiveDirectoryIterator($this->folder, $flags);
        $iterator = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($iterator as $file) {
            if (is_file($file)) {
                unlink($file);
            } else {
                rmdir($file);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function read($token)
    {
        if (!$token || !file_exists($file = $this->getFilename($token))) {
            return;
=======
    public function read(string $token): ?Profile
    {
        if (!$token || !file_exists($file = $this->getFilename($token))) {
            return null;
        }

        if (\function_exists('gzcompress')) {
            $file = 'compress.zlib://'.$file;
>>>>>>> v2-test
        }

        return $this->createProfileFromData($token, unserialize(file_get_contents($file)));
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
     */
<<<<<<< HEAD
    public function write(Profile $profile)
=======
    public function write(Profile $profile): bool
>>>>>>> v2-test
    {
        $file = $this->getFilename($profile->getToken());

        $profileIndexed = is_file($file);
        if (!$profileIndexed) {
            // Create directory
<<<<<<< HEAD
            $dir = dirname($file);
=======
            $dir = \dirname($file);
>>>>>>> v2-test
            if (!is_dir($dir) && false === @mkdir($dir, 0777, true) && !is_dir($dir)) {
                throw new \RuntimeException(sprintf('Unable to create the storage directory (%s).', $dir));
            }
        }

<<<<<<< HEAD
        // Store profile
        $data = array(
            'token' => $profile->getToken(),
            'parent' => $profile->getParentToken(),
            'children' => array_map(function ($p) { return $p->getToken(); }, $profile->getChildren()),
=======
        $profileToken = $profile->getToken();
        // when there are errors in sub-requests, the parent and/or children tokens
        // may equal the profile token, resulting in infinite loops
        $parentToken = $profile->getParentToken() !== $profileToken ? $profile->getParentToken() : null;
        $childrenToken = array_filter(array_map(function (Profile $p) use ($profileToken) {
            return $profileToken !== $p->getToken() ? $p->getToken() : null;
        }, $profile->getChildren()));

        // Store profile
        $data = [
            'token' => $profileToken,
            'parent' => $parentToken,
            'children' => $childrenToken,
>>>>>>> v2-test
            'data' => $profile->getCollectors(),
            'ip' => $profile->getIp(),
            'method' => $profile->getMethod(),
            'url' => $profile->getUrl(),
            'time' => $profile->getTime(),
<<<<<<< HEAD
        );

        if (false === file_put_contents($file, serialize($data))) {
=======
            'status_code' => $profile->getStatusCode(),
        ];

        $context = stream_context_create();

        if (\function_exists('gzcompress')) {
            $file = 'compress.zlib://'.$file;
            stream_context_set_option($context, 'zlib', 'level', 3);
        }

        if (false === file_put_contents($file, serialize($data), 0, $context)) {
>>>>>>> v2-test
            return false;
        }

        if (!$profileIndexed) {
            // Add to index
            if (false === $file = fopen($this->getIndexFilename(), 'a')) {
                return false;
            }

<<<<<<< HEAD
            fputcsv($file, array(
=======
            fputcsv($file, [
>>>>>>> v2-test
                $profile->getToken(),
                $profile->getIp(),
                $profile->getMethod(),
                $profile->getUrl(),
                $profile->getTime(),
                $profile->getParentToken(),
                $profile->getStatusCode(),
<<<<<<< HEAD
            ));
=======
            ]);
>>>>>>> v2-test
            fclose($file);
        }

        return true;
    }

    /**
     * Gets filename to store data, associated to the token.
     *
<<<<<<< HEAD
     * @param string $token
     *
     * @return string The profile filename
     */
    protected function getFilename($token)
=======
     * @return string The profile filename
     */
    protected function getFilename(string $token)
>>>>>>> v2-test
    {
        // Uses 4 last characters, because first are mostly the same.
        $folderA = substr($token, -2, 2);
        $folderB = substr($token, -4, 2);

        return $this->folder.'/'.$folderA.'/'.$folderB.'/'.$token;
    }

    /**
     * Gets the index filename.
     *
     * @return string The index filename
     */
    protected function getIndexFilename()
    {
        return $this->folder.'/index.csv';
    }

    /**
     * Reads a line in the file, backward.
     *
     * This function automatically skips the empty lines and do not include the line return in result value.
     *
     * @param resource $file The file resource, with the pointer placed at the end of the line to read
     *
     * @return mixed A string representing the line or null if beginning of file is reached
     */
    protected function readLineFromFile($file)
    {
        $line = '';
        $position = ftell($file);

        if (0 === $position) {
<<<<<<< HEAD
            return;
=======
            return null;
>>>>>>> v2-test
        }

        while (true) {
            $chunkSize = min($position, 1024);
            $position -= $chunkSize;
            fseek($file, $position);

            if (0 === $chunkSize) {
                // bof reached
                break;
            }

            $buffer = fread($file, $chunkSize);

            if (false === ($upTo = strrpos($buffer, "\n"))) {
                $line = $buffer.$line;
                continue;
            }

            $position += $upTo;
            $line = substr($buffer, $upTo + 1).$line;
<<<<<<< HEAD
            fseek($file, max(0, $position), SEEK_SET);
=======
            fseek($file, max(0, $position), \SEEK_SET);
>>>>>>> v2-test

            if ('' !== $line) {
                break;
            }
        }

        return '' === $line ? null : $line;
    }

<<<<<<< HEAD
    protected function createProfileFromData($token, $data, $parent = null)
=======
    protected function createProfileFromData(string $token, array $data, Profile $parent = null)
>>>>>>> v2-test
    {
        $profile = new Profile($token);
        $profile->setIp($data['ip']);
        $profile->setMethod($data['method']);
        $profile->setUrl($data['url']);
        $profile->setTime($data['time']);
<<<<<<< HEAD
=======
        $profile->setStatusCode($data['status_code']);
>>>>>>> v2-test
        $profile->setCollectors($data['data']);

        if (!$parent && $data['parent']) {
            $parent = $this->read($data['parent']);
        }

        if ($parent) {
            $profile->setParent($parent);
        }

        foreach ($data['children'] as $token) {
            if (!$token || !file_exists($file = $this->getFilename($token))) {
                continue;
            }

<<<<<<< HEAD
=======
            if (\function_exists('gzcompress')) {
                $file = 'compress.zlib://'.$file;
            }

>>>>>>> v2-test
            $profile->addChild($this->createProfileFromData($token, unserialize(file_get_contents($file)), $profile));
        }

        return $profile;
    }
}
