<?php

declare(strict_types=1);

namespace Tillage;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Tillage\Entity\Tillage;
use Tillage\Handler\CreateTillageHandler;
use Tillage\Handler\CreateTillageHandlerFactory;
use Tillage\Handler\ListTillageHandler;
use Tillage\Handler\ListTillageHandlerFactory;
use Zend\Expressive\Application;
use Zend\Expressive\Hal\Metadata\MetadataMap;
use Zend\Expressive\Hal\Metadata\RouteBasedResourceMetadata;
use Zend\Hydrator\ReflectionHydrator;

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
                CreateTillageHandler::class => CreateTillageHandlerFactory::class,
                ListTillageHandler::class => ListTillageHandlerFactory::class
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
                        'Tillage\Entity' => 'tillage_entity',
                    ],
                ],
                'tillage_entity' => [
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
                'resource_class' => Tillage::class,
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
