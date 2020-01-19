<?php

declare(strict_types=1);

namespace Tractors;

use Psr\Container\ContainerInterface;
use Tractors\Handler\CreateTractorHandler;

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

        $app->post('/api/tractors[/]', CreateTractorHandler::class, 'tractors.create');
        $app->get('/api/tractors/{id:\d+}', ReadTractorHandler::class, 'tractors.read');

        return $app;
    }
}
