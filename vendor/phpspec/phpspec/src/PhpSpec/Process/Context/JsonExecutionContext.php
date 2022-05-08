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

namespace PhpSpec\Process\Context;

<<<<<<< HEAD
final class JsonExecutionContext implements ExecutionContextInterface
=======
final class JsonExecutionContext implements ExecutionContext
>>>>>>> v2-test
{
    const ENV_NAME = 'PHPSPEC_EXECUTION_CONTEXT';
    /**
     * @var array
     */
    private $generatedTypes;

    /**
     * @param array $env
     *
     * @return JsonExecutionContext
     */
<<<<<<< HEAD
    public static function fromEnv($env)
=======
    public static function fromEnv(array $env): JsonExecutionContext
>>>>>>> v2-test
    {
        $executionContext = new JsonExecutionContext();

        if (array_key_exists(self::ENV_NAME, $env)) {
            $serialized = json_decode($env[self::ENV_NAME], true);
            $executionContext->generatedTypes = $serialized['generated-types'];
        }
        else {
            $executionContext->generatedTypes = array();
        }

        return $executionContext;
    }

    /**
     * @param string $generatedType
     */
<<<<<<< HEAD
    public function addGeneratedType($generatedType)
=======
    public function addGeneratedType(string $generatedType)
>>>>>>> v2-test
    {
        $this->generatedTypes[] = $generatedType;
    }

    /**
     * @return array
     */
<<<<<<< HEAD
    public function getGeneratedTypes()
=======
    public function getGeneratedTypes(): array
>>>>>>> v2-test
    {
        return $this->generatedTypes;
    }

    /**
<<<<<<< HEAD
     * @return string
     */
    public function asEnv()
=======
     * @return array
     */
    public function asEnv(): array
>>>>>>> v2-test
    {
        return array(
            self::ENV_NAME => json_encode(
                array(
                    'generated-types' => $this->generatedTypes
                )
            )
        );
    }
}
