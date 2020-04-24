<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CochesRepository")
 */
class Coches
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
    private $marca;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modelo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\reparaciones", mappedBy="coche")
     */
    private $matricula;

    public function __construct()
    {
        $this->matricula = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarca(): ?string
    {
        return $this->marca;
    }

    public function setMarca(string $marca): self
    {
        $this->marca = $marca;

        return $this;
    }

    public function getModelo(): ?string
    {
        return $this->modelo;
    }

    public function setModelo(string $modelo): self
    {
        $this->modelo = $modelo;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): self
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * @return Collection|reparaciones[]
     */
    public function getMatricula(): Collection
    {
        return $this->matricula;
    }

    public function addMatricula(reparaciones $matricula): self
    {
        if (!$this->matricula->contains($matricula)) {
            $this->matricula[] = $matricula;
            $matricula->setCoche($this);
        }

        return $this;
    }

    public function removeMatricula(reparaciones $matricula): self
    {
        if ($this->matricula->contains($matricula)) {
            $this->matricula->removeElement($matricula);
            // set the owning side to null (unless already changed)
            if ($matricula->getCoche() === $this) {
                $matricula->setCoche(null);
            }
        }

        return $this;
    }
}
