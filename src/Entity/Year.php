<?php

namespace App\Entity;

use App\Repository\YearRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=YearRepository::class)
 */
class Year
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
    private $production_year;

    /**
     * @ORM\OneToMany(targetEntity=Automobile::class, mappedBy="year")
     */
    private $automobiles;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\ManyToMany(targetEntity=Modele::class, mappedBy="year")
     */
    private $modeles;

    public function __construct()
    {
        $this->automobiles = new ArrayCollection();
        $this->modeles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductionYear(): ?string
    {
        return $this->production_year;
    }

    public function setProductionYear(string $production_year): self
    {
        $this->production_year = $production_year;

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
            $automobile->setYear($this);
        }

        return $this;
    }

    public function removeAutomobile(Automobile $automobile): self
    {
        if ($this->automobiles->removeElement($automobile)) {
            // set the owning side to null (unless already changed)
            if ($automobile->getYear() === $this) {
                $automobile->setYear(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Modele[]
     */
    public function getModeles(): Collection
    {
        return $this->modeles;
    }

    public function addModele(Modele $modele): self
    {
        if (!$this->modeles->contains($modele)) {
            $this->modeles[] = $modele;
            $modele->addYear($this);
        }

        return $this;
    }

    public function removeModele(Modele $modele): self
    {
        if ($this->modeles->removeElement($modele)) {
            $modele->removeYear($this);
        }

        return $this;
    }

    public function __toString()
  {
    return $this->getProductionYear();
  }
}
