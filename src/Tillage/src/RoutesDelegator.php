<?php

declare(strict_types=1);

namespace Tillage;

use Psr\Container\ContainerInterface;
use Tillage\Handler\CreateTillageHandler;
use Tillage\Handler\ListTillageHandler;

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

        $app->post('/api/tillage[/]', CreateTillageHandler::class, 'tillage.create');
        $app->get('/api/tillage[/]', ListTillageHandler::class, 'tillage.list');

        return $app;
    }
}
