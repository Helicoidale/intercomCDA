<?php

namespace App\Entity;

use App\Repository\PlanningRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlanningRepository::class)
 */
class Planning
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @ORM\Column(type="time")
     */
    private $dateHeureDebut;

    /**
     * @ORM\Column(type="time")
     */
    private $dateTimeFin;

    /**
     * @ORM\ManyToMany(targetEntity=ResponsableDeGarde::class, inversedBy="plannings")
     */
    private $responsable;

    /**
     * @ORM\ManyToMany(targetEntity=UniteSoin::class, inversedBy="plannings")
     */
    private $UniteSoin;

    public function __construct()
    {
        $this->responsable = new ArrayCollection();
        $this->UniteSoin = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDateTimeFin(): ?\DateTimeInterface
    {
        return $this->dateTimeFin;
    }

    public function setDateTimeFin(\DateTimeInterface $dateTimeFin): self
    {
        $this->dateTimeFin = $dateTimeFin;

        return $this;
    }

    /**
     * @return Collection|ResponsableDeGarde[]
     */
    public function getResponsable(): Collection
    {
        return $this->responsable;
    }

    public function addResponsable(ResponsableDeGarde $responsable): self
    {
        if (!$this->responsable->contains($responsable)) {
            $this->responsable[] = $responsable;
        }

        return $this;
    }

    public function removeResponsable(ResponsableDeGarde $responsable): self
    {
        $this->responsable->removeElement($responsable);

        return $this;
    }

    /**
     * @return Collection|UniteSoin[]
     */
    public function getUniteSoin(): Collection
    {
        return $this->UniteSoin;
    }

    public function addUniteSoin(UniteSoin $uniteSoin): self
    {
        if (!$this->UniteSoin->contains($uniteSoin)) {
            $this->UniteSoin[] = $uniteSoin;
        }

        return $this;
    }

    public function removeUniteSoin(UniteSoin $uniteSoin): self
    {
        $this->UniteSoin->removeElement($uniteSoin);

        return $this;
    }
}
