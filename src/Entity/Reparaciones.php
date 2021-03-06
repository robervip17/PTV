<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReparacionesRepository")
 */
class Reparaciones
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
    private $tipoReparacion;

    /**
     * @ORM\Column(type="text")
     */
    private $realizacion;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Coches", inversedBy="matricula")
     */
    private $coche;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $id_user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $fecha;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipoReparacion(): ?string
    {
        return $this->tipoReparacion;
    }

    public function setTipoReparacion(string $tipoReparacion): self
    {
        $this->tipoReparacion = $tipoReparacion;

        return $this;
    }

    public function getRealizacion(): ?string
    {
        return $this->realizacion;
    }

    public function setRealizacion(string $realizacion): self
    {
        $this->realizacion = $realizacion;

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

    public function getCoche(): ?Coches
    {
        return $this->coche;
    }

    public function setCoche(?Coches $coche): self
    {
        $this->coche = $coche;

        return $this;
    }

    public function getIdUser(): ?string
    {
        return $this->id_user;
    }

    public function setIdUser(?string $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }
}
