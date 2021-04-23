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
     * @ORM\OneToMany(targetEntity=Planning::class, mappedBy="responsable", orphanRemoval=true)
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
            $planning->setResponsable($this);
        }
        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        if ($this->plannings->removeElement($planning)) {
            if ($planning->getResponsable() === $this) {
                $planning->setResponsable(null);
            }
        }
        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}
