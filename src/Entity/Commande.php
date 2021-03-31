<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Cassandra\Date;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\produit")
     */
    private $produit;

    /**
     * @ORM\Column(type="integer")
     */
    private $numCom;

    protected $captchaCode;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=client::class, inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;



    /**
     * @ORM\Column(type="float")
     */
    private $total;

    public function getProduit(): ?produit
    {
        return $this->produit;
    }

    public function setProduit(?produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCom(): ?int
    {
        return $this->numCom;
    }

    public function setNumCom(int $numCom): self
    {
        $this->numCom = $numCom;

        return $this;
    }

    public function getdate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setdate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getClient(): ?client
    {
        return $this->client;
    }

    public function setClient(?client $client): self
    {
        $this->client = $client;

        return $this;
    }



    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

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
