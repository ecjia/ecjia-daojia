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

use Symfony\Component\Console\Output\OutputInterface;

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

    /**
     * @var string|bool
     */
    private $bootstrapPath;

    /**
     * @var string
     */
    private $isVerbose;

    /**
     * @param bool $stopOnFailureEnabled
     * @param bool $codeGenerationEnabled
     * @param bool $reRunEnabled
     * @param bool $fakingEnabled
     * @param string|bool $bootstrapPath
     * @param bool $isVerbose
     */
    public function __construct(
        bool $stopOnFailureEnabled,
        bool $codeGenerationEnabled,
        bool $reRunEnabled,
        bool $fakingEnabled,
        $bootstrapPath,
        $isVerbose
    ) {
        $this->stopOnFailureEnabled  = $stopOnFailureEnabled;
        $this->codeGenerationEnabled = $codeGenerationEnabled;
        $this->reRunEnabled = $reRunEnabled;
        $this->fakingEnabled = $fakingEnabled;
        $this->bootstrapPath = $bootstrapPath;
        $this->isVerbose = $isVerbose;
    }

    /**
     * @return bool
     */
    public function isStopOnFailureEnabled(): bool
    {
        return $this->stopOnFailureEnabled;
    }

    /**
     * @return bool
     */
    public function isCodeGenerationEnabled(): bool
    {
        return $this->codeGenerationEnabled;
    }

    public function isReRunEnabled(): bool
    {
        return $this->reRunEnabled;
    }

    public function isFakingEnabled(): bool
    {
        return $this->fakingEnabled;
    }

    public function getBootstrapPath()
    {
        return $this->bootstrapPath;
    }

    public function isVerbose(): bool
    {
        return $this->isVerbose;
    }
}
