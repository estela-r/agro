<?php

declare(strict_types=1);

namespace Tillage\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Exceptions\InvalidParameterException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Tillage\Entity\Tillage;
use Tractors\Entity\Tractor;
use Zend\Diactoros\Response\JsonResponse;


class ListTillageHandler implements RequestHandlerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $tillage = $this->entityManager->getRepository(Tillage::class)->list();

        $result = [
            'records' => $tillage,
            'sum' => 666
        ];
        return new JsonResponse($result);
    }
}
