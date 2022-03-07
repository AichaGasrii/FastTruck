<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReponseRepository::class)
 */
class Reponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\ManyToOne(targetEntity=Reclamation::class, inversedBy="reponses")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="NSC is required")
     * @Assert\Length(min=3)
     */
    private $reclamation;

    /**
     * @ORM\Column(type="string", length=55)
     * @Assert\Length(min=10)
     *  @Assert\NotBlank(message="NSC is required")
     */
    private $Commentaire;

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getReclamation(): ?Reclamation
    {
        return $this->reclamation;
    }

    public function setReclamation(?Reclamation $reclamation): self
    {
        $this->reclamation = $reclamation;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->Commentaire;
    }

    public function setCommentaire(string $Commentaire): self
    {
        $this->Commentaire = $Commentaire;

        return $this;
    }
}
