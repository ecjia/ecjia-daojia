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

namespace PhpSpec\Formatter\Html;

use PhpSpec\Formatter\Template as TemplateInterface;
<<<<<<< HEAD
use PhpSpec\IO\IOInterface;

class Template implements TemplateInterface
=======
use PhpSpec\IO\IO;

final class Template implements TemplateInterface
>>>>>>> v2-test
{
    const DIR = __DIR__;

    /**
<<<<<<< HEAD
     * @var IOInterface
=======
     * @var IO
>>>>>>> v2-test
     */
    private $io;

    /**
<<<<<<< HEAD
     * @param IOInterface $io
     */
    public function __construct(IOInterface $io)
=======
     * @param IO $io
     */
    public function __construct(IO $io)
>>>>>>> v2-test
    {
        $this->io = $io;
    }

    /**
     * @param string $text
     * @param array  $templateVars
     */
<<<<<<< HEAD
    public function render($text, array $templateVars = array())
=======
    public function render(string $text, array $templateVars = array()): void
>>>>>>> v2-test
    {
        if (file_exists($text)) {
            $text = file_get_contents($text);
        }
        $templateKeys = $this->extractKeys($templateVars);
        $output = str_replace($templateKeys, array_values($templateVars), $text);
        $this->io->write($output);
    }

    /**
     * @param array $templateVars
     *
     * @return array
     */
<<<<<<< HEAD
    private function extractKeys(array $templateVars)
=======
    private function extractKeys(array $templateVars): array
>>>>>>> v2-test
    {
        return array_map(function ($e) {
            return '{'.$e.'}';
        }, array_keys($templateVars));
    }
}
