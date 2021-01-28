<?php


namespace Royalcms\Component\Log;


use Illuminate\Log\ParsesLogConfiguration;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger as Monolog;
use Royalcms\Component\Contracts\Foundation\Royalcms;

class CreateCustomLogger
{
    use ParsesLogConfiguration;

    protected $loggers = array();

    /**
     * The standard date format to use when writing logs.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * The application instance.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * Create a new Log manager instance.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function __construct(Royalcms $royalcms)
    {
        $this->royalcms = $royalcms;
    }

    /**
     * 创建一个 Monolog 实例.
     * @param array $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        return $this->getLogger();
    }

    /**
     * 获取一个实例
     * @param string $type
     * @param number $day
     * @return Object
     */
    public function getLogger($type = 'royalcms', $day = 30)
    {
        $path = storage_path("logs/{$type}.log");

        if (empty($this->loggers[$type])) {
            $config               = [
                'driver'     => 'daily',
                'path'       => $path,
                'level'      => 'debug',
                'days'       => 30,
                'bubble'     => true,
                'permission' => null,
                'locking'    => false,
            ];
            $this->loggers[$type] = $this->createDailyDriver($config);
        }

        return $this->loggers[$type];
    }


    /**
     * Create an instance of the daily file log driver.
     * @param array $config
     * @return \Psr\Log\LoggerInterface
     */
    protected function createDailyDriver(array $config)
    {
        return new Monolog($this->parseChannel($config), [
            $this->prepareHandler(
                new RotatingFileHandler(
                    $config['path'],
                    $config['days'] ?? 7,
                    $this->level($config),
                    $config['bubble'] ?? true,
                    $config['permission'] ?? null,
                    $config['locking'] ?? false
                ),
                $config
            )
        ]);
    }

    /**
     * Prepare the handler for usage by Monolog.
     *
     * @param  \Monolog\Handler\HandlerInterface  $handler
     * @param  array  $config
     * @return \Monolog\Handler\HandlerInterface
     */
    protected function prepareHandler(HandlerInterface $handler, array $config = [])
    {
        if (! isset($config['formatter'])) {
            $handler->setFormatter($this->formatter());
        } elseif ($config['formatter'] !== 'default') {
            $handler->setFormatter($this->royalcms->make($config['formatter'], $config['formatter_with'] ?? []));
        }

        return $handler;
    }

    /**
     * Get a Monolog formatter instance.
     *
     * @return \Monolog\Formatter\FormatterInterface
     */
    protected function formatter()
    {
        return tap(new LineFormatter(null, $this->dateFormat, true, true), function ($formatter) {
            $formatter->includeStacktraces();
        });
    }

    /**
     * Get fallback log channel name.
     *
     * @return string
     */
    protected function getFallbackChannelName()
    {
        return $this->royalcms->bound('env') ? $this->royalcms->environment() : 'production';
    }

}