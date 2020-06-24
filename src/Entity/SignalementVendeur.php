<?php

namespace App\Entity;

use App\Repository\SignalementVendeurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SignalementVendeurRepository::class)
 */
class SignalementVendeur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Vendeur::class, inversedBy="signalementVendeurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vendeur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVendeur(): ?Vendeur
    {
        return $this->vendeur;
    }

    public function setVendeur(?Vendeur $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }
}
