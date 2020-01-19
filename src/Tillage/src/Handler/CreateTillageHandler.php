<?php

declare(strict_types=1);

namespace Tillage\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Exceptions\InvalidParameterException;
use Plots\Entity\Plot;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Tillage\Entity\Tillage;
use Tractors\Entity\Tractor;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;
use Zend\InputFilter\InputFilterInterface;

class CreateTillageHandler implements RequestHandlerInterface
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

        $this->inputFilter->setData($request->getParsedBody());

        if (! $this->inputFilter->isValid()) {

            throw InvalidParameterException::create('Invalid parameter', $this->inputFilter->getMessages());
        }

        $tractorId = $this->inputFilter->getValues()["tractor_id"];
        $plotId = $this->inputFilter->getValues()["plot_id"];
        $area = $this->inputFilter->getValues()["area"];
        
        $tractor = $this->entityManager->getRepository(Tractor::class)->find($tractorId);
        $plot = $this->entityManager->getRepository(Plot::class)->find($plotId);
            
        $tillage = new Tillage($tractor, $plot, $area);

        $this->entityManager->persist($tillage);
        $this->entityManager->flush();

        return $this->halResponseFactory->createResponse(
            $request,
            $this->resourceGenerator->fromObject($tillage, $request)
        );

    }
}
