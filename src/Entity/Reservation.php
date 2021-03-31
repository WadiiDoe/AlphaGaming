<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Reservation")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Evenement", inversedBy="Reservation")
     * @ORM\JoinColumn(name="idevent", referencedColumnName="id",onDelete="CASCADE")
     */
    private $idevent;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }
    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $nbrplace;

    /**
     * @ORM\Column(type="boolean")
     */
    private $approuve;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getApprouve()
    {
        return $this->approuve;
    }

    /**
     * @param mixed $approuve
     */
    public function setApprouve($approuve): void
    {
        $this->approuve = $approuve;
    }



    public function getIdevent()
    {
        return $this->idevent;
    }

    public function setIdevent( $idevent)
    {
        $this->idevent = $idevent;

        return $this;
    }



    /**
     * @return mixed
     */
    public function getNbrplace()
    {
        return $this->nbrplace;
    }



    /**
     * @param mixed $nbrplace
     */
    public function setNbrplace($nbrplace): void
    {
        $this->nbrplace = $nbrplace;
    }
}
