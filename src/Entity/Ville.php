<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VilleRepository::class)
 */
class Ville
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
    private $nom;

    /**
     * @ORM\Column(type="float")
     */
    private $log;

    /**
     * @ORM\Column(type="float")
     */
    private $lat;

    /**
     * @ORM\OneToMany(targetEntity=quartier::class, mappedBy="ville", orphanRemoval=true)
     */
    private $quartiers;

    public function __construct()
    {
        $this->quartiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLog(): ?float
    {
        return $this->log;
    }

    public function setLog(float $log): self
    {
        $this->log = $log;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * @return Collection|quartier[]
     */
    public function getQuartiers(): Collection
    {
        return $this->quartiers;
    }

    public function addQuartier(quartier $quartier): self
    {
        if (!$this->quartiers->contains($quartier)) {
            $this->quartiers[] = $quartier;
            $quartier->setVille($this);
        }

        return $this;
    }

    public function removeQuartier(quartier $quartier): self
    {
        if ($this->quartiers->contains($quartier)) {
            $this->quartiers->removeElement($quartier);
            // set the owning side to null (unless already changed)
            if ($quartier->getVille() === $this) {
                $quartier->setVille(null);
            }
        }

        return $this;
    }
}
