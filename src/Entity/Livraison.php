<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LivraisonRepository")
 */
class Livraison
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="livraisons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Livraieur::class, inversedBy="livraisons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $livraieur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Produit")
     */
    private $produit;

    protected $captchaCode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client")
     */
    private $adrliv;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $numl;


    /**
     * @ORM\Column(type="string", length=50)
     */
    private $total;

    /**
     * @ORM\Column(type="date")
     */
    private $dateliv;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getNuml(): ?string
    {
        return $this->numl;
    }

    public function setNuml(string $numl): self
    {
        $this->numl = $numl;

        return $this;
    }






    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }
    public function getLivraieur(): ?livraieur
    {
        return $this->livraieur;
    }

    public function setLivraieur(?Livraieur $livraieur): self
    {
        $this->livraieur = $livraieur;

        return $this;
    }
    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }
    public function getAdrliv(): ?Client
    {
        return $this->adrliv;
    }

    public function setAdrliv(?Client $adrliv): self
    {
        $this->adrliv = $adrliv;

        return $this;
    }
    public function getdateliv(): ?DateTimeInterface
    {
        return $this->dateliv;
    }

    public function setdateliv(\DateTimeInterface $dateliv): self
    {
        $this->dateliv = $dateliv;

        return $this;
    }
    public function getCaptchaCode()
    {
        return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
        $this->captchaCode = $captchaCode;
    }
}