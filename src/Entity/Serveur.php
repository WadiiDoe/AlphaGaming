<?php

namespace App\Entity;

use App\Repository\ServeurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServeurRepository::class)
 */
class Serveur
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
    private $adr_sv;

    /**
     * @ORM\Column(type="text" , nullable=true)
     */
    private $description_sv;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_sv;

    /**
     * @ORM\ManyToOne(targetEntity=Jeux::class, inversedBy="serveur_front")
     * @ORM\JoinColumn(nullable=true)
     */
    private $jeux;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdrSv(): ?string
    {
        return $this->adr_sv;
    }

    public function setAdrSv(string $adr_sv): self
    {
        $this->adr_sv = $adr_sv;

        return $this;
    }

    public function getDescriptionSv(): ?string
    {
        return $this->description_sv;
    }

    public function setDescriptionSv(string $description_sv): self
    {
        $this->description_sv = $description_sv;

        return $this;
    }

    public function getNomSv(): ?string
    {
        return $this->nom_sv;
    }

    public function setNomSv(string $nom_sv): self
    {
        $this->nom_sv = $nom_sv;

        return $this;
    }

    public function getJeux(): ?Jeux
    {
        return $this->jeux;
    }

    public function setJeux(?Jeux $jeux): self
    {
        $this->jeux = $jeux;

        return $this;
    }
}
