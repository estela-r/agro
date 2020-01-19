<?php

declare(strict_types=1);

namespace Plots\Entity;

use Doctrine\ORM\Mapping as ORM;
use DomainException;
use Plots\Exception\InvalidParameterException;
use Plots\Validator\PlotInputFilter;

/**
 * @ORM\Entity
 * @ORM\Table(name="plots")
 **/
class Plot
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
     * @ORM\Column(type="string", nullable=false)
     */
    protected $crop;

    /**
     * Plot area in sqaure meters.
     * 
     * @ORM\Column(type="decimal", nullable=false)
     */
    protected $area;


    private function __construct(string $name, string $crop, float $area) {
        
        if ($area <= 0) {
            
            throw new DomainException(sprintf("Invalid area: %s", $area));
        }

        $this->name = $name;
        $this->crop = $crop;
        $this->area = $area;
    }

    public function createFromArray(array $request, PlotInputFilter $inputFilter): self {
        
        $inputFilter->setData($request);

        if (! $inputFilter->isValid()) {

            throw InvalidParameterException::create('Invalid parameter', $inputFilter->getMessages());
        }

        return new self(
            $inputFilter->getValues()["name"],
            $inputFilter->getValues()["crop"],
            $inputFilter->getValues()["area"]
        );
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