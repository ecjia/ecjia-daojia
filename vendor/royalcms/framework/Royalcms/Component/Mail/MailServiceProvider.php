<?php

namespace Royalcms\Component\Mail;

use Swift_Mailer;
use Royalcms\Component\Support\Arr;
use Royalcms\Component\Support\Str;
use Royalcms\Component\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        \RC_Hook::do_action('mail_init');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSwiftMailer();

        $this->registerRoyalcmsMailer();

        $this->registerMarkdownRenderer();
    }

    /**
     * Register the Royalcms mailer instance.
     *
     * @return void
     */
    protected function registerRoyalcmsMailer()
    {
        $this->royalcms->singleton('mailer', function ($royalcms) {
            $config = $royalcms->make('config')->get('mail');

            // Once we have create the mailer instance, we will set a container instance
            // on the mailer. This allows us to resolve mailer classes via containers
            // for maximum testability on said classes instead of passing Closures.
            $mailer = new Mailer(
                $royalcms['view'], $royalcms['swift.mailer'], $royalcms['events']
            );

            if ($royalcms->bound('queue')) {
                $mailer->setQueue($royalcms['queue']);
            }

            // Next we will set all of the global addresses on this mailer, which allows
            // for easy unification of all "from" addresses as well as easy debugging
            // of sent messages since they get be sent into a single email address.
            foreach (['from', 'reply_to', 'to'] as $type) {
                $this->setGlobalAddress($mailer, $config, $type);
            }

            return $mailer;
        });
    }

    /**
     * Set a global address on the mailer by type.
     *
     * @param  \Royalcms\Component\Mail\Mailer  $mailer
     * @param  array  $config
     * @param  string  $type
     * @return void
     */
    protected function setGlobalAddress($mailer, array $config, $type)
    {
        $address = Arr::get($config, $type);

        if (is_array($address) && isset($address['address'])) {
            $mailer->{'always'.Str::studly($type)}($address['address'], $address['name']);
        }
    }

    /**
     * Register the Swift Mailer instance.
     *
     * @return void
     */
    public function registerSwiftMailer()
    {
        $this->registerSwiftTransport();

        // Once we have the transporter registered, we will register the actual Swift
        // mailer instance, passing in the transport instances, which allows us to
        // override this transporter instances during app start-up if necessary.
        $this->royalcms->singleton('swift.mailer', function ($royalcms) {
            return new Swift_Mailer($royalcms['swift.transport']->driver());
        });
    }

    /**
     * Register the Swift Transport instance.
     *
     * @return void
     */
    protected function registerSwiftTransport()
    {
        $this->royalcms->singleton('swift.transport', function ($royalcms) {
            return new TransportManager($royalcms);
        });
    }

    /**
     * Register the Markdown renderer instance.
     *
     * @return void
     */
    protected function registerMarkdownRenderer()
    {
        if ($this->royalcms->runningInConsole()) {
            $this->publishes([
                __DIR__.'/resources/views' => $this->royalcms->resourcePath('views/vendor/mail'),
            ], 'mail');
        }

        $this->royalcms->singleton(Markdown::class, function ($royalcms) {
            $config = $royalcms->make('config');

            return new Markdown($royalcms->make('view'), [
                'theme' => $config->get('mail.markdown.theme', 'default'),
                'paths' => $config->get('mail.markdown.paths', []),
            ]);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'mailer', 'swift.mailer', 'swift.transport', Markdown::class,
        ];
    }
}
