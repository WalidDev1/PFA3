<?php

namespace App\Entity;

use App\Repository\VendeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VendeurRepository::class)
 */
class Vendeur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Offre::class, mappedBy="vendeur", orphanRemoval=false)
     */
    private $Offre;

    /**
     * @ORM\OneToMany(targetEntity=SignalementVendeur::class, mappedBy="vendeur", orphanRemoval=true)
     */
    private $signalementVendeurs;

    

    public function __construct()
    {
        $this->Offre = new ArrayCollection();
        $this->signalementVendeurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(user $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Offre[]
     */
    public function getOffre(): Collection
    {
        return $this->Offre;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->Offre->contains($offre)) {
            $this->Offre[] = $offre;
            $offre->setVendeur($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->Offre->contains($offre)) {
            $this->Offre->removeElement($offre);
            // set the owning side to null (unless already changed)
            if ($offre->getVendeur() === $this) {
                $offre->setVendeur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SignalementVendeur[]
     */
    public function getSignalementVendeurs(): Collection
    {
        return $this->signalementVendeurs;
    }

    public function addSignalementVendeur(SignalementVendeur $signalementVendeur): self
    {
        if (!$this->signalementVendeurs->contains($signalementVendeur)) {
            $this->signalementVendeurs[] = $signalementVendeur;
            $signalementVendeur->setVendeur($this);
        }

        return $this;
    }

    public function removeSignalementVendeur(SignalementVendeur $signalementVendeur): self
    {
        if ($this->signalementVendeurs->contains($signalementVendeur)) {
            $this->signalementVendeurs->removeElement($signalementVendeur);
            // set the owning side to null (unless already changed)
            if ($signalementVendeur->getVendeur() === $this) {
                $signalementVendeur->setVendeur(null);
            }
        }

        return $this;
    }


}
