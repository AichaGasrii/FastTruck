<?php

namespace App\Entity;

use App\Repository\PackRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PackRepository::class)
 */
class Pack
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
    private $numcommande;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumcommande(): ?string
    {
        return $this->numcommande;
    }

    public function setNumcommande(?string $numcommande): self
    {
        $this->numcommande = $numcommande;

        return $this;
    }

}
