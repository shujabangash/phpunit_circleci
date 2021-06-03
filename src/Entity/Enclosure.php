<?php

namespace App\Entity;

use App\Repository\EnclosureRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Security;
use App\Entity\Dinosaur;
use App\Exception\DinosaurAreRunningRampantException;

/**
 * @ORM\Entity(repositoryClass=EnclosureRepository::class)
 * 
 */
class Enclosure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Collection
     * @ORM\Column(type="array")
     * @ORM\OneToMany(targetEntity="App\Entity\Dinosaur", mappedBy="enclosure", cascade={"persist"})
     */
    private $dinosaurs;

    /**
     * @var Collection|Security[]
     * @ORM\OneToMany(targetEntity="App\Entity\Security", mappedBy="enclosure", cascade={"persist"})
     *
     */
    private $securities;

    public function __construct(bool $withBasicSecurity = false)
    {
        $this->securities = new ArrayCollection();
        $this->dinosaurs = new ArrayCollection();

        if ($withBasicSecurity) {
            $this->addSecurity(new Security('Fence', true, $this));
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDinosaurs(): collection
    {
        return $this->dinosaurs;
    }

    public function setDinosaurs(array $dinosaurs): self
    {
        $this->dinosaurs = $dinosaurs;

        return $this;
    }

    public function addDinosaur(Dinosaur $dinosaur)
    {
        if (!$this->canAddDinosaur($dinosaur)) {
            throw new NotAbuffetException();         
        }
        if (!$this->isSecurityActive()) {
            throw new DinosaurAreRunningRampantException('Are you Crazy?');  
        }
    }

    public function addSecurity(Security $security)
    {
        $this->securities[] = $security; 
    }

    public function isSecurityActive(): bool
    {
        foreach ($this->securities as $security) {
            if ($security->getIsActive()) {
                return true;
            }
        }

        return false;
    }

    public function getSecurities(): Collection
    {
        return $this->securities;
    }

    private function canAddDinosaur(Dinosaur $dinosaur): bool 
    {
        return count($this->dinosaurs) ===0
        || $this->dinosaur->first()->isCarnivorous() === $dinosaur->isCarnivorous();

    }

    public function getDinosaurCount(): int
    {
        return $this->dinosaurs->count();
    }

}
