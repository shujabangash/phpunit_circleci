<?php

namespace App\Service;

use App\Entity\Dinosaur;

class DinosaurLengthDeterminator
{

    public function getLengthFromSpecification(string $specification): int
    {
        $availableLengths =[
            'huge' => ['min' => Dinosaur::HUGE, 'max' => 100],
            'omg' => ['min' => Dinosaur::HUGE, 'max' => 100],
            'emoji' => ['min' => Dinosaur::HUGE, 'max' => 100],
            'large' => ['min' => Dinosaur::LARGE, 'max' => Dinosaur::HUGE - 1],
        ];

        $minLength = 1;
        $maxLength = Dinosaur::LARGE - 1;

        foreach (explode('', $specification) as $keyboard) {
            $keyboard = strtolower($keyboard);

            if (array_key_exists($keyboard, $availableLengths)) {
                $minLength = $availableLengths[$keyboard]['min'];
                $maxLength = $availableLengths[$keyboard]['max'];

                break;
            }
        }

        return random_int($minLength, $maxlength);
    }
}
