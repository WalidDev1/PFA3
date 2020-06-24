<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffreRepository::class)
 */
class Offre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Vendeur::class, inversedBy="Offre")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vendeur;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("get:readA")
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("get:readA")
     */
    private $Description;

    /**
     * @ORM\Column(type="float")
     * @Groups("get:readA")
     */
    private $prix;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("get:readA")
     */
    private $createAt;

   

    /**
     * @ORM\Column(type="integer")
     * @Groups("get:readA")
     */
    private $NombreEtage;

    /**
     * @ORM\Column(type="integer")
     * @Groups("get:readA")
     */
    private $NombreSalleBain;

    /**
     * @ORM\Column(type="float")
     * @Groups("get:readA")
     */
    private $Surface;

    /**
     * @ORM\Column(type="integer")
     * @Groups("get:readA")
     */
    private $Verdure;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("get:readA")
     */
    private $ConstruiteAt;

    /**
     * @ORM\Column(type="integer")
     * @Groups("get:readA")
     */
    private $NombreParking;

    /**
     * @ORM\ManyToOne(targetEntity=Quartier::class, inversedBy="offres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quartier;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="offre")
     */
    private $images;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $Statue;

    /**
     * @ORM\OneToMany(targetEntity=Consultation::class, mappedBy="Offre", orphanRemoval=true)
     */
    private $consultations;

    /**
     * @ORM\OneToMany(targetEntity=Signalement::class, mappedBy="offre", orphanRemoval=true)
     */
    private $signalements;

    /**
     * @ORM\Column(type="integer")
     */
    private $piece;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="offres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeImmobilier;

    /**
     * @ORM\ManyToOne(targetEntity=TypeContrat::class, inversedBy="offres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $TypeContrat;

    /**
     * @ORM\OneToMany(targetEntity=Aime::class, mappedBy="Offre", orphanRemoval=true)
     */
    private $aimes;

    

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->consultations = new ArrayCollection();
        $this->signalements = new ArrayCollection();
        $this->aimes = new ArrayCollection();
    }

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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    

    public function getNombreEtage(): ?int
    {
        return $this->NombreEtage;
    }

    public function setNombreEtage(int $NombreEtage): self
    {
        $this->NombreEtage = $NombreEtage;

        return $this;
    }

    public function getNombreSalleBain(): ?int
    {
        return $this->NombreSalleBain;
    }

    public function setNombreSalleBain(int $NombreSalleBain): self
    {
        $this->NombreSalleBain = $NombreSalleBain;

        return $this;
    }

    public function getSurface(): ?float
    {
        return $this->Surface;
    }

    public function setSurface(float $Surface): self
    {
        $this->Surface = $Surface;

        return $this;
    }

    public function getVerdure(): ?int
    {
        return $this->Verdure;
    }

    public function setVerdure(int $Verdure): self
    {
        $this->Verdure = $Verdure;

        return $this;
    }

    public function getConstruiteAt(): ?\DateTimeInterface
    {
        return $this->ConstruiteAt;
    }

    public function setConstruiteAt(\DateTimeInterface $ConstruiteAt): self
    {
        $this->ConstruiteAt = $ConstruiteAt;

        return $this;
    }

    public function getNombreParking(): ?int
    {
        return $this->NombreParking;
    }

    public function setNombreParking(int $NombreParking): self
    {
        $this->NombreParking = $NombreParking;

        return $this;
    }

    public function getQuartier(): ?Quartier
    {
        return $this->quartier;
    }

    public function setQuartier(?Quartier $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setOffre($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getOffre() === $this) {
                $image->setOffre(null);
            }
        }

        return $this;
    }

    public function getStatue(): ?string
    {
        return $this->Statue;
    }

    public function setStatue(string $Statue): self
    {
        $this->Statue = $Statue;

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
            $consultation->setOffre($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): self
    {
        if ($this->consultations->contains($consultation)) {
            $this->consultations->removeElement($consultation);
            // set the owning side to null (unless already changed)
            if ($consultation->getOffre() === $this) {
                $consultation->setOffre(null);
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
            $signalement->setOffre($this);
        }

        return $this;
    }

    public function removeSignalement(Signalement $signalement): self
    {
        if ($this->signalements->contains($signalement)) {
            $this->signalements->removeElement($signalement);
            // set the owning side to null (unless already changed)
            if ($signalement->getOffre() === $this) {
                $signalement->setOffre(null);
            }
        }

        return $this;
    }

    public function getPiece(): ?int
    {
        return $this->piece;
    }

    public function setPiece(int $piece): self
    {
        $this->piece = $piece;

        return $this;
    }

    public function getTypeImmobilier(): ?Category
    {
        return $this->typeImmobilier;
    }

    public function setTypeImmobilier(?Category $typeImmobilier): self
    {
        $this->typeImmobilier = $typeImmobilier;

        return $this;
    }

    public function getTypeContrat(): ?TypeContrat
    {
        return $this->TypeContrat;
    }

    public function setTypeContrat(?TypeContrat $TypeContrat): self
    {
        $this->TypeContrat = $TypeContrat;

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
            $aime->setOffre($this);
        }

        return $this;
    }

    public function removeAime(Aime $aime): self
    {
        if ($this->aimes->contains($aime)) {
            $this->aimes->removeElement($aime);
            // set the owning side to null (unless already changed)
            if ($aime->getOffre() === $this) {
                $aime->setOffre(null);
            }
        }

        return $this;
    }

   
}
