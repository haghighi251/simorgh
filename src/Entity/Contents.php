<?php

namespace App\Entity;

use App\Repository\ContentsRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ContentsRepository::class)
 * @Vich\Uploadable
 */
class Contents
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    public $content;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $content_status;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $comment_status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content_slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content_password;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $content_type;

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="content", orphanRemoval=true)
     */
    private $comment_count;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    public $content_image;

    public $ShortContent;

    public $Tags;

    public $Price;

    public $DiscountedPrice;

    public $WeightDimension;

    public $Weight;

    public $LengthDimension;

    public $Length;

    public $StockStatus;

    public $ProductCount;

    public $Note;

    /**
     * @ORM\OneToMany(targetEntity=Attachment::class, mappedBy="contents",cascade={"persist", "remove"})
     */
    private $attachments;

    /**
     * @ORM\OneToMany(targetEntity=ContentsCategories::class, mappedBy="content",cascade={"persist", "remove"})
     */
    private $contentsCategories;


    public function __construct()
    {
        $this->comment_count = new ArrayCollection();
        $this->attachments = new ArrayCollection();
        $this->contentsCategories = new ArrayCollection();
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

    public function getAuthor(): ?Users
    {
        return $this->author;
    }

    public function setAuthor(?Users $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getContentStatus(): ?string
    {
        return $this->content_status;
    }

    public function setContentStatus(string $content_status): self
    {
        $this->content_status = $content_status;

        return $this;
    }

    public function getCommentStatus(): ?string
    {
        return $this->comment_status;
    }

    public function setCommentStatus(string $comment_status): self
    {
        $this->comment_status = $comment_status;

        return $this;
    }

    public function getContentSlug(): ?string
    {
        return $this->content_slug;
    }

    public function setContentSlug(string $content_slug): self
    {
        $this->content_slug = $content_slug;

        return $this;
    }

    public function getContentPassword(): ?string
    {
        return $this->content_password;
    }

    public function setContentPassword(?string $content_password): self
    {
        $this->content_password = $content_password;

        return $this;
    }

    public function getContentType(): ?string
    {
        return $this->content_type;
    }

    public function setContentType(string $content_type): self
    {
        $this->content_type = $content_type;

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getCommentCount(): Collection
    {
        return $this->comment_count;
    }

    public function addCommentCount(Comments $commentCount): self
    {
        if (!$this->comment_count->contains($commentCount)) {
            $this->comment_count[] = $commentCount;
            $commentCount->setContentId($this);
        }

        return $this;
    }

    public function removeCommentCount(Comments $commentCount): self
    {
        if ($this->comment_count->removeElement($commentCount)) {
            // set the owning side to null (unless already changed)
            if ($commentCount->getContentId() === $this) {
                $commentCount->setContentId(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

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

    public function getImage(): ?string
    {
        return $this->content_image;
    }

    public function setImage(?string $content_image): self
    {
        $this->content_image = $content_image;

        return $this;
    }

    public function getTags()
    {
    }

    public function getPrice()
    {
    }

    public function getDiscountedPrice()
    {
    }

    public function getWeightDimension()
    {
    }

    public function getWeight()
    {
    }

    public function getLengthDimension()
    {
    }

    public function getLength()
    {
    }

    public function getStockStatus()
    {
    }

    public function getProductCount()
    {
    }

    public function getNote()
    {
    }

    public function getShortContent()
    {
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
            if ($attachment->getContents() === $this) {
                $attachment->setContents(null);
            }
        }

        return $this;
    }

    public $Categories;

    public function getCategories()
    {
        return $this->Categories;
    }

    public function setCategories($category)
    {
        $this->Categories = $category;
    }

    /**
     * @return Collection<int, ContentsCategories>
     */
    public function getContentsCategories(): Collection
    {
        return $this->contentsCategories;
    }

    public function addContentsCategory(ContentsCategories $contentsCategory): self
    {
        if (!$this->contentsCategories->contains($contentsCategory)) {
            $this->contentsCategories[] = $contentsCategory;
            $contentsCategory->setContent($this);
        }

        return $this;
    }

    public function removeContentsCategory(ContentsCategories $contentsCategory): self
    {
        if ($this->contentsCategories->removeElement($contentsCategory)) {
            // set the owning side to null (unless already changed)
            if ($contentsCategory->getContent() === $this) {
                $contentsCategory->setContent(null);
            }
        }

        return $this;
    }


}
