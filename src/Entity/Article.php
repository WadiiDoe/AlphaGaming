<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Costraint\NotBlank;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $titre_article;

    /**
     * @ORM\Column(type="text")
     *  @Assert\NotBlank()
     */
    private $contenu_article;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please upload image")
     * @Assert\File(mimeTypes={"image/jpeg"})
     */
    private $img_article;

    /**
     * @ORM\Column(type="date")
     *  @Assert\NotBlank()
     */
    private $date_article;

    /**
     * @ORM\Column(type="integer")
     *  @Assert\NotBlank()
     */
    private $nbr_article;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreArticle(): ?string
    {
        return $this->titre_article;
    }

    public function setTitreArticle(string $titre_article): self
    {
        $this->titre_article = $titre_article;

        return $this;
    }

    public function getContenuArticle(): ?string
    {
        return $this->contenu_article;
    }

    public function setContenuArticle(string $contenu_article): self
    {
        $this->contenu_article = $contenu_article;

        return $this;
    }

    public function getImgArticle()
    {
        return $this->img_article;
    }

    public function setImgArticle($img_article)
    {
        $this->img_article = $img_article;

        return $this;
    }

    public function getDateArticle(): ?\DateTimeInterface
    {
        return $this->date_article;
    }

    public function setDateArticle(\DateTimeInterface $date_article): self
    {
        $this->date_article = $date_article;

        return $this;
    }

    public function getNbrArticle(): ?int
    {
        return $this->nbr_article;
    }

    public function setNbrArticle(int $nbr_article): self
    {
        $this->nbr_article = $nbr_article;

        return $this;
    }
}
