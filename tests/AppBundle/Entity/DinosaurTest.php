<?php

namespace tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Dinosaur;

class DinosaurTest extends TestCase
{

    public function testSettingLength()
    {
        $dinosaur = new Dinosaur();
        $this->assertSame(null,$dinosaur->getLength());  

        $dinosaur->setLength(9);
        $this->assertSame(9,$dinosaur->getLength());   
    }

    public function testDinosaurHasNotShrunk()
    {
        $dinosaur = new Dinosaur();
        $dinosaur->setLength(15);
        $this->assertGreaterThan(12,$dinosaur->getlength(),'Did you putting in the washing machine?');
    }

    public function testFullsSpecificationOfDinosaur()
    {
        $dinosaur = new Dinosaur();
        $this->assertSame(
            'The unknown non-carnivorous dinosaur is 0 meter long',
            $dinosaur->getSpecification()
        );
    }

    public function testReturnsFullSpecificationFortyrannosaurus()
    {
        $dinosaur = new Dinosaur('Tyrannosaurus',true);
        $dinosaur->setLength(12);
        $this->assertSame(
            'The Tyrannosaurus carnivorous dinosaur is 12 meter long',
            $dinosaur->getSpecification()
        );
    }

}