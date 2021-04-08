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
     * @ORM\ManyToOne(targetEntity=ResponsableDeGarde::class, inversedBy="plannings")
     */
    private $responsable;

    /**
     * @ORM\ManyToOne(targetEntity=UniteSoin::class, inversedBy="plannings")
     */
    private $UniteSoin;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroDeSaisie;


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


    public function getResponsable()
    {
        return $this->responsable;
    }

    public function setResponsable(ResponsableDeGarde $responsable): self
    {
        $this->responsable = $responsable;
        return $this;
    }


    public function getUniteSoin()
    {
        return $this->UniteSoin;
    }

    public function setUniteSoin(UniteSoin $uniteSoin): self
    {
        $this->UniteSoin = $uniteSoin;

        return $this;
    }


    public function getNumeroDeSaisie(): ?int
    {
        return $this->numeroDeSaisie;
    }

    public function setNumeroDeSaisie(int $numeroDeSaisie): self
    {
        $this->numeroDeSaisie = $numeroDeSaisie;

        return $this;
    }
}
