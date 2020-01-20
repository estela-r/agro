<?php

declare(strict_types=1);

namespace Tillage\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use Plots\Entity\Plot;
use Tractors\Entity\Tractor;

/**
 * @ORM\Entity(repositoryClass="TillageRepository")
 * @ORM\Table(name="tillage")
 **/
class Tillage
{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;


    /**
     * @ORM\ManyToOne(targetEntity="Tractors\Entity\Tractor", inversedBy="tillage")
     * @ORM\JoinColumn(name="tractor_id", referencedColumnName="id")
     */    
    protected $tractor;
    
    /**
     * @ORM\ManyToOne(targetEntity="Plots\Entity\Plot", inversedBy="tillage")
     * @ORM\JoinColumn(name="plot_id", referencedColumnName="id")
     */     
    protected $plot;

    /**
     * Plot area in sqaure meters.
     * 
     * @ORM\Column(type="decimal", nullable=false)
     */
    protected $area;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;


    public function __construct(Tractor $tractor, Plot $plot, float $area) {
        
        if ($area > $plot->getArea()) {
            
            throw new DomainException(sprintf("Tillage area %s exceeds plot area %s", $area, $plot->getArea()));
        }

        $this->tractor = $tractor;
        $this->plot = $plot;
        $this->area = $area;
        $this->createdAt = new DateTime();
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
    public function getTractor(): Tractor
    {
        return $this->tractor;
    }
 
    public function getArea(): float
    {
        return $this->area;
    }

}