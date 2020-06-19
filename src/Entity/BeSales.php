<?php

namespace App\Entity;

use App\Repository\BeSalesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BeSalesRepository::class)
 */
class BeSales
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(name="id_product")
     */
    private $Product;

    /**
     * @ORM\ManyToOne(targetEntity=ProductSale::class)
     * @ORM\JoinColumn(name="id_productSale")
     */
    private $ProductSale;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(string $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->Product;
    }

    public function setProduct(?Product $Product): self
    {
        $this->Product = $Product;

        return $this;
    }

    public function getProductSale(): ?ProductSale
    {
        return $this->ProductSale;
    }

    public function setProductSale(?ProductSale $ProductSale): self
    {
        $this->ProductSale = $ProductSale;

        return $this;
    }
}
