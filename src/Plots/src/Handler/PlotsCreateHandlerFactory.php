<?php

declare(strict_types=1);

namespace Plots\Handler;

use Doctrine\ORM\EntityManager;
use Plots\Validator\PlotInputFilter;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class PlotsCreateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : PlotsCreateHandler
    {
        $filters = $container->get('InputFilterManager');
        
        return new PlotsCreateHandler(
            $container->get(EntityManager::class),
            $filters->get(PlotInputFilter::class),
            $container->get(HalResponseFactory::class),
            $container->get(ResourceGenerator::class)
        );
    }
}
