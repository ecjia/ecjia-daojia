<?php


namespace Royalcms\Component\Mail;


use ReflectionClass;
use ReflectionMethod;

class MailManager extends \Illuminate\Mail\MailManager
{

    /**
     * Will create the instances.
     *
     * @royalcms 6.0.0
     * @param $driver
     */
    public function resetDriver($driver)
    {
        // If the given driver has not been created before, we will create the instances
        // here and cache it so we can return it next time very quickly. If there is
        // already a driver created by this name, we'll just return that instance.
        if (isset($this->mailers[$driver])) {
            unset($this->mailers[$driver]);
            $this->mailers[$driver] = $this->resolve($driver);
        }
    }

    /**
     * Custom config with new mailer instances.
     *
     * @royalcms 8.1.0
     * @param array $config
     * @return \Illuminate\Mail\Mailer
     */
    public function custom(array $config)
    {
        $mailer = new \Illuminate\Mail\Mailer(
            'smtp',
            royalcms('view'),
            $this->createSwiftMailer($config),
            royalcms('events')
        );

        return $mailer;
    }

    /**
     * Mix another object into the class.
     *
     * @royalcms 6.0.0
     * @param  object  $mixin
     * @param  bool  $replace
     * @return void
     *
     * @throws \ReflectionException
     */
    public function mixin($mixin, $replace = true)
    {
        $methods = (new ReflectionClass($mixin))->getMethods(
            ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED
        );

        foreach ($methods as $method) {
            if ($replace || ! isset($this->customCreators[$method->name])) {
                $method->setAccessible(true);
                $this->extend($method->name, $method->invoke($mixin));
            }
        }
    }


}