<?php

/*
 * This file is part of PhpSpec, A php toolset to drive emergent
 * design by specification.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpSpec\CodeGenerator;

use PhpSpec\Util\Filesystem;

/**
 * Template renderer class can render templates in registered locations. It comes
 * with a simple placeholder string replacement for specified fields
 */
class TemplateRenderer
{
    /**
     * @var array
     */
    private $locations = array();

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param Filesystem $filesystem
     */
<<<<<<< HEAD
    public function __construct(Filesystem $filesystem = null)
    {
        $this->filesystem = $filesystem ?: new Filesystem();
=======
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
>>>>>>> v2-test
    }

    /**
     * @param array $locations
     */
<<<<<<< HEAD
    public function setLocations(array $locations)
=======
    public function setLocations(array $locations): void
>>>>>>> v2-test
    {
        $this->locations = array_map(array($this, 'normalizeLocation'), $locations);
    }

<<<<<<< HEAD
    /**
     * @param string $location
     */
    public function prependLocation($location)
=======
    public function prependLocation(string $location): void
>>>>>>> v2-test
    {
        array_unshift($this->locations, $this->normalizeLocation($location));
    }

<<<<<<< HEAD
    /**
     * @param string $location
     */
    public function appendLocation($location)
=======
    public function appendLocation(string $location): void
>>>>>>> v2-test
    {
        array_push($this->locations, $this->normalizeLocation($location));
    }

<<<<<<< HEAD
    /**
     * @return array
     */
    public function getLocations()
=======
    public function getLocations(): array
>>>>>>> v2-test
    {
        return $this->locations;
    }

<<<<<<< HEAD
    /**
     * @param string $name
     * @param array  $values
     *
     * @return string
     */
    public function render($name, array $values = array())
=======
    public function render(string $name, array $values = array()): string
>>>>>>> v2-test
    {
        foreach ($this->locations as $location) {
            $path = $location.DIRECTORY_SEPARATOR.$this->normalizeLocation($name, true).'.tpl';

            if ($this->filesystem->pathExists($path)) {
                return $this->renderString($this->filesystem->getFileContents($path), $values);
            }
        }
<<<<<<< HEAD
    }

    /**
     * @param string $template
     * @param array  $values
     *
     * @return string
     */
    public function renderString($template, array $values = array())
=======
        return '';
    }

    public function renderString(string $template, array $values = array()): string
>>>>>>> v2-test
    {
        return strtr($template, $values);
    }

<<<<<<< HEAD
    /**
     * @param string $location
     * @param bool   $trimLeft
     *
     * @return string
     */
    private function normalizeLocation($location, $trimLeft = false)
=======
    private function normalizeLocation(string $location, bool $trimLeft = false): string
>>>>>>> v2-test
    {
        $location = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $location);
        $location = rtrim($location, DIRECTORY_SEPARATOR);

        if ($trimLeft) {
            $location = ltrim($location, DIRECTORY_SEPARATOR);
        }

        return $location;
    }
}
