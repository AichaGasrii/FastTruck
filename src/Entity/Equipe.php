<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EquipeRepository::class)
 */
class Equipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)

     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     * @Assert\NotBlank(allowNull = true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank(allowNull = true)
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     * @Assert\NotBlank(allowNull = true)
     * @Assert\Positive
     */
    private $metier;

    /**
     * @ORM\ManyToMany(targetEntity=Equippement::class, inversedBy="equipes")
     * @Assert\NotBlank(allowNull = true)
     */
    private $equipement;

    public function __construct()
    {
        $this->equipement = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getMetier(): ?string
    {
        return $this->metier;
    }

    public function setMetier(?string $metier): self
    {
        $this->metier = $metier;

        return $this;
    }

    /**
     * @return Collection|Equippement[]
     */
    public function getEquipement(): Collection
    {
        return $this->equipement;
    }

    public function addEquipement(Equippement $equipement): self
    {
        if (!$this->equipement->contains($equipement)) {
            $this->equipement[] = $equipement;
        }

        return $this;
    }

    public function removeEquipement(Equippement $equipement): self
    {
        $this->equipement->removeElement($equipement);

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}
