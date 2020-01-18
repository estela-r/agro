<?php

declare(strict_types=1);

namespace Plots\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="decimal", nullable=false)
     */
    protected $area;


    private function __construct(string $name, string $crop, float $area) {
        $this->name = $name;
        $this->crop = $crop;
        $this->area = $area;
    }

    public function createFromRequest(array $request) {
        //TODO: validate area
        $area = floatval($request["area"]);
        
        return new self($request["name"], $request["crop"], $area);
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

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

}