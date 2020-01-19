<?php

declare(strict_types=1);

namespace Tractors\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Tractors\Validator\TractorInputFilter;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class CreateTractorHandlerFactory
{
    public function __invoke(ContainerInterface $container) : CreateTractorHandler
    {
        $filters = $container->get('InputFilterManager');
        
        return new CreateTractorHandler(
            $container->get(EntityManager::class),
            $filters->get(TractorInputFilter::class),
            $container->get(HalResponseFactory::class),
            $container->get(ResourceGenerator::class)
        );
    }
}
