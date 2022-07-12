<?php

namespace App\Entity;

use App\Repository\PostMetaRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Controller\PostController;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\DependencyInjection\ContainerBuilder;


/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @var Categories[]
     * @ORM\ManyToMany(targetEntity="Categories", inversedBy="post")
     * @ORM\JoinTable(name="post_categories")
     */
    public $categories;

    /**
     * Features of the product.
     * Associative array, the key is the name/type of the feature, and the value the data.
     * Example:<pre>array(
     *     'size' => '13cm x 15cm x 6cm',
     *     'bluetooth' => '4.1'
     * )</pre>.
     *
     * @var array
     * @ORM\Column(type="array")
     */
    private $features = array();

    /**
     * @ORM\OneToMany(targetEntity=PostMeta::class, mappedBy="post", orphanRemoval=true,cascade={"persist"}))
     */
    private $postMetas;


    public $Price;

    public $color;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->postMetas = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Add a category in the product association.
     * (Owning side).
     *
     * @param $category Categories the category to associate
     */
    public function addCategory($category)
    {
        if ($this->categories->contains($category)) {
            return;
        }

        $this->categories->add($category);
        $category->addProduct($this);
    }

    /**
     * Remove a category in the product association.
     * (Owning side).
     *
     * @param $category Categories the category to associate
     */
    public function removeCategory($category)
    {
        if (!$this->categories->contains($category)) {
            return;
        }

        $this->categories->removeElement($category);
        $category->removeProduct($this);
    }

    /**
     * Set the list of features.
     * The parameter is an associative array (key as type, value as data.
     *
     * @param array $features
     */
    public function setFeatures($features)
    {
        $this->features = $features;
    }

    /**
     * Get all product features.
     *
     * @return array
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * @return Collection<int, PostMeta>
     */
    public function getPostMetas(): Collection
    {
        return $this->postMetas;
    }

    public function addPostMeta(PostMeta $postMeta): self
    {
        if (!$this->postMetas->contains($postMeta)) {
            $this->postMetas[] = $postMeta;
            $postMeta->setPost($this);
        }

        return $this;
    }

    public function removePostMeta(PostMeta $postMeta): self
    {
        if ($this->postMetas->removeElement($postMeta)) {
            // set the owning side to null (unless already changed)
            if ($postMeta->getPost() === $this) {
                $postMeta->setPost(null);
            }
        }

        return $this;
    }

    public function setPrice($price): self
    {
        if (null === $this->id) {
            $postMeta = new PostMeta();
            $postMeta->setMetaKey('price');
            $postMeta->setMetaValue($price);
            $this->postMetas[] = $postMeta;
            $postMeta->setPost($this);
        }
        $this->Price = $price;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        if (null !== $this->id) {
            $postMeta = new PostMeta();
            $postMeta->setPost($this);
            dd($postMeta);
            $postMetaRepository = new PostMetaRepository(parent()->em);
            $price = $postMetaRepository->findOneBy([
                'post_id'   =>$this->getId(),
                'meta_key' => 'price',
            ]);
            $this->setPrice($price);
        }
        return $this->Price;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): self
    {
        if (null === $this->id) {
            $postMeta = new PostMeta();
            $postMeta->setMetaKey('color');
            $postMeta->setMetaValue($color);
            $this->postMetas[] = $postMeta;
            $postMeta->setPost($this);
        }

        $this->color = $color;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }


}
