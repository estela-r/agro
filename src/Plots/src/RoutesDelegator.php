<?php

declare(strict_types=1);

namespace Plots;

use Plots\Handler\PlotsCreateHandler;
use Plots\Handler\PlotsReadHandler;
use Plots\Handler\PlotsReadHandlerFactory;
use Psr\Container\ContainerInterface;

class RoutesDelegator
{
    /**
     * @param ContainerInterface $container
     * @param string $serviceName Name of the service being created.
     * @param callable $callback Creates and returns the service.
     * @return Application
     */
    public function __invoke(ContainerInterface $container, $serviceName, callable $callback)
    {
        /** @var $app Application */
        $app = $callback();

        $app->post('/plots[/]', PlotsCreateHandler::class, 'plots.create');
        // $app->get('/plots[/]', PlotsListHandler::class, 'plots.list');
        $app->get('/plots/{id:\d+}', PlotsReadHandler::class, 'plots.read');

        return $app;
    }
}
