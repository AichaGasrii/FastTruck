<?php

namespace App\Entity;

use App\Repository\PersonnelRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\FormTypeInterface;

/**
 * @ORM\Entity(repositoryClass=PersonnelRepository::class)
 */
class Personnel extends Users
{

    /**
     * @ORM\Column(type="float")
     */
    private $salaire;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $role;

    /**
     * @ORM\Column(type="float")
     */
    public $nbre_heures;

    /**
     * @ORM\Column(type="integer")
     */
    public $matricule_truck;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSalaire(): ?float
    {
        return $this->salaire;
    }

    public function setSalaire(float $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getNbreHeures(): ?float
    {
        return $this->nbre_heures;
    }

    public function setNbreHeures(float $nbre_heures): self
    {
        $this->nbre_heures = $nbre_heures;

        return $this;
    }

    public function getMatriculeTruck(): ?int
    {
        return $this->matricule_truck;
    }

    public function setMatriculeTruck(int $matricule_truck): self
    {
        $this->matricule_truck = $matricule_truck;

        return $this;
    }
}
