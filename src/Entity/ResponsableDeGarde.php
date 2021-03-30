<?php

namespace App\Entity;

use App\Repository\ResponsableDeGardeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResponsableDeGardeRepository::class)
 */
class ResponsableDeGarde
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $uniteSoin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telConsultation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telDomicile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telPortable;

    /**
     * @ORM\ManyToOne(targetEntity=UniteSoin::class, inversedBy="responsableDeGardes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $idUniteSoin;

    /**
     * @ORM\ManyToMany(targetEntity=Planning::class, mappedBy="responsable")
     */
    private $plannings;

    public function __construct()
    {
        $this->plannings = new ArrayCollection();
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

    public function getUniteSoin(): ?int
    {
        return $this->uniteSoin;
    }

    public function setUniteSoin(int $uniteSoin): self
    {
        $this->uniteSoin = $uniteSoin;

        return $this;
    }

    public function getTelConsultation(): ?string
    {
        return $this->telConsultation;
    }

    public function setTelConsultation(?string $telConsultation): self
    {
        $this->telConsultation = $telConsultation;

        return $this;
    }

    public function getTelDomicile(): ?string
    {
        return $this->telDomicile;
    }

    public function setTelDomicile(?string $telDomicile): self
    {
        $this->telDomicile = $telDomicile;

        return $this;
    }

    public function getTelPortable(): ?string
    {
        return $this->telPortable;
    }

    public function setTelPortable(?string $telPortable): self
    {
        $this->telPortable = $telPortable;

        return $this;
    }

    public function getIdUniteSoin(): ?UniteSoin
    {
        return $this->idUniteSoin;
    }

    public function setIdUniteSoin(?UniteSoin $idUniteSoin): self
    {
        $this->idUniteSoin = $idUniteSoin;

        return $this;
    }

    /**
     * @return Collection|Planning[]
     */
    public function getPlannings(): Collection
    {
        return $this->plannings;
    }

    public function addPlanning(Planning $planning): self
    {
        if (!$this->plannings->contains($planning)) {
            $this->plannings[] = $planning;
            $planning->addResponsable($this);
        }

        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        if ($this->plannings->removeElement($planning)) {
            $planning->removeResponsable($this);
        }

        return $this;
    }
    public function __toString (){
        return $this->nom;
    }
}
