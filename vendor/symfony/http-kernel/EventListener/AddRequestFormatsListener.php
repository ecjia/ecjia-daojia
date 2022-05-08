<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
<<<<<<< HEAD
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
=======
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
>>>>>>> v2-test

/**
 * Adds configured formats to each request.
 *
 * @author Gildas Quemener <gildas.quemener@gmail.com>
<<<<<<< HEAD
 */
class AddRequestFormatsListener implements EventSubscriberInterface
{
    /**
     * @var array
     */
    protected $formats;

    /**
     * @param array $formats
     */
=======
 *
 * @final
 */
class AddRequestFormatsListener implements EventSubscriberInterface
{
    protected $formats;

>>>>>>> v2-test
    public function __construct(array $formats)
    {
        $this->formats = $formats;
    }

    /**
     * Adds request formats.
<<<<<<< HEAD
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        foreach ($this->formats as $format => $mimeTypes) {
            $event->getRequest()->setFormat($format, $mimeTypes);
=======
     */
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        foreach ($this->formats as $format => $mimeTypes) {
            $request->setFormat($format, $mimeTypes);
>>>>>>> v2-test
        }
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public static function getSubscribedEvents()
    {
        return array(KernelEvents::REQUEST => 'onKernelRequest');
=======
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::REQUEST => ['onKernelRequest', 100]];
>>>>>>> v2-test
    }
}
