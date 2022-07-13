<?php

namespace App\Entity;

use App\Repository\ContentsCategoriesRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @ORM\Entity(repositoryClass=ContentsCategoriesRepository::class)
 */
class ContentsCategories
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
    private $category_id;

    /**
     * @ORM\ManyToOne(targetEntity=Contents::class, inversedBy="contentsCategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $content;

    /**
     * (mapping="contentsCategories", fileNameProperty="category_id")
     */
    private $Category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory_id(): ?Integer
    {
        return $this->category_id;
    }

    public function setCategory_id($category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getContent(): ?Contents
    {
        return $this->content;
    }

    public function setContent(?Contents $content): self
    {
        $this->content = $content;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getCategory(){
        return $this->Category;
    }

    /**
     * @param mixed $Category
     * @throws \Exception
     */
    public function setCategory($Category): void{
        $this->Category = $Category;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }
}
