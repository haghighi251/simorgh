<?php

namespace App\Entity;

use App\Repository\AttachmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=AttachmentRepository::class)
 * @Vich\Uploadable
 */
class Attachment
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
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Contents::class, inversedBy="attachments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contents;

    /**
     * @Vich\UploadableField(mapping="attachments", fileNameProperty="image")
     */
    private $imageFile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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

    public function getContents(): ?Contents
    {
        return $this->contents;
    }

    public function setContents(?Contents $contents): self
    {
        $this->contents = $contents;

        return $this;
    }

    public function __construct(){
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getImageFile(){
        return $this->imageFile;
    }

    /**
     * @param mixed $imageFile
     * @throws \Exception
     */
    public function setImageFile($imageFile): void{
        $this->imageFile = $imageFile;
        if($imageFile){
            $this->updated_at = new \DateTime();
        }
    }
}
