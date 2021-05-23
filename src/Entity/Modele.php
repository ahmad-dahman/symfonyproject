<?php

namespace App\Entity;

use App\Repository\ModeleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModeleRepository::class)
 */
class Modele
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
    private $nom_modele;

    /**
     * @ORM\OneToMany(targetEntity=Automobile::class, mappedBy="modele")
     */
    private $automobiles;

    /**
     * @ORM\ManyToOne(targetEntity=Marque::class, inversedBy="modeles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $marque;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\ManyToMany(targetEntity=Year::class, inversedBy="modeles")
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="modeles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    public function __construct()
    {
        $this->automobiles = new ArrayCollection();
        $this->year = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomModele(): ?string
    {
        return $this->nom_modele;
    }

    public function setNomModele(string $nom_modele): self
    {
        $this->nom_modele = $nom_modele;

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
            $automobile->setModele($this);
        }

        return $this;
    }

    public function removeAutomobile(Automobile $automobile): self
    {
        if ($this->automobiles->removeElement($automobile)) {
            // set the owning side to null (unless already changed)
            if ($automobile->getModele() === $this) {
                $automobile->setModele(null);
            }
        }

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * @return Collection|Year[]
     */
    public function getYear(): Collection
    {
        return $this->year;
    }

    public function addYear(Year $year): self
    {
        if (!$this->year->contains($year)) {
            $this->year[] = $year;
        }

        return $this;
    }

    public function removeYear(Year $year): self
    {
        $this->year->removeElement($year);

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function __toString()
  {
    return $this->getNomModele();
  }
}
