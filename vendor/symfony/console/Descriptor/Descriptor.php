<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Descriptor;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 *
 * @internal
 */
abstract class Descriptor implements DescriptorInterface
{
    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function describe(OutputInterface $output, $object, array $options = array())
=======
    public function describe(OutputInterface $output, $object, array $options = [])
>>>>>>> v2-test
    {
        $this->output = $output;

        switch (true) {
            case $object instanceof InputArgument:
                $this->describeInputArgument($object, $options);
                break;
            case $object instanceof InputOption:
                $this->describeInputOption($object, $options);
                break;
            case $object instanceof InputDefinition:
                $this->describeInputDefinition($object, $options);
                break;
            case $object instanceof Command:
                $this->describeCommand($object, $options);
                break;
            case $object instanceof Application:
                $this->describeApplication($object, $options);
                break;
            default:
<<<<<<< HEAD
                throw new InvalidArgumentException(sprintf('Object of type "%s" is not describable.', \get_class($object)));
=======
                throw new InvalidArgumentException(sprintf('Object of type "%s" is not describable.', get_debug_type($object)));
>>>>>>> v2-test
        }
    }

    /**
     * Writes content to output.
<<<<<<< HEAD
     *
     * @param string $content
     * @param bool   $decorated
     */
    protected function write($content, $decorated = false)
=======
     */
    protected function write(string $content, bool $decorated = false)
>>>>>>> v2-test
    {
        $this->output->write($content, false, $decorated ? OutputInterface::OUTPUT_NORMAL : OutputInterface::OUTPUT_RAW);
    }

    /**
     * Describes an InputArgument instance.
     *
     * @return string|mixed
     */
<<<<<<< HEAD
    abstract protected function describeInputArgument(InputArgument $argument, array $options = array());
=======
    abstract protected function describeInputArgument(InputArgument $argument, array $options = []);
>>>>>>> v2-test

    /**
     * Describes an InputOption instance.
     *
     * @return string|mixed
     */
<<<<<<< HEAD
    abstract protected function describeInputOption(InputOption $option, array $options = array());
=======
    abstract protected function describeInputOption(InputOption $option, array $options = []);
>>>>>>> v2-test

    /**
     * Describes an InputDefinition instance.
     *
     * @return string|mixed
     */
<<<<<<< HEAD
    abstract protected function describeInputDefinition(InputDefinition $definition, array $options = array());
=======
    abstract protected function describeInputDefinition(InputDefinition $definition, array $options = []);
>>>>>>> v2-test

    /**
     * Describes a Command instance.
     *
     * @return string|mixed
     */
<<<<<<< HEAD
    abstract protected function describeCommand(Command $command, array $options = array());
=======
    abstract protected function describeCommand(Command $command, array $options = []);
>>>>>>> v2-test

    /**
     * Describes an Application instance.
     *
     * @return string|mixed
     */
<<<<<<< HEAD
    abstract protected function describeApplication(Application $application, array $options = array());
=======
    abstract protected function describeApplication(Application $application, array $options = []);
>>>>>>> v2-test
}
