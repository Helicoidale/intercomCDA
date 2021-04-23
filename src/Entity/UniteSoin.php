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
     * @ORM\OneToMany(targetEntity=Planning::class, mappedBy="UniteSoin", orphanRemoval=true)
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
            $planning->setUniteSoin($this);
        }

        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        if($this->plannings->removeElement($planning)){
            if($planning->getUniteSoin()===$this){
                $planning->setUniteSoin(null);
            }
        };


        return $this;
    }

    public function __toString()
    {
        return $this->nom." ".$this->description;
    }

}
