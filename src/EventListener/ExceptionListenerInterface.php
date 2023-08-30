<?php

namespace Slutsky\Library\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;

interface ExceptionListenerInterface
{
    public function onException(ExceptionEvent $event): void;
}
