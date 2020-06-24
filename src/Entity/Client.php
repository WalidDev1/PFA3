<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
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
     * @ORM\OneToMany(targetEntity=Aime::class, mappedBy="Client")
     */
    private $aimes;

    public function __construct()
    {
        $this->aimes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Aime[]
     */
    public function getAimes(): Collection
    {
        return $this->aimes;
    }

    public function addAime(Aime $aime): self
    {
        if (!$this->aimes->contains($aime)) {
            $this->aimes[] = $aime;
            $aime->setClient($this);
        }

        return $this;
    }

    public function removeAime(Aime $aime): self
    {
        if ($this->aimes->contains($aime)) {
            $this->aimes->removeElement($aime);
            // set the owning side to null (unless already changed)
            if ($aime->getClient() === $this) {
                $aime->setClient(null);
            }
        }

        return $this;
    }
}
