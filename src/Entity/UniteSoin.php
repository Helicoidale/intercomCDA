<?php

namespace App\Entity;

use App\Repository\UniteSoinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UniteSoinRepository::class)
 */
class UniteSoin
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
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $infoTel;

    /**
     * @ORM\OneToMany(targetEntity=ResponsableDeGarde::class, mappedBy="idUniteSoin")
     */
    private $responsableDeGardes;

    /**
     * @ORM\ManyToMany(targetEntity=Planning::class, mappedBy="UniteSoin")
     */
    private $plannings;

    public function __construct()
    {
        $this->responsableDeGardes = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getInfoTel(): ?string
    {
        return $this->infoTel;
    }

    public function setInfoTel(?string $infoTel): self
    {
        $this->infoTel = $infoTel;

        return $this;
    }

    /**
     * @return Collection|ResponsableDeGarde[]
     */
    public function getResponsableDeGardes(): Collection
    {
        return $this->responsableDeGardes;
    }

    public function addResponsableDeGarde(ResponsableDeGarde $responsableDeGarde): self
    {
        if (!$this->responsableDeGardes->contains($responsableDeGarde)) {
            $this->responsableDeGardes[] = $responsableDeGarde;
            $responsableDeGarde->setIdUniteSoin($this);
        }

        return $this;
    }

    public function removeResponsableDeGarde(ResponsableDeGarde $responsableDeGarde): self
    {
        if ($this->responsableDeGardes->removeElement($responsableDeGarde)) {
            // set the owning side to null (unless already changed)
            if ($responsableDeGarde->getIdUniteSoin() === $this) {
                $responsableDeGarde->setIdUniteSoin(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom." ".$this->description;
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
            $planning->addUniteSoin($this);
        }

        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        if ($this->plannings->removeElement($planning)) {
            $planning->removeUniteSoin($this);
        }

        return $this;
    }

}
