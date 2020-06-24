<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("Email")
 * @ApiResource
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups("post:read")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups("post:read")
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     */
    private $typeP;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups("post:read")
     */
    private $sexe;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("post:read")
     */
    private $telephone;

    /**
     * @ORM\Column( type="string", length=100 )
     * @Groups("post:read")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=40 , unique=true)
     * @Assert\Email()
     * @Groups("post:read")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=200)
     * @Groups("post:read")
     */
    private $pasword;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("post:read")
     */
    private $dateInscription;

    /**
     * @ORM\OneToOne(targetEntity=Images::class, cascade={"persist", "remove"})
     */
    private $image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $banne;

    /**
     * @ORM\OneToMany(targetEntity=Consultation::class, mappedBy="user", orphanRemoval=true)
     */
    private $consultations;

    /**
     * @ORM\OneToMany(targetEntity=Signalement::class, mappedBy="client", orphanRemoval=true)
     */
    private $signalements;

    public function __construct()
    {
        $this->consultations = new ArrayCollection();
        $this->signalements = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTypeP(): ?int
    {
        return $this->typeP;
    }

    public function setTypeP(int $typeP): self
    {
        $this->typeP = $typeP;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(?int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->pasword;
    }

    public function setPassword(string $pasword): self
    {
        $this->pasword = $pasword;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }



    public function eraseCredentials()
    {
        
    }

    public function getSalt()
    {
        
    }
    public function getUsername(){
        
    }
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getImage(): ?images
    {
        return $this->image;
    }

    public function setImage(?images $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getBanne(): ?bool
    {
        return $this->banne;
    }

    public function setBanne(bool $banne): self
    {
        $this->banne = $banne;

        return $this;
    }

    /**
     * @return Collection|Consultation[]
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultation $consultation): self
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations[] = $consultation;
            $consultation->setUser($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): self
    {
        if ($this->consultations->contains($consultation)) {
            $this->consultations->removeElement($consultation);
            // set the owning side to null (unless already changed)
            if ($consultation->getUser() === $this) {
                $consultation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Signalement[]
     */
    public function getSignalements(): Collection
    {
        return $this->signalements;
    }

    public function addSignalement(Signalement $signalement): self
    {
        if (!$this->signalements->contains($signalement)) {
            $this->signalements[] = $signalement;
            $signalement->setClient($this);
        }

        return $this;
    }

    public function removeSignalement(Signalement $signalement): self
    {
        if ($this->signalements->contains($signalement)) {
            $this->signalements->removeElement($signalement);
            // set the owning side to null (unless already changed)
            if ($signalement->getClient() === $this) {
                $signalement->setClient(null);
            }
        }

        return $this;
    }
}
