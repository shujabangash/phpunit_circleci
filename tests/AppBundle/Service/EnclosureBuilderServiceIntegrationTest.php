<?php

namespace tests\AppBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Service\EnclosureBuilderService;
use App\Entity\Dinosaur;
use App\Factory\DinosaurFactory;
use App\Entity\Security;
use Doctrine\ORM\EntityManagerInterface;


class EnclosureBuilderServiceIntegrationTest extends KernelTestCase
{

    protected function setUp(): void
    {
        self::bootKernal();

        $this->truncateEntities();
    }

    public function testItBuildsEnclosureWithDefaultSpecification()

    {
        /**
          * @var EnclosureBuilderSercvice $enclosurebuilderservice
          */
        // $enclosureBuilderService = self::$kernal->getContainer()
        //         ->get(EnclosureBuilderService::class); 

        $dinoFactory = $this->createMock(DinosaurFactory::class);
        $dinoFactory->expects($this->any()) 
                 ->method('growFromSpecification')
                 ->willReturnCallBack(function($spec){
                    return new Dinosaur();
                 });

        $enclosureBuilderService = new EnclosureBuilderService(
            $this->getEntityManager(),
            $dinoFactory
        );


        $enclosurebuilderservice->builderEnclosure();
        $em = $this->getEntityManager();

        $count = (int) $em->getRepository(Security::class)
                 ->createQueryBuilder('s')
                 ->select('COUNT(s.id)')
                 ->getQuery()
                 ->getSingleScalarResult();

        $this->assertSame(1, $count, 'Amount of security systems is no the same');

        $count = (int) $em->getRepository(Dinosaur::class)
                 ->createQueryBuilder('d')
                 ->select('COUNT(d.id)')
                 ->getQuery()
                 ->getSingleScalarResult();

        $this->assertSame(3, $count, 'Amount of dinosaur is no the same');
    }

    private function truncateEntities()
    {
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purger();
    }

    /**
      * @var EntityManager
      */
    private function getEntityManager()
    {
        return self::$kernal->getContainer()
                    ->get('doctrine')
                    ->getManager();
    }
}