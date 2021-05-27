<?php

namespace App\Entity;

class SearchByMarque
{

    
    private $marque;

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }
}
