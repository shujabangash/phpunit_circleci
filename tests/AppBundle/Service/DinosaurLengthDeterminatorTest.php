<?php

namespace tests\AppBundle\Service;
use App\Service\DinosaurLengthDeterminator;
use PHPUnit\Framework\TestCase;
use App\Entity\Dinosaur;

class DinosaurLengthDeterminatorTest extends TestCase
{
    /**
     * @dataProvider getSpecLengthTest
     */
    public function testItReturnsCorrectLengthRange($spec, $minExpectedSize, $maxExpectedSize)
    {
        $determine = new DinosaurLengthDeterminator();
        $actualSize = $determintor->getLengthFromSpecification($spec);

        $this->assertGreaterThanOrEqual($minExpectedSize, $actualSize);
        $this->assertlessThanOrEqual($maxExpectedSize, $actualSize);
    }

    public function getSpecLengthTest()
    {
        return[
          ['large carnicorous dinosaur',Dinosaur::LARGE, Dinosaur::HUGE -1],
          'default response' =>['give me all the cookies!!!', 0, Dinosaur::LARGE -1],  
          ['large herbivore', Dinosaur::LARGE, Dinosaur::HUGE -1], 
          ['huge dinosaur', Dinosaur::HUGE, 100],
          ['huge dino', Dinosaur::HUGE, 100],
          ['huge', Dinosaur::HUGE, 100],
          ['OMG', Dinosaur::HUGE, 100],
          ['emoji', Dinosaur::HUGE, 100],
        ];
    }
}