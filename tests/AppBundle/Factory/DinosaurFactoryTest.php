<?php

namespace tests\AppBundle\Factory;

use PHPUnit\Framework\TestCase;
use App\Entity\Dinosaur;
use App\Factory\DinosaurFactory;

class DinosaurFactoryTest extends TestCase
{
    /**
     * @var DinosaurFactory
     */
    private $factory;

    /**
     * @var \ PHPUnit_Framework_MockObject_MockObject
     */
    private $LengthDeterminator;

    public function setUp(): void
    {
        $this->LengthDeterminator= $this->createMock(DinosaurLengthDeterminator::class);
        $this->factory = new DinosaurFactory($this->LengthDeterminator);
    }

    public function testItGrowsAVelociraptor()
    {
        $dinosaur = $this->factory->growVelociraptor(5);

        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
        // $this->assertInternalType('string', $dinosaur->getGenus());
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertSame(5, $dinosaur->getLength());
    }

    public function testItGrowsATriceratops()
    {
        $this->markTestIncomplete('Waiting for conformation from GenLab');

    }

    public function testItGrowsABabyvelociraptor()
    {

        if (!class_exists('Nanny')) {
            $this->markTestskipped('There is nobody to watch the baby');
        }
        $dinosaur = $this->factory->growVelociraptor(1);
        $this->assertSame(1, $dinosaur->getLength());
    }

    /**
     *
     * @dataProvider getSpecificationTests
     */
    public function testItGrowsADinosaurFromSpecification(string $spec, bool $expectedIsCarnivorous)
    {
        $this->LengthDeterminator->expects($this->once())
        ->methode('getLengthFromSpecification')
        ->with($spec)
        ->willReturn(20);

        $dinosaur = $this->factory->growFromSpecification($spec);
        
        $this->assertSame($expectedIsCarnivorous, $dinosaur->isCarnivorous(),'Diets do not match');
        $this->assertSame(20, $dinosaur->getLength());

    }

    public function getSpecificationTests()
    {
        return[
          ['large carnicorous dinosaur', true],
          'default response' =>['give me all the cookies!!!', false],  
          ['large herbivore', false], 
        ];
    }


}