<?php

declare(strict_types=1);

namespace Plots\Handler;

use Psr\Container\ContainerInterface;

class PlotsReadHandlerFactory
{
    public function __invoke(ContainerInterface $container) : PlotsReadHandler
    {
        return new PlotsReadHandler();
    }
}
