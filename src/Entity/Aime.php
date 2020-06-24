<?php

namespace App\Entity;

use App\Repository\AimeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AimeRepository::class)
 */
class Aime
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Offre::class, inversedBy="aimes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("post:aime")
     */
    private $Offre;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="aimes" )
     */
    private $Client;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getClient(): ?Client
    {
        return $this->Client;
    }

    public function setClient(?Client $Client): self
    {
        $this->Client = $Client;

        return $this;
    }
}
