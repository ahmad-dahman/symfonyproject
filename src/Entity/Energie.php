<?php

namespace App\Entity;

use App\Repository\EnergieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnergieRepository::class)
 */
class Energie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_energie;

    /**
     * @ORM\OneToMany(targetEntity=Automobile::class, mappedBy="energie")
     */
    private $automobiles;

    public function __construct()
    {
        $this->automobiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEnergie(): ?string
    {
        return $this->nom_energie;
    }

    public function setNomEnergie(string $nom_energie): self
    {
        $this->nom_energie = $nom_energie;

        return $this;
    }

    /**
     * @return Collection|Automobile[]
     */
    public function getAutomobiles(): Collection
    {
        return $this->automobiles;
    }

    public function addAutomobile(Automobile $automobile): self
    {
        if (!$this->automobiles->contains($automobile)) {
            $this->automobiles[] = $automobile;
            $automobile->setEnergie($this);
        }

        return $this;
    }

    public function removeAutomobile(Automobile $automobile): self
    {
        if ($this->automobiles->removeElement($automobile)) {
            // set the owning side to null (unless already changed)
            if ($automobile->getEnergie() === $this) {
                $automobile->setEnergie(null);
            }
        }

        return $this;
    }

    public function __toString()
  {
    return $this->getNomEnergie();
  }
}
