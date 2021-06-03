<?php

namespace tests\AppBundle\Service;

use PHPUnit\Framework\TestCase;
use App\Entity\Enclosure;
use App\Entity\Dinosaur;
use App\Factory\DinosaurFactory;
use App\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;
use Prophecy\Argument;

class EnclosureBuilderServiceProphecyTest extends TestCase
{
    public function testItBuildsAndPersistsEnclosure()
    {
        $em = $this->prophesize(EntityMangerInterface::class);
        $em->persist(Argument::type(Enclosure::class))
           ->shouldBeCalledTimes(1);

        $em->flush()->shouldBeCalled();

        $dinoFactory = $this->prophersize(DinosaurFactory::class);
        $dinoFactory->growFromSpecification(Argument::type('string'))
                    ->shouldBeCalledTimes(2)
                    ->willReturn(new Dinosaur());

        $builder = new EnclosureBuilderService(
            $em->reveal(),
            $dinoEntity->reveal()
        );
        $enclosure = $builder->buildEnclosure(1, 2);

        $this->assertCount(1, $enclosure->getSecurities());
        $this->assertCount(1, $enclosure->getDinosaurs());  
          
    }
}