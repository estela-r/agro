<?php

declare(strict_types=1);

namespace Plots\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Plots\Entity\Plot;
use Plots\Validator\PlotInputFilter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class PlotsCreateHandler implements RequestHandlerInterface
{
    private $entityManager;
    private $halResponseFactory;
    private $resourceGenerator;
    private $inputFilter;

    public function __construct(
        EntityManagerInterface $entityManager,
        PlotInputFilter $inputFilter,
        HalResponseFactory $halResponseFactory,
        ResourceGenerator $resourceGenerator)
    {
        $this->entityManager = $entityManager;
        $this->inputFilter = $inputFilter;
        $this->halResponseFactory = $halResponseFactory;
        $this->resourceGenerator = $resourceGenerator;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $plot = Plot::createFromArray($request->getParsedBody(), $this->inputFilter);
        $this->entityManager->persist($plot);
        $this->entityManager->flush();

        return $this->halResponseFactory->createResponse(
            $request,
            $this->resourceGenerator->fromObject($plot, $request)
        );

    }
}
