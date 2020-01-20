<?php

declare(strict_types=1);

namespace TillageTest\Entity;

use DomainException;
use PHPUnit\Framework\TestCase;
use Plots\Entity\Plot;
use Tillage\Entity\Tillage;
use Tractors\Entity\Tractor;

class TillageTest extends TestCase
{

    /**
     *  @expectedException DomainException
     */
    public function testThatTillageCannotExceedPlotArea()
    {
        $tractor = $this->createMock(Tractor::class);

        $plot = $this->createMock(Plot::class);

        $plot->method("getArea")->willReturn(1);

        $tillage = new Tillage($tractor, $plot, 2);       
    }

    
    public function testThatTillageCanBeEqualToPlotArea()
    {
        $tractor = $this->createMock(Tractor::class);

        $plot = $this->createMock(Plot::class);

        $plot->method("getArea")->willReturn(2);

        $tillage = new Tillage($tractor, $plot, 2); 
        
        $this->assertEquals($tillage->getArea(), 2);
    }
}
