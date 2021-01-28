<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @method static int handle(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface|null $output = null)
 * @method static int call(string $command, array $parameters = [], \Symfony\Component\Console\Output\OutputInterface|null $outputBuffer = null)
 * @method static \Illuminate\Foundation\Bus\PendingDispatch queue(string $command, array $parameters = [])
 * @method static array all()
 * @method static string output()
 * @method static void terminate(\Symfony\Component\Console\Input\InputInterface $input, int $status)
 * @method static \Illuminate\Foundation\Console\ClosureCommand command(string $command, callable $callback)
 * 
 * @see \Royalcms\Component\Contracts\Console\Kernel
 */
class Artisan extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Royalcms\Component\Contracts\Console\Kernel';
    }
}
