<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="reservation")
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="date")
     */
    private ?DateTime $date;

    /**
     * @ORM\Column(type="time")
     */
    private ?DateTime $heure;

    /**
     * @ORM\Column(type="integer")
     */
    private int $nombrePersonnes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $allergie;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $emailReservation;

    // Getters et Setters


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHeure(): ?DateTime
    {
        return $this->heure;
    }

    public function setHeure(DateTime $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getNombrePersonnes(): ?int
    {
        return $this->nombrePersonnes;
    }

    public function setNombrePersonnes(int $nombrePersonnes): self
    {
        $this->nombrePersonnes = $nombrePersonnes;

        return $this;
    }

    public function getAllergie(): ?string
    {
        return $this->allergie;
    }

    public function setAllergie(?string $allergie): self
    {
        $this->allergie = $allergie;

        return $this;
    }


    public function getEmailReservation(): ?string
    {
        return $this->emailReservation;
    }

    public function setEmailReservation(string $emailReservation): self
    {
        $this->emailReservation = $emailReservation;

        return $this;
    }
}
