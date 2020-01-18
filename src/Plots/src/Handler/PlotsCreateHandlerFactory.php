<?php

declare(strict_types=1);

namespace Plots\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class PlotsCreateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : PlotsCreateHandler
    {

        return new PlotsCreateHandler(
            $container->get(EntityManager::class),
            $container->get(HalResponseFactory::class),
            $container->get(ResourceGenerator::class)
        );
    }
}
