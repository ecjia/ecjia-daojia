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

namespace PhpSpec\Config;

<<<<<<< HEAD
=======
use Symfony\Component\Console\Output\OutputInterface;

>>>>>>> v2-test
class OptionsConfig
{
    /**
     * @var bool
     */
    private $stopOnFailureEnabled;

    /**
     * @var bool
     */
    private $codeGenerationEnabled;

    /**
     * @var bool
     */
    private $reRunEnabled;

    /**
     * @var bool
     */
    private $fakingEnabled;
<<<<<<< HEAD
=======

>>>>>>> v2-test
    /**
     * @var string|bool
     */
    private $bootstrapPath;

    /**
<<<<<<< HEAD
=======
     * @var string
     */
    private $isVerbose;

    /**
>>>>>>> v2-test
     * @param bool $stopOnFailureEnabled
     * @param bool $codeGenerationEnabled
     * @param bool $reRunEnabled
     * @param bool $fakingEnabled
     * @param string|bool $bootstrapPath
<<<<<<< HEAD
     */
    public function __construct(
        $stopOnFailureEnabled,
        $codeGenerationEnabled,
        $reRunEnabled,
        $fakingEnabled,
        $bootstrapPath
=======
     * @param bool $isVerbose
     */
    public function __construct(
        bool $stopOnFailureEnabled,
        bool $codeGenerationEnabled,
        bool $reRunEnabled,
        bool $fakingEnabled,
        $bootstrapPath,
        $isVerbose
>>>>>>> v2-test
    ) {
        $this->stopOnFailureEnabled  = $stopOnFailureEnabled;
        $this->codeGenerationEnabled = $codeGenerationEnabled;
        $this->reRunEnabled = $reRunEnabled;
        $this->fakingEnabled = $fakingEnabled;
        $this->bootstrapPath = $bootstrapPath;
<<<<<<< HEAD
=======
        $this->isVerbose = $isVerbose;
>>>>>>> v2-test
    }

    /**
     * @return bool
     */
<<<<<<< HEAD
    public function isStopOnFailureEnabled()
=======
    public function isStopOnFailureEnabled(): bool
>>>>>>> v2-test
    {
        return $this->stopOnFailureEnabled;
    }

    /**
     * @return bool
     */
<<<<<<< HEAD
    public function isCodeGenerationEnabled()
=======
    public function isCodeGenerationEnabled(): bool
>>>>>>> v2-test
    {
        return $this->codeGenerationEnabled;
    }

<<<<<<< HEAD
    public function isReRunEnabled()
=======
    public function isReRunEnabled(): bool
>>>>>>> v2-test
    {
        return $this->reRunEnabled;
    }

<<<<<<< HEAD
    public function isFakingEnabled()
=======
    public function isFakingEnabled(): bool
>>>>>>> v2-test
    {
        return $this->fakingEnabled;
    }

    public function getBootstrapPath()
    {
        return $this->bootstrapPath;
    }
<<<<<<< HEAD
=======

    public function isVerbose(): bool
    {
        return $this->isVerbose;
    }
>>>>>>> v2-test
}
