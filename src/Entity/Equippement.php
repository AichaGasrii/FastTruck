<?php

namespace App\Entity;

use App\Repository\EquippementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=EquippementRepository::class)
 */
class Equippement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=44, nullable=true)
     * @Assert\NotBlank(allowNull = true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Assert\NotBlank(allowNull = true)
     */
    private $metier;

    /**
     * @ORM\ManyToMany(targetEntity=Equipe::class, mappedBy="equipement")
     * @Assert\NotBlank(allowNull = true)
     */
    private $equipes;

    public function __construct()
    {
        $this->equipes = new ArrayCollection();
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
     * @return Collection|Equipe[]
     */
    public function getEquipes(): Collection
    {
        return $this->equipes;
    }

    public function addEquipe(Equipe $equipe): self
    {
        if (!$this->equipes->contains($equipe)) {
            $this->equipes[] = $equipe;
            $equipe->addEquipement($this);
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): self
    {
        if ($this->equipes->removeElement($equipe)) {
            $equipe->removeEquipement($this);
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nom;
    }
}
