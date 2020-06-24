<?php

namespace App\Entity;

use App\Repository\VendeurRegulierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VendeurRegulierRepository::class)
 */
class VendeurRegulier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateMutAt;

    /**
     * @ORM\OneToOne(targetEntity=Vendeur::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $vendeur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateMutAt(): ?\DateTimeInterface
    {
        return $this->dateMutAt;
    }

    public function setDateMutAt(\DateTimeInterface $dateMutAt): self
    {
        $this->dateMutAt = $dateMutAt;

        return $this;
    }

    public function getVendeur(): ?Vendeur
    {
        return $this->vendeur;
    }

    public function setVendeur(Vendeur $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }
}
