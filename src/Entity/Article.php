<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * NormalizationContext permet de faire la serialization dans API
 * ItemOperation permet de parametrer les operations sur un Article (getArticle(id),modifierArticle(id) et deleteArticle(id)
 * collectionOperation permet de parametrer les operations sur l'ensemble des Articles Get pour avoir la liste et Post pour ajouter un Article
 *
 * @ApiResource(
 *     normalizationContext={"groups"="read:Article:collection"},
 *     denormalizationContext={"groups"="write:Article"},
 *     collectionOperations={"get","post"}
 *     itemOperations={
 *                  "put",
 *                  "delete",
 *                  "get"={
 *                      "normalization_context"={
 *                                               "groups"={"read:Article:item","read:Article:collection","read:Article:Category"}}
 *                  }
 *     }
 *
 * )
 *
 *
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:Article:collection"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:Article:collection","write:Article"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"read:Article:item","write:Article"})
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:Article:collection","write:Article"})
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:Article:item"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read:Article:item","write:Article"})
     */
    private $category;

    public function __construct(){
        $this->updated_at = new \DateTime();
        $this->created_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
