<?php

namespace App\Entity;

class SearchBymatricule
{

    
    private $n_immatriculation;

    public function getNImmatriculation(): ?string
    {
        return $this->n_immatriculation;
    }

    public function setNImmatriculation(string $n_immatriculation): self
    {
        $this->n_immatriculation = $n_immatriculation;

        return $this;
    }
}
