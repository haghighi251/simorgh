<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ProductsRepository::class)
 * @Vich\Uploadable
 */
class Products
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $author_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceOnSale;

    /**
     * @ORM\Column(type="integer")
     */
    private $tax;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $features = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var Categories[]
     * @ORM\ManyToMany(targetEntity="Categories", inversedBy="product")
     * @ORM\JoinTable(name="products_categories")
     */
    public $categories;

    /**
     * @ORM\OneToMany(targetEntity=Attachment::class, mappedBy="products",cascade={"persist", "remove"})
     */
    private $attachments;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->attachments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorId(): ?int
    {
        return $this->author_id;
    }

    public function setAuthorId(int $author_id): self
    {
        $this->author_id = $author_id;

        return $this;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPriceOnSale(): ?int
    {
        return $this->priceOnSale;
    }

    public function setPriceOnSale(?int $priceOnSale): self
    {
        $this->priceOnSale = $priceOnSale;

        return $this;
    }

    public function getTax(): ?int
    {
        return $this->tax;
    }

    public function setTax(int $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getFeatures(): ?array
    {
        return $this->features;
    }

    public function setFeatures(?array $features): self
    {
        $this->features = $features;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
     * @return Collection<int, Attachment>
     */
    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function addAttachment(Attachment $attachment): self
    {
        if (!$this->attachments->contains($attachment)) {
            $this->attachments[] = $attachment;
            $attachment->setContents($this);
        }

        return $this;
    }

    public function removeAttachment(Attachment $attachment): self
    {
        if ($this->attachments->removeElement($attachment)) {
            // set the owning side to null (unless already changed)
            if ($attachment->setProducts() === $this) {
                $attachment->setProducts(null);
            }
        }

        return $this;
    }

}
