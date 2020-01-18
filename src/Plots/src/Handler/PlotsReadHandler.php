<?php

declare(strict_types=1);

namespace Plots\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Plots\Entity\Plot;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class PlotsReadHandler implements RequestHandlerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $plots = $this->entityManager->getRepository(Plot::class)->findAll();

        return new JsonResponse([124234]);
    }
}
