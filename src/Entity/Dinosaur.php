<?php

namespace App\Entity;

use App\Repository\DinosaurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DinosaurRepository::class)
 */
class Dinosaur
{
    const LARGE = 20;

    const HUGE = 30;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $length;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $specification;

    /**
     * @ORM\Column(type="string")
     */
    private $genus;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCirnivorous;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Enclosure", inversedBy="dinosaur")
     */
    private $enclosure;

    public function __construct(string $genus = 'unknown', bool $isCirnivorous = false)
    {
        $this->genus = $genus;
        $this->isCirnivorous = $isCirnivorous;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getSpecification(): string
    {
        return sprintf(
            'The %s %scarnivorous dinosaur is %d meter long',
            $this->genus,
            $this->isCirnivorous ? '' : 'non-',
            $this->length
        );
    }

    public function setSpecification(string $specification): self
    {
        $this->specification = $specification;

        return $this;
    }

    public function getGenus(): string
    {
        return $this->genus;
    }

    public function isCarnivorous()
    {
        return $this->isCarnivorous;
    }

    public function setEnclosure(Enclosure $enclosure)
    {
        $this->enclosure = $enclosure;
    }
}
