<?php

namespace App\Entity;

use App\Repository\PreferenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PreferenceRepository::class)
 */
class Preference
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
    private $sexes_recherches;

    /**
     * @ORM\Column(type="integer")
     */
    private $departements_recherches;

    /**
     * @ORM\Column(type="integer")
     */
    private $tranche_age_recherche;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSexesRecherches(): ?string
    {
        return $this->sexes_recherches;
    }

    public function setSexesRecherches(string $sexes_recherches): self
    {
        $this->sexes_recherches = $sexes_recherches;

        return $this;
    }

    public function getDepartementsRecherches(): ?int
    {
        return $this->departements_recherches;
    }

    public function setDepartementsRecherches(int $departements_recherches): self
    {
        $this->departements_recherches = $departements_recherches;

        return $this;
    }

    public function getTrancheAgeRecherche(): ?int
    {
        return $this->tranche_age_recherche;
    }

    public function setTrancheAgeRecherche(int $tranche_age_recherche): self
    {
        $this->tranche_age_recherche = $tranche_age_recherche;

        return $this;
    }
}
