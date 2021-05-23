<?php

namespace App\Entity;

use App\Repository\AutomobileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AutomobileRepository::class)
 */
class Automobile
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
    private $n_immatriculation;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $proprietaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cin_MF;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $n_chassis;

    /**
     * @ORM\Column(type="integer")
     */
    private $puiss_fiscale;

    /**
     * @ORM\Column(type="date")
     */
    private $dpmc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Kilometrage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Etat::class, inversedBy="automobiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Energie::class, inversedBy="automobiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $energie;

    /**
     * @ORM\ManyToOne(targetEntity=Modele::class, inversedBy="automobiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $modele;

    /**
     * @ORM\ManyToOne(targetEntity=Marque::class, inversedBy="automobiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $marque;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="automobiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=Year::class, inversedBy="automobiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $year;

    /**
     * @ORM\OneToMany(targetEntity=AutomobileHistory::class, mappedBy="n_immatriculation")
     */
    private $automobileHistories;

    public function __construct()
    {
        $this->automobileHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNImmatriculation(): ?string
    {
        return $this->n_immatriculation;
    }

    public function setNImmatriculation(string $n_immatriculation): self
    {
        $this->n_immatriculation = $n_immatriculation;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getProprietaire(): ?string
    {
        return $this->proprietaire;
    }

    public function setProprietaire(string $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCinMF(): ?string
    {
        return $this->cin_MF;
    }

    public function setCinMF(string $cin_MF): self
    {
        $this->cin_MF = $cin_MF;

        return $this;
    }

    public function getNChassis(): ?string
    {
        return $this->n_chassis;
    }

    public function setNChassis(string $n_chassis): self
    {
        $this->n_chassis = $n_chassis;

        return $this;
    }

    public function getPuissFiscale(): ?int
    {
        return $this->puiss_fiscale;
    }

    public function setPuissFiscale(int $puiss_fiscale): self
    {
        $this->puiss_fiscale = $puiss_fiscale;

        return $this;
    }

    public function getDpmc(): ?\DateTimeInterface
    {
        return $this->dpmc;
    }

    public function setDpmc(\DateTimeInterface $dpmc): self
    {
        $this->dpmc = $dpmc;

        return $this;
    }

    public function getKilometrage(): ?string
    {
        return $this->Kilometrage;
    }

    public function setKilometrage(string $Kilometrage): self
    {
        $this->Kilometrage = $Kilometrage;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getEnergie(): ?Energie
    {
        return $this->energie;
    }

    public function setEnergie(?Energie $energie): self
    {
        $this->energie = $energie;

        return $this;
    }

    public function getModele(): ?Modele
    {
        return $this->modele;
    }

    public function setModele(?Modele $modele): self
    {
        $this->modele = $modele;

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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getYear(): ?Year
    {
        return $this->year;
    }

    public function setYear(?Year $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function __toString()
    {
      return $this->getNImmatriculation()();
    }
    
}
