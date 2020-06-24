<?php

namespace App\Entity;

use App\Repository\AgenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgenceRepository::class)
 */
class Agence
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
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToOne(targetEntity=Images::class, cascade={"persist", "remove"})
     */
    private $imageLogo;

    /**
     * @ORM\OneToOne(targetEntity=Vendeur::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Vendeur;



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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImageLogo(): ?Images
    {
        return $this->imageLogo;
    }

    public function setImageLogo(?Images $imageLogo): self
    {
        $this->imageLogo = $imageLogo;

        return $this;
    }

    public function getVendeur(): ?Vendeur
    {
        return $this->Vendeur;
    }

    public function setVendeur(Vendeur $Vendeur): self
    {
        $this->Vendeur = $Vendeur;

        return $this;
    }


}
