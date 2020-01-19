<?php

declare(strict_types=1);

namespace Tractors\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Tractors\Entity\Tractor;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;
use Zend\InputFilter\InputFilterInterface;

class CreateTractorHandler implements RequestHandlerInterface
{
    private $entityManager;
    private $halResponseFactory;
    private $resourceGenerator;
    private $inputFilter;

    public function __construct(
        EntityManagerInterface $entityManager,
        InputFilterInterface $inputFilter,
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
        $plot = Tractor::createFromArray($request->getParsedBody(), $this->inputFilter);
        $this->entityManager->persist($plot);
        $this->entityManager->flush();

        return $this->halResponseFactory->createResponse(
            $request,
            $this->resourceGenerator->fromObject($plot, $request)
        );

    }
}
