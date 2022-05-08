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

namespace PhpSpec\Formatter\Presenter\Differ;

class Differ
{
    private $engines = array();

    public function __construct(array $engines = array())
    {
        $this->engines = $engines;
    }

<<<<<<< HEAD
    public function addEngine(EngineInterface $engine)
=======
    public function addEngine(DifferEngine $engine): void
>>>>>>> v2-test
    {
        $this->engines[] = $engine;
    }

    public function compare($expected, $actual)
    {
        foreach ($this->engines as $engine) {
            if ($engine->supports($expected, $actual)) {
                return rtrim($engine->compare($expected, $actual));
            }
        }
    }
}
