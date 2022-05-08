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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

/**
 * JSON descriptor.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 *
 * @internal
 */
class JsonDescriptor extends Descriptor
{
    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function describeInputArgument(InputArgument $argument, array $options = array())
=======
    protected function describeInputArgument(InputArgument $argument, array $options = [])
>>>>>>> v2-test
    {
        $this->writeData($this->getInputArgumentData($argument), $options);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function describeInputOption(InputOption $option, array $options = array())
=======
    protected function describeInputOption(InputOption $option, array $options = [])
>>>>>>> v2-test
    {
        $this->writeData($this->getInputOptionData($option), $options);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function describeInputDefinition(InputDefinition $definition, array $options = array())
=======
    protected function describeInputDefinition(InputDefinition $definition, array $options = [])
>>>>>>> v2-test
    {
        $this->writeData($this->getInputDefinitionData($definition), $options);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function describeCommand(Command $command, array $options = array())
=======
    protected function describeCommand(Command $command, array $options = [])
>>>>>>> v2-test
    {
        $this->writeData($this->getCommandData($command), $options);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function describeApplication(Application $application, array $options = array())
    {
        $describedNamespace = isset($options['namespace']) ? $options['namespace'] : null;
        $description = new ApplicationDescription($application, $describedNamespace, true);
        $commands = array();
=======
    protected function describeApplication(Application $application, array $options = [])
    {
        $describedNamespace = $options['namespace'] ?? null;
        $description = new ApplicationDescription($application, $describedNamespace, true);
        $commands = [];
>>>>>>> v2-test

        foreach ($description->getCommands() as $command) {
            $commands[] = $this->getCommandData($command);
        }

<<<<<<< HEAD
        $data = array();
=======
        $data = [];
>>>>>>> v2-test
        if ('UNKNOWN' !== $application->getName()) {
            $data['application']['name'] = $application->getName();
            if ('UNKNOWN' !== $application->getVersion()) {
                $data['application']['version'] = $application->getVersion();
            }
        }

        $data['commands'] = $commands;

        if ($describedNamespace) {
            $data['namespace'] = $describedNamespace;
        } else {
            $data['namespaces'] = array_values($description->getNamespaces());
        }

        $this->writeData($data, $options);
    }

    /**
     * Writes data as json.
<<<<<<< HEAD
     *
     * @return array|string
     */
    private function writeData(array $data, array $options)
    {
        $this->write(json_encode($data, isset($options['json_encoding']) ? $options['json_encoding'] : 0));
    }

    /**
     * @return array
     */
    private function getInputArgumentData(InputArgument $argument)
    {
        return array(
=======
     */
    private function writeData(array $data, array $options)
    {
        $flags = $options['json_encoding'] ?? 0;

        $this->write(json_encode($data, $flags));
    }

    private function getInputArgumentData(InputArgument $argument): array
    {
        return [
>>>>>>> v2-test
            'name' => $argument->getName(),
            'is_required' => $argument->isRequired(),
            'is_array' => $argument->isArray(),
            'description' => preg_replace('/\s*[\r\n]\s*/', ' ', $argument->getDescription()),
<<<<<<< HEAD
            'default' => INF === $argument->getDefault() ? 'INF' : $argument->getDefault(),
        );
    }

    /**
     * @return array
     */
    private function getInputOptionData(InputOption $option)
    {
        return array(
=======
            'default' => \INF === $argument->getDefault() ? 'INF' : $argument->getDefault(),
        ];
    }

    private function getInputOptionData(InputOption $option): array
    {
        return [
>>>>>>> v2-test
            'name' => '--'.$option->getName(),
            'shortcut' => $option->getShortcut() ? '-'.str_replace('|', '|-', $option->getShortcut()) : '',
            'accept_value' => $option->acceptValue(),
            'is_value_required' => $option->isValueRequired(),
            'is_multiple' => $option->isArray(),
            'description' => preg_replace('/\s*[\r\n]\s*/', ' ', $option->getDescription()),
<<<<<<< HEAD
            'default' => INF === $option->getDefault() ? 'INF' : $option->getDefault(),
        );
    }

    /**
     * @return array
     */
    private function getInputDefinitionData(InputDefinition $definition)
    {
        $inputArguments = array();
=======
            'default' => \INF === $option->getDefault() ? 'INF' : $option->getDefault(),
        ];
    }

    private function getInputDefinitionData(InputDefinition $definition): array
    {
        $inputArguments = [];
>>>>>>> v2-test
        foreach ($definition->getArguments() as $name => $argument) {
            $inputArguments[$name] = $this->getInputArgumentData($argument);
        }

<<<<<<< HEAD
        $inputOptions = array();
=======
        $inputOptions = [];
>>>>>>> v2-test
        foreach ($definition->getOptions() as $name => $option) {
            $inputOptions[$name] = $this->getInputOptionData($option);
        }

<<<<<<< HEAD
        return array('arguments' => $inputArguments, 'options' => $inputOptions);
    }

    /**
     * @return array
     */
    private function getCommandData(Command $command)
    {
        $command->getSynopsis();
        $command->mergeApplicationDefinition(false);

        return array(
            'name' => $command->getName(),
            'usage' => array_merge(array($command->getSynopsis()), $command->getUsages(), $command->getAliases()),
            'description' => $command->getDescription(),
            'help' => $command->getProcessedHelp(),
            'definition' => $this->getInputDefinitionData($command->getNativeDefinition()),
            'hidden' => $command->isHidden(),
        );
=======
        return ['arguments' => $inputArguments, 'options' => $inputOptions];
    }

    private function getCommandData(Command $command): array
    {
        $command->mergeApplicationDefinition(false);

        return [
            'name' => $command->getName(),
            'usage' => array_merge([$command->getSynopsis()], $command->getUsages(), $command->getAliases()),
            'description' => $command->getDescription(),
            'help' => $command->getProcessedHelp(),
            'definition' => $this->getInputDefinitionData($command->getDefinition()),
            'hidden' => $command->isHidden(),
        ];
>>>>>>> v2-test
    }
}
