<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatRepository::class)
 */
class Etat
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
    private $nom_etat;

    /**
     * @ORM\OneToMany(targetEntity=Automobile::class, mappedBy="etat")
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

    public function getNomEtat(): ?string
    {
        return $this->nom_etat;
    }

    public function setNomEtat(string $nom_etat): self
    {
        $this->nom_etat = $nom_etat;

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
            $automobile->setEtat($this);
        }

        return $this;
    }

    public function removeAutomobile(Automobile $automobile): self
    {
        if ($this->automobiles->removeElement($automobile)) {
            // set the owning side to null (unless already changed)
            if ($automobile->getEtat() === $this) {
                $automobile->setEtat(null);
            }
        }

        return $this;
    }

    public function __toString()
  {
    return $this->getNomEtat();
  }
}
