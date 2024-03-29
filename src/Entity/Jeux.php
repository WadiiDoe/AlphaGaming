<?php

namespace App\Entity;

use App\Repository\JeuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=JeuxRepository::class)
 */
class Jeux
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $release_date;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $qte_jeux;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please upload image")
     * @Assert\File(mimeTypes={"image/jpeg"})
     */
    private $img;
    /**
     * @ORM\OneToMany(targetEntity=Serveur::class, mappedBy="jeux_front")
     */
    private $serveur;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $bg_color;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $border_color;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $text_color;



    public function __construct()
    {
        $this->serveur = new ArrayCollection();
        $this->rating = new ArrayCollection();
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

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(?\DateTimeInterface $release_date): self
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQteJeux(): ?int
    {
        return $this->qte_jeux;
    }

    public function setQteJeux(int $qte_jeux): self
    {
        $this->qte_jeux = $qte_jeux;

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

    public function getImg()
    {
        return $this->img;
    }

    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }
    /**
     * @return Collection|Serveur[]
     */
    public function getServeur(): Collection
    {
        return $this->serveur;
    }

    public function addServeur(Serveur $serveur): self
    {
        if (!$this->serveur->contains($serveur)) {
            $this->serveur[] = $serveur;
            $serveur->setJeux($this);
        }

        return $this;
    }

    public function removeServeur(Serveur $serveur): self
    {
        if ($this->serveur->removeElement($serveur)) {
            // set the owning side to null (unless already changed)
            if ($serveur->getJeux() === $this) {
                $serveur->setJeux(null);
            }
        }

        return $this;
    }

    public function getBgColor(): ?string
    {
        return $this->bg_color;
    }

    public function setBgColor(?string $bg_color): self
    {
        $this->bg_color = $bg_color;

        return $this;
    }

    public function getBorderColor(): ?string
    {
        return $this->border_color;
    }

    public function setBorderColor(?string $border_color): self
    {
        $this->border_color = $border_color;

        return $this;
    }

    public function getTextColor(): ?string
    {
        return $this->text_color;
    }

    public function setTextColor(?string $text_color): self
    {
        $this->text_color = $text_color;

        return $this;
    }


}
