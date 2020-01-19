<?php

declare(strict_types=1);

namespace Plots\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Plots\Entity\Plot;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class PlotsReadHandler implements RequestHandlerInterface
{
    private $entityManager;
    private $halResponseFactory;
    private $resourceGenerator;

    public function __construct(
        EntityManagerInterface $entityManager,
        HalResponseFactory $halResponseFactory,
        ResourceGenerator $resourceGenerator)
    {
        $this->entityManager = $entityManager;
        $this->halResponseFactory = $halResponseFactory;
        $this->resourceGenerator = $resourceGenerator;

    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute("id", NULL);
        
        $plot = $this->entityManager->getRepository(Plot::class)->find($id);
        
        return $this->halResponseFactory->createResponse(
            $request,
            $this->resourceGenerator->fromObject($plot, $request)
        );
    }
}
