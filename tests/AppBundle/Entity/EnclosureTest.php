<?php

namespace tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Enclosure;
use App\Exception\NotAbuttetException;
use App\Entity\Dinosaur;
use App\Exception\DinosaurAreRunningRampantException;

class EnclosureTest extends TestCase
{
    public function testItHasNoDinosaurByDefault()
    {
        $enclosure = new Enclosure();
        $this->assertEmpty($enclosure->getDinosaurs());
    }

    public function testItAddsDinosaur()
    {
        $enclosure = new Enclosure(true);
        $enclosure->addDinosaur(new Dinosaur());
        $enclosure->addDinosaur(new Dinosaur());

        $this->assertCount(2, $enclosure->getDinosaurs());
    }

    public function testItDoesNotAllowCarnivorousDinosaursToMixWithHerbivores()
    {
        $enclosure = new Enclosure(true);
        $enclosure->addDinosaur(new Dinosaur());
        $this->expectException(NotAbuttetException::class);

        $enclosure->addDinosaur(new Dinosaur('velociraptor',true));
    }

     /**
      *@expectedException \App\Exception/NotAbuttetException
      */
     public function testItDoesNotAllowToAddNonCarnivorousDinosaursToCarnivorousEnclosure()
    {
        $enclosure = new Enclosure(true);
        $enclosure->addDinosaur(new Dinosaur('velociraptor',true));
        $enclosure->addDinosaur(new Dinosaur());
    }

    public function testItDoesNotAllowToAddDinosaursToUnsecureEnclosures()
    {
        $enclosure = new Enclosure();
        $this->expectException(DinosaurAreRunningRampantException::class);
        $this->expectExceptionMessage('Are you Crazy?');

        $enclosure->addDinosaur(new Dinosaur());
    }
}