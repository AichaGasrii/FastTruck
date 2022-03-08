<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     *  @Assert\Length(
     *  min= 4,
     *  max= 20
     *  )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *  min= 20,
     *  max= 60
     *  )
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * )
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @Assert\NotBlank
     */
    private $category;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $Quantite;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $Discount=null;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $Initial_Price;

    /**
     * @param $id
     * @param $name
     * @param $description
     * @param $price
     * @param $image
     * @param $category
     * @param $Quantite
     */


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->Quantite;
    }

    public function setQuantite(?int $Quantite): self
    {
        $this->Quantite = $Quantite;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->Discount;
    }

    public function setDiscount(?float $Discount): self
    {
        $this->Discount = $Discount;

        return $this;
    }

    public function getInitialPrice(): ?float
    {
        return $this->Initial_Price;
    }

    public function setInitialPrice(?float $Initial_Price): self
    {
        $this->Initial_Price = $Initial_Price;

        return $this;
    }
}
