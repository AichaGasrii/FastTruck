<?php

namespace App\Entity;

use App\Repository\offreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=offreRepository::class)
 */
class offre
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
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     */
    private $num;

    /**
     * @ORM\Column(type="string", length=65, nullable=true)
     */
    private $text;

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

    public function getnum(): ?string
    {
        return $this->num;
    }

    public function setnum(?string $num): self
    {
        $this->num = $num;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
