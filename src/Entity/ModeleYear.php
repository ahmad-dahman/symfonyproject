<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\ModeleYearRepository;
/**
 * @Entity
 */
class ModeleYear
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $modele_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $year_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModeleId(): ?int
    {
        return $this->modele_id;
    }

    public function setModeleId(int $modele_id): self
    {
        $this->modele_id = $modele_id;

        return $this;
    }

    public function getYearId(): ?int
    {
        return $this->year_id;
    }

    public function setYearId(int $year_id): self
    {
        $this->year_id = $year_id;

        return $this;
    }
}
