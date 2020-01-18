<?php

declare(strict_types=1);

namespace Plots\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Plots\Entity\Plot;
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
        // try {
            //TODO test with empty request body etc
            $plot = Plot::createFromRequest($request->getParsedBody());
            $this->entityManager->persist($plot);
            $this->entityManager->flush();

            $resource = $this->resourceGenerator->fromObject($plot, $request);

            return $this->halResponseFactory->createResponse($request, $resource);

        // } catch(Exception $e) {

        //     return new JsonResponse(["error" => "afsd"], 400);
        // }

    }
}
