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
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Markdown descriptor.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 *
 * @internal
 */
class MarkdownDescriptor extends Descriptor
{
    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function describe(OutputInterface $output, $object, array $options = array())
=======
    public function describe(OutputInterface $output, $object, array $options = [])
>>>>>>> v2-test
    {
        $decorated = $output->isDecorated();
        $output->setDecorated(false);

        parent::describe($output, $object, $options);

        $output->setDecorated($decorated);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function write($content, $decorated = true)
=======
    protected function write(string $content, bool $decorated = true)
>>>>>>> v2-test
    {
        parent::write($content, $decorated);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function describeInputArgument(InputArgument $argument, array $options = array())
=======
    protected function describeInputArgument(InputArgument $argument, array $options = [])
>>>>>>> v2-test
    {
        $this->write(
            '#### `'.($argument->getName() ?: '<none>')."`\n\n"
            .($argument->getDescription() ? preg_replace('/\s*[\r\n]\s*/', "\n", $argument->getDescription())."\n\n" : '')
            .'* Is required: '.($argument->isRequired() ? 'yes' : 'no')."\n"
            .'* Is array: '.($argument->isArray() ? 'yes' : 'no')."\n"
            .'* Default: `'.str_replace("\n", '', var_export($argument->getDefault(), true)).'`'
        );
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
        $name = '--'.$option->getName();
        if ($option->getShortcut()) {
            $name .= '|-'.str_replace('|', '|-', $option->getShortcut()).'';
        }

        $this->write(
            '#### `'.$name.'`'."\n\n"
            .($option->getDescription() ? preg_replace('/\s*[\r\n]\s*/', "\n", $option->getDescription())."\n\n" : '')
            .'* Accept value: '.($option->acceptValue() ? 'yes' : 'no')."\n"
            .'* Is value required: '.($option->isValueRequired() ? 'yes' : 'no')."\n"
            .'* Is multiple: '.($option->isArray() ? 'yes' : 'no')."\n"
            .'* Default: `'.str_replace("\n", '', var_export($option->getDefault(), true)).'`'
        );
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
        if ($showArguments = \count($definition->getArguments()) > 0) {
            $this->write('### Arguments');
            foreach ($definition->getArguments() as $argument) {
                $this->write("\n\n");
<<<<<<< HEAD
                $this->write($this->describeInputArgument($argument));
=======
                if (null !== $describeInputArgument = $this->describeInputArgument($argument)) {
                    $this->write($describeInputArgument);
                }
>>>>>>> v2-test
            }
        }

        if (\count($definition->getOptions()) > 0) {
            if ($showArguments) {
                $this->write("\n\n");
            }

            $this->write('### Options');
            foreach ($definition->getOptions() as $option) {
                $this->write("\n\n");
<<<<<<< HEAD
                $this->write($this->describeInputOption($option));
=======
                if (null !== $describeInputOption = $this->describeInputOption($option)) {
                    $this->write($describeInputOption);
                }
>>>>>>> v2-test
            }
        }
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function describeCommand(Command $command, array $options = array())
    {
        $command->getSynopsis();
=======
    protected function describeCommand(Command $command, array $options = [])
    {
>>>>>>> v2-test
        $command->mergeApplicationDefinition(false);

        $this->write(
            '`'.$command->getName()."`\n"
            .str_repeat('-', Helper::strlen($command->getName()) + 2)."\n\n"
            .($command->getDescription() ? $command->getDescription()."\n\n" : '')
            .'### Usage'."\n\n"
<<<<<<< HEAD
            .array_reduce(array_merge(array($command->getSynopsis()), $command->getAliases(), $command->getUsages()), function ($carry, $usage) {
=======
            .array_reduce(array_merge([$command->getSynopsis()], $command->getAliases(), $command->getUsages()), function ($carry, $usage) {
>>>>>>> v2-test
                return $carry.'* `'.$usage.'`'."\n";
            })
        );

        if ($help = $command->getProcessedHelp()) {
            $this->write("\n");
            $this->write($help);
        }

<<<<<<< HEAD
        if ($command->getNativeDefinition()) {
            $this->write("\n\n");
            $this->describeInputDefinition($command->getNativeDefinition());
=======
        $definition = $command->getDefinition();
        if ($definition->getOptions() || $definition->getArguments()) {
            $this->write("\n\n");
            $this->describeInputDefinition($definition);
>>>>>>> v2-test
        }
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function describeApplication(Application $application, array $options = array())
    {
        $describedNamespace = isset($options['namespace']) ? $options['namespace'] : null;
=======
    protected function describeApplication(Application $application, array $options = [])
    {
        $describedNamespace = $options['namespace'] ?? null;
>>>>>>> v2-test
        $description = new ApplicationDescription($application, $describedNamespace);
        $title = $this->getApplicationTitle($application);

        $this->write($title."\n".str_repeat('=', Helper::strlen($title)));

        foreach ($description->getNamespaces() as $namespace) {
            if (ApplicationDescription::GLOBAL_NAMESPACE !== $namespace['id']) {
                $this->write("\n\n");
                $this->write('**'.$namespace['id'].':**');
            }

            $this->write("\n\n");
            $this->write(implode("\n", array_map(function ($commandName) use ($description) {
                return sprintf('* [`%s`](#%s)', $commandName, str_replace(':', '', $description->getCommand($commandName)->getName()));
            }, $namespace['commands'])));
        }

        foreach ($description->getCommands() as $command) {
            $this->write("\n\n");
<<<<<<< HEAD
            $this->write($this->describeCommand($command));
        }
    }

    private function getApplicationTitle(Application $application)
=======
            if (null !== $describeCommand = $this->describeCommand($command)) {
                $this->write($describeCommand);
            }
        }
    }

    private function getApplicationTitle(Application $application): string
>>>>>>> v2-test
    {
        if ('UNKNOWN' !== $application->getName()) {
            if ('UNKNOWN' !== $application->getVersion()) {
                return sprintf('%s %s', $application->getName(), $application->getVersion());
            }

            return $application->getName();
        }

        return 'Console Tool';
    }
}
