<?php

declare(strict_types=1);

namespace Tractors\Entity;

use Doctrine\ORM\Mapping as ORM;
use DomainException;
use Exceptions\InvalidParameterException;
use Tractors\Validator\TractorInputFilter;

/**
 * @ORM\Entity
 * @ORM\Table(name="tractors")
 **/
class Tractor
{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Tillage\Entity\Tillage", mappedBy="tractor")
     */
    private $tillage;

    private function __construct(string $name) {
        
        if (!$name) {
            
            throw new DomainException(sprintf("Invalid name: %s", $name));
        }

        $this->name = $name;
    }

    public function createFromArray(array $request, TractorInputFilter $inputFilter): self {
        
        $inputFilter->setData($request);

        if (! $inputFilter->isValid()) {

            throw InvalidParameterException::create('Invalid parameter', $inputFilter->getMessages());
        }

        return new self($inputFilter->getValues()["name"]);
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}