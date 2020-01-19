<?php

declare(strict_types=1);

namespace Tillage\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Tillage\Validator\TillageInputFilter;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class CreateTillageHandlerFactory
{
    public function __invoke(ContainerInterface $container) : CreateTillageHandler
    {
        $filters = $container->get('InputFilterManager');
        
        return new CreateTillageHandler(
            $container->get(EntityManager::class),
            $filters->get(TillageInputFilter::class),
            $container->get(HalResponseFactory::class),
            $container->get(ResourceGenerator::class)
        );
    }
}
