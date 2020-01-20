<?php

declare(strict_types=1);

namespace Tillage\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;


class ListTillageHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ListTillageHandler
    {
        
        return new ListTillageHandler($container->get(EntityManager::class));
    }
}
