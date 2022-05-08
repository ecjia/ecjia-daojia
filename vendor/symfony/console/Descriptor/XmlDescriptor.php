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
 * XML descriptor.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 *
 * @internal
 */
class XmlDescriptor extends Descriptor
{
<<<<<<< HEAD
    /**
     * @return \DOMDocument
     */
    public function getInputDefinitionDocument(InputDefinition $definition)
=======
    public function getInputDefinitionDocument(InputDefinition $definition): \DOMDocument
>>>>>>> v2-test
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->appendChild($definitionXML = $dom->createElement('definition'));

        $definitionXML->appendChild($argumentsXML = $dom->createElement('arguments'));
        foreach ($definition->getArguments() as $argument) {
            $this->appendDocument($argumentsXML, $this->getInputArgumentDocument($argument));
        }

        $definitionXML->appendChild($optionsXML = $dom->createElement('options'));
        foreach ($definition->getOptions() as $option) {
            $this->appendDocument($optionsXML, $this->getInputOptionDocument($option));
        }

        return $dom;
    }

<<<<<<< HEAD
    /**
     * @return \DOMDocument
     */
    public function getCommandDocument(Command $command)
=======
    public function getCommandDocument(Command $command): \DOMDocument
>>>>>>> v2-test
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->appendChild($commandXML = $dom->createElement('command'));

<<<<<<< HEAD
        $command->getSynopsis();
=======
>>>>>>> v2-test
        $command->mergeApplicationDefinition(false);

        $commandXML->setAttribute('id', $command->getName());
        $commandXML->setAttribute('name', $command->getName());
        $commandXML->setAttribute('hidden', $command->isHidden() ? 1 : 0);

        $commandXML->appendChild($usagesXML = $dom->createElement('usages'));

<<<<<<< HEAD
        foreach (array_merge(array($command->getSynopsis()), $command->getAliases(), $command->getUsages()) as $usage) {
=======
        foreach (array_merge([$command->getSynopsis()], $command->getAliases(), $command->getUsages()) as $usage) {
>>>>>>> v2-test
            $usagesXML->appendChild($dom->createElement('usage', $usage));
        }

        $commandXML->appendChild($descriptionXML = $dom->createElement('description'));
        $descriptionXML->appendChild($dom->createTextNode(str_replace("\n", "\n ", $command->getDescription())));

        $commandXML->appendChild($helpXML = $dom->createElement('help'));
        $helpXML->appendChild($dom->createTextNode(str_replace("\n", "\n ", $command->getProcessedHelp())));

<<<<<<< HEAD
        $definitionXML = $this->getInputDefinitionDocument($command->getNativeDefinition());
=======
        $definitionXML = $this->getInputDefinitionDocument($command->getDefinition());
>>>>>>> v2-test
        $this->appendDocument($commandXML, $definitionXML->getElementsByTagName('definition')->item(0));

        return $dom;
    }

<<<<<<< HEAD
    /**
     * @param Application $application
     * @param string|null $namespace
     *
     * @return \DOMDocument
     */
    public function getApplicationDocument(Application $application, $namespace = null)
=======
    public function getApplicationDocument(Application $application, string $namespace = null): \DOMDocument
