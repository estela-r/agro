<?php

declare(strict_types=1);

namespace Plots\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class PlotsReadHandlerFactory
{
    public function __invoke(ContainerInterface $container) : PlotsReadHandler
    {

        return new PlotsReadHandler(
            $container->get(EntityManager::class),
            $container->get(HalResponseFactory::class),
            $container->get(ResourceGenerator::class)
        );
    }
}
