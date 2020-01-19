<?php

declare(strict_types=1);

namespace Tractors;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Tractors\Entity\Tractor;
use Tractors\Handler\CreateTractorHandler;
use Tractors\Handler\CreateTractorHandlerFactory;
use Zend\Expressive\Application;
use Zend\Expressive\Hal\Metadata\MetadataMap;
use Zend\Expressive\Hal\Metadata\RouteBasedResourceMetadata;
use Zend\Hydrator\ReflectionHydrator;

/**
 * The configuration provider for the Plots module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates' => $this->getTemplates(),
            'doctrine' => $this->getDoctrineEntities(),  
            MetadataMap::class => $this->getHalMetadataMap(),                      
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'delegators' => [ 
                Application::class => [
                    RoutesDelegator::class
                ]
            ],
            'invokables' => [
            ],
            'factories'  => [
                CreateTractorHandler::class => CreateTractorHandlerFactory::class
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'plots'    => [__DIR__ . '/../templates/'],
            ],
        ];
    }

    public function getDoctrineEntities() : array
    {
        return [
            'driver' => [
                'orm_default' => [
                    'class' => MappingDriverChain::class,
                    'drivers' => [
                        'Tractors\Entity' => 'tractor_entity',
                    ],
                ],
                'tractor_entity' => [
                    'class' => AnnotationDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity'],
                ],
            ],
        ];
    }

    public function getHalMetadataMap()
    {
        return [
            [
                '__class__' => RouteBasedResourceMetadata::class,
                'resource_class' => Tractor::class,
                'route' => 'tractors.read',
                'extractor' => ReflectionHydrator::class,
            ],
            // [
            //     '__class__' => RouteBasedCollectionMetadata::class,
            //     'collection_class' => PlotCollection::class,
            //     'collection_relation' => 'plot',
            //     'route' => 'plots.list',
            // ],
        ];
    }    

}