>>>>>>> v2-test
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->appendChild($rootXml = $dom->createElement('symfony'));

        if ('UNKNOWN' !== $application->getName()) {
            $rootXml->setAttribute('name', $application->getName());
            if ('UNKNOWN' !== $application->getVersion()) {
                $rootXml->setAttribute('version', $application->getVersion());
            }
        }

        $rootXml->appendChild($commandsXML = $dom->createElement('commands'));

        $description = new ApplicationDescription($application, $namespace, true);

        if ($namespace) {
            $commandsXML->setAttribute('namespace', $namespace);
        }

        foreach ($description->getCommands() as $command) {
            $this->appendDocument($commandsXML, $this->getCommandDocument($command));
        }

        if (!$namespace) {
            $rootXml->appendChild($namespacesXML = $dom->createElement('namespaces'));

            foreach ($description->getNamespaces() as $namespaceDescription) {
                $namespacesXML->appendChild($namespaceArrayXML = $dom->createElement('namespace'));
                $namespaceArrayXML->setAttribute('id', $namespaceDescription['id']);

                foreach ($namespaceDescription['commands'] as $name) {
                    $namespaceArrayXML->appendChild($commandXML = $dom->createElement('command'));
                    $commandXML->appendChild($dom->createTextNode($name));
                }
            }
        }

        return $dom;
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
        $this->writeDocument($this->getInputArgumentDocument($argument));
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
        $this->writeDocument($this->getInputOptionDocument($option));
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
        $this->writeDocument($this->getInputDefinitionDocument($definition));
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
        $this->writeDocument($this->getCommandDocument($command));
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    protected function describeApplication(Application $application, array $options = array())
    {
        $this->writeDocument($this->getApplicationDocument($application, isset($options['namespace']) ? $options['namespace'] : null));
=======
    protected function describeApplication(Application $application, array $options = [])
    {
        $this->writeDocument($this->getApplicationDocument($application, $options['namespace'] ?? null));
>>>>>>> v2-test
    }

    /**
     * Appends document children to parent node.
     */
    private function appendDocument(\DOMNode $parentNode, \DOMNode $importedParent)
    {
        foreach ($importedParent->childNodes as $childNode) {
            $parentNode->appendChild($parentNode->ownerDocument->importNode($childNode, true));
        }
    }

    /**
     * Writes DOM document.
<<<<<<< HEAD
     *
     * @return \DOMDocument|string
=======
>>>>>>> v2-test
     */
    private function writeDocument(\DOMDocument $dom)
    {
        $dom->formatOutput = true;
        $this->write($dom->saveXML());
    }

<<<<<<< HEAD
    /**
     * @return \DOMDocument
     */
    private function getInputArgumentDocument(InputArgument $argument)
=======
    private function getInputArgumentDocument(InputArgument $argument): \DOMDocument
>>>>>>> v2-test
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');

        $dom->appendChild($objectXML = $dom->createElement('argument'));
        $objectXML->setAttribute('name', $argument->getName());
        $objectXML->setAttribute('is_required', $argument->isRequired() ? 1 : 0);
        $objectXML->setAttribute('is_array', $argument->isArray() ? 1 : 0);
        $objectXML->appendChild($descriptionXML = $dom->createElement('description'));
        $descriptionXML->appendChild($dom->createTextNode($argument->getDescription()));

        $objectXML->appendChild($defaultsXML = $dom->createElement('defaults'));
<<<<<<< HEAD
        $defaults = \is_array($argument->getDefault()) ? $argument->getDefault() : (\is_bool($argument->getDefault()) ? array(var_export($argument->getDefault(), true)) : ($argument->getDefault() ? array($argument->getDefault()) : array()));
=======
        $defaults = \is_array($argument->getDefault()) ? $argument->getDefault() : (\is_bool($argument->getDefault()) ? [var_export($argument->getDefault(), true)] : ($argument->getDefault() ? [$argument->getDefault()] : []));
>>>>>>> v2-test
        foreach ($defaults as $default) {
            $defaultsXML->appendChild($defaultXML = $dom->createElement('default'));
            $defaultXML->appendChild($dom->createTextNode($default));
        }

        return $dom;
    }

<<<<<<< HEAD
    /**
     * @return \DOMDocument
     */
    private function getInputOptionDocument(InputOption $option)
=======
    private function getInputOptionDocument(InputOption $option): \DOMDocument
>>>>>>> v2-test
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');

        $dom->appendChild($objectXML = $dom->createElement('option'));
        $objectXML->setAttribute('name', '--'.$option->getName());
        $pos = strpos($option->getShortcut(), '|');
        if (false !== $pos) {
            $objectXML->setAttribute('shortcut', '-'.substr($option->getShortcut(), 0, $pos));
            $objectXML->setAttribute('shortcuts', '-'.str_replace('|', '|-', $option->getShortcut()));
        } else {
            $objectXML->setAttribute('shortcut', $option->getShortcut() ? '-'.$option->getShortcut() : '');
        }
        $objectXML->setAttribute('accept_value', $option->acceptValue() ? 1 : 0);
        $objectXML->setAttribute('is_value_required', $option->isValueRequired() ? 1 : 0);
        $objectXML->setAttribute('is_multiple', $option->isArray() ? 1 : 0);
        $objectXML->appendChild($descriptionXML = $dom->createElement('description'));
        $descriptionXML->appendChild($dom->createTextNode($option->getDescription()));

        if ($option->acceptValue()) {
<<<<<<< HEAD
            $defaults = \is_array($option->getDefault()) ? $option->getDefault() : (\is_bool($option->getDefault()) ? array(var_export($option->getDefault(), true)) : ($option->getDefault() ? array($option->getDefault()) : array()));
=======
            $defaults = \is_array($option->getDefault()) ? $option->getDefault() : (\is_bool($option->getDefault()) ? [var_export($option->getDefault(), true)] : ($option->getDefault() ? [$option->getDefault()] : []));
>>>>>>> v2-test
            $objectXML->appendChild($defaultsXML = $dom->createElement('defaults'));

            if (!empty($defaults)) {
                foreach ($defaults as $default) {
                    $defaultsXML->appendChild($defaultXML = $dom->createElement('default'));
                    $defaultXML->appendChild($dom->createTextNode($default));
                }
            }
        }

        return $dom;
    }
}
