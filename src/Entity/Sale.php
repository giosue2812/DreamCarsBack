<?php

namespace App\Entity;

use App\Repository\SaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
class Sale
{
    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sold;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sales")
     * @ORM\JoinColumn(name="id_user")
     */
    private $User;

    /**
     * @ORM\ManyToOne(targetEntity=PayementType::class, inversedBy="sales")
     * @ORM\JoinColumn(name="id_payement")
     */
    private $Payement;

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getPayement(): ?PayementType
    {
        return $this->Payement;
    }

    public function setPayement(?PayementType $Payement): self
    {
        $this->Payement = $Payement;

        return $this;
    }

}
