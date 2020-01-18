<?php

declare(strict_types=1);

namespace Plots\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class PlotsReadHandlerFactory
{
    public function __invoke(ContainerInterface $container) : PlotsReadHandler
    {
        $entityManager = $container->get(EntityManager::class);

        return new PlotsReadHandler($entityManager);
    }
}
