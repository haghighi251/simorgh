<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesRepository")
 */
class Categories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    public $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $type;

    /**
     * @ORM\Column(type="integer", length=3, nullable=true)
     *
     */
    public $parent;

    /**
     * @ORM\Column(type="integer", options={"default" : 0}, nullable=true), targetEntity="App\Entity\Categories"
     */
    private $level;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     */
    private $create_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity=Post::class, mappedBy="categories")
     *
     */
    private $post;

    /**
     * @ORM\ManyToMany(targetEntity=Products::class, mappedBy="categories")
     *
     */
    private $product;


    public function __construct()
    {
        // $this->contents = new ArrayCollection();
        $this->post = new ArrayCollection();
        $this->product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getParent(): ?int
    {
        return $this->parent;
    }

    public function setParent(int $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

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

    public function getCreateAt(): ?DateTimeInterface
    {
        return $this->create_at;
    }

    public function setCreateAt(DateTimeInterface $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * Return all Post associated to the category.
     *
     * @return Post[]
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set all Post in the category.
     *
     * @param Post[] $Post
     */
    public function setPosts($Post)
    {
        $this->post->clear();
        $this->post = new ArrayCollection($Post);
    }

    /**
     * Add a Post in the category.
     *
     * @param $Post Post The Post to associate
     */
    public function addPost($Post)
    {
        if ($this->post->contains($Post)) {
            return;
        }

        $this->post->add($Post);
        $Post->addCategory($this);
    }

    /**
     * @param Post $Post
     */
    public function removePost($Post)
    {
        if (!$this->post->contains($Post)) {
            return;
        }

        $this->post->removeElement($Post);
        $Post->removeCategory($this);
    }


    /**
     * Return all Products associated to the category.
     *
     * @return Products[]
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set all Products in the category.
     *
     * @param Products[] $Product
     */
    public function setProduct($Product)
    {
        $this->product->clear();
        $this->product = new ArrayCollection($Product);
    }

    /**
     * Add a Products in the category.
     *
     * @param $product Products The Products to associate
     */
    public function addProduct($Product)
    {
        if ($this->product->contains($Product)) {
            return;
        }

        $this->product->add($Product);
        $Product->addCategory($this);
    }

    /**
     * @param Products $Product
     */
    public function removeProduct($Product)
    {
        if (!$this->product->contains($Product)) {
            return;
        }

        $this->product->removeElement($Product);
        $Product->removeCategory($this);
    }

}
