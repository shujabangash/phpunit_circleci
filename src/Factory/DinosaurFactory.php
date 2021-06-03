<?php

namespace App\Factory;

use App\Entity\Dinosaur;

class DinosaurFactory
{
    
    private $lengthDeterminator;

    public function __construct(DinosaurLengthDeterminator $lengthDeterminator)
    {
        $this->lengthDeterminator = $lengthDeterminator;
    }

    public function growVelociraptor(int $length): Dinosaur
    {

        return $this->createDinosaur('Velociraptor', true, $length);
    }

    public function growFromSpecification(string $specification): Dinosaur
    {
        $codename = "InG-" . random_int(1,99999);
        $length = $this->lengthDeterminator->getLengthFromSpecification($specification);
        $isCarnivorous = false;

        if (stripos($specification, 'carnivorous') !== false) {
            $carnivorous = true;  
        }

        $dinosaur = $this->createDinosaur($codename, $isCarnivorous, $length);

        return $dinosaur;
    }

    private function createDinosaur(string $genus, bool $isCarnivorous, int $length): Dinosaur
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);
        $dinosaur->setLength($length);
        return $dinosaur;
    }   

}