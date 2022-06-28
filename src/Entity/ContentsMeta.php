<?php

namespace App\Entity;

use App\Repository\ContentsMetaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContentsMetaRepository::class)
 */
class ContentsMeta
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $meta_name;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $meta_value;

    /**
     * @ORM\ManyToOne(targetEntity=Contents::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $content_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMetaName(): ?string
    {
        return $this->meta_name;
    }

    public function setMetaName(string $meta_name): self
    {
        $this->meta_name = $meta_name;

        return $this;
    }

    public function getMetaValue(): ?string
    {
        return $this->meta_value;
    }

    public function setMetaValue(?string $meta_value): self
    {
        $this->meta_value = $meta_value;

        return $this;
    }

    public function getContentId(): ?Contents
    {
        return $this->content_id;
    }

    public function setContentId(?Contents $content_id): self
    {
        $this->content_id = $content_id;

        return $this;
    }
}
