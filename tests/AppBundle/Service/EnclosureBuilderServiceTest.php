<?php

namespace tests\AppBundle\Service;

use PHPUnit\Framework\TestCase;
use App\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;

class EnclosureBuilderServiceTest extends TestCase
{
    public function testItBuildAndPersistsEnclosure()
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $em->expects($this->once())
           ->method('persist')
           ->with($this->isInstanceOf(Enclosure::class));

        $em->expects($this->AtleastOnce())
           ->method('flush');   

        $dinoFactory = $this->createMock(DinosaurFactory::class);

        $dinoFactory->expects($this->exactly(2))
                    ->method('growFromSpecification')
                    ->withReturn(new Dinosaur())
                    ->with($this->istype('string'));

        $builder = new EnclosureBuilderService($em, $dinoEntity);
        $enclosure = $builder->buildEnclosure(1, 2);

        $this->assertCount(1, $enclosure->getSecurities());
        $this->assertCount(1, $enclosure->getDinosaurs());
    }
}
