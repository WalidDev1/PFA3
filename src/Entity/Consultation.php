<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConsultationRepository::class)
 */
class Consultation
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
    private $ShowAt;

    /**
     * @ORM\ManyToOne(targetEntity=Offre::class, inversedBy="consultations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Offre;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="consultations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShowAt(): ?\DateTimeInterface
    {
        return $this->ShowAt;
    }

    public function setShowAt(\DateTimeInterface $ShowAt): self
    {
        $this->ShowAt = $ShowAt;

        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->Offre;
    }

    public function setOffre(?Offre $Offre): self
    {
        $this->Offre = $Offre;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
