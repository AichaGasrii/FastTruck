<?php

namespace App\Entity;

use App\Repository\StocksRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StocksRepository::class)
 */
class Stocks
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
    private $qte_prod;

    /**
     * @ORM\Column(type="string", length=49)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $numerof;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix_unitaire;

    /**
     * @ORM\Column(type="integer")
     */
    private $idprod;

    /**
     * @ORM\ManyToOne(targetEntity=Fournisseur::class, inversedBy="stocks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fournisseur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQteProd(): ?int
    {
        return $this->qte_prod;
    }

    public function setQteProd(?int $qte_prod): self
    {
        $this->qte_prod = $qte_prod;

        return $this;
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

    public function getNumerof(): ?int
    {
        return $this->numerof;
    }

    public function setNumerof(?int $numerof): self
    {
        $this->numerof = $numerof;

        return $this;
    }

    public function getPrixUnitaire(): ?int
    {
        return $this->prix_unitaire;
    }

    public function setPrixUnitaire(?int $prix_unitaire): self
    {
        $this->prix_unitaire = $prix_unitaire;

        return $this;
    }

    public function getIdprod(): ?int
    {
        return $this->idprod;
    }

    public function setIdprod(?int $idprod): self
    {
        $this->idprod = $idprod;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }
}
