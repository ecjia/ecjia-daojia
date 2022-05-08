<?php

namespace PhpSpec\CodeGenerator\Generator;

use PhpSpec\Event\FileCreationEvent;
<<<<<<< HEAD
use PhpSpec\Locator\ResourceInterface;
use PhpSpec\Util\Filesystem;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class NewFileNotifyingGenerator implements GeneratorInterface
{
    /**
     * @var GeneratorInterface
=======
use PhpSpec\Locator\Resource;
use PhpSpec\Util\DispatchTrait;
use PhpSpec\Util\Filesystem;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class NewFileNotifyingGenerator implements Generator
{
    use DispatchTrait;

    /**
     * @var Generator
>>>>>>> v2-test
     */
    private $generator;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
<<<<<<< HEAD
     * @param GeneratorInterface $generator
     * @param EventDispatcherInterface $dispatcher
     * @param Filesystem $filesystem
     */
    public function __construct(GeneratorInterface $generator, EventDispatcherInterface $dispatcher, Filesystem $filesystem = null)
    {
        $this->generator = $generator;
        $this->dispatcher = $dispatcher;
        $this->filesystem = $filesystem ?: new Filesystem();
    }

    /**
     * @param ResourceInterface $resource
     * @param string $generation
     * @param array $data
     *
     * @return bool
     */
    public function supports(ResourceInterface $resource, $generation, array $data)
=======
     * @param Generator $generator
     * @param EventDispatcherInterface $dispatcher
     * @param Filesystem $filesystem
     */
    public function __construct(Generator $generator, EventDispatcherInterface $dispatcher, Filesystem $filesystem)
    {
        $this->generator = $generator;
        $this->dispatcher = $dispatcher;
        $this->filesystem = $filesystem;
    }

    public function supports(Resource $resource, string $generation, array $data): bool
>>>>>>> v2-test
    {
        return $this->generator->supports($resource, $generation, $data);
    }

<<<<<<< HEAD
    /**
     * @param ResourceInterface $resource
     * @param array $data
     */
    public function generate(ResourceInterface $resource, array $data)
=======
    public function generate(Resource $resource, array $data): void
>>>>>>> v2-test
    {
        $filePath = $this->getFilePath($resource);

        $fileExisted = $this->fileExists($filePath);

        $this->generator->generate($resource, $data);

        $this->dispatchEventIfFileWasCreated($fileExisted, $filePath);
    }

<<<<<<< HEAD
    /**
     * @return int
     */
    public function getPriority()
=======
    public function getPriority(): int
>>>>>>> v2-test
    {
        return $this->generator->getPriority();
    }

<<<<<<< HEAD
    /**
     * @param ResourceInterface $resource
     * @return string
     */
    private function getFilePath(ResourceInterface $resource)
=======
    private function getFilePath(Resource $resource): string
>>>>>>> v2-test
    {
        if ($this->generator->supports($resource, 'specification', array())) {
            return $resource->getSpecFilename();
        }

        return $resource->getSrcFilename();
    }

<<<<<<< HEAD
    /**
     * @param string $filePath
     * @return bool
     */
    private function fileExists($filePath)
=======
    private function fileExists(string $filePath): bool
>>>>>>> v2-test
    {
        return $this->filesystem->pathExists($filePath);
    }

<<<<<<< HEAD
    /**
     * @param bool $fileExisted
     * @param string $filePath
     */
    private function dispatchEventIfFileWasCreated($fileExisted, $filePath)
    {
        if (!$fileExisted && $this->fileExists($filePath)) {
            $event = new FileCreationEvent($filePath);
            $this->dispatcher->dispatch('afterFileCreation', $event);
=======
    private function dispatchEventIfFileWasCreated(bool $fileExisted, string $filePath): void
    {
        if (!$fileExisted && $this->fileExists($filePath)) {
            $event = new FileCreationEvent($filePath);
            $this->dispatch($this->dispatcher, $event, 'afterFileCreation');
>>>>>>> v2-test
        }
    }
}
